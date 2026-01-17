<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Cat;
use App\Models\Address;
use App\Models\Booking;
use App\Models\BookingCat;
use App\Models\Payment;
use App\Models\SitterEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function create($sitter_id)
    {
        $sitter = User::where('role', 'sitter')
                     ->where('id', $sitter_id)
                     ->with(['sitterProfile', 'addresses'])
                     ->firstOrFail();

        // Get user's registered cats
        $registeredCats = Cat::where('user_id', Auth::id())
                            ->where('is_active', true)
                            ->get();

        // Get user's addresses
        $userAddresses = Address::where('user_id', Auth::id())->get();

        return view('pages.dashboard_user.booking-form', compact('sitter', 'registeredCats', 'userAddresses'));
    }

public function store(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | 1. Ambil service & tentukan tipe hari
    |--------------------------------------------------------------------------
    */
    $service = Service::where('slug', $request->service_type)->firstOrFail();
    $isSingleDay = in_array($service->slug, ['grooming', 'home-visit']);

    /*
    |--------------------------------------------------------------------------
    | 2. Bersihkan input berdasarkan cat_type (🔥 PALING PENTING)
    |--------------------------------------------------------------------------
    */
    if ($request->cat_type === 'registered') {
        $request->request->remove('new_cats');
    }

    if ($request->cat_type === 'new') {
        $request->request->remove('registered_cat_ids');
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Validasi (conditional & aman)
    |--------------------------------------------------------------------------
    */
    $validated = $request->validate([
        'sitter_id' => 'required|exists:users,id',
        'service_type' => 'required|exists:services,slug',
        'cat_type' => 'required|in:registered,new',

        // tanggal
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => $isSingleDay
            ? 'nullable'
            : 'required|date|after_or_equal:start_date',

        // pengantaran
        'delivery_method' => 'required|in:dropoff,pickup',
        'user_address_id' => 'required_if:delivery_method,pickup|nullable|exists:addresses,id',

        // cat registered
        'registered_cat_ids' => 'required_if:cat_type,registered|array|min:1',
        'registered_cat_ids.*' => 'exists:cats,id',

        // cat baru
        'new_cats' => 'required_if:cat_type,new|array|min:1',
        'new_cats.*.name' => 'required_if:cat_type,new|string|max:100',
        'new_cats.*.breed' => 'nullable|string|max:100',
        'new_cats.*.age' => 'nullable|string|max:50',

        // lainnya
        'special_notes' => 'nullable|string|max:500',
        'terms_accepted' => 'accepted',
    ]);

    DB::beginTransaction();

    try {
        /*
        |--------------------------------------------------------------------------
        | 4. Ambil harga sitter
        |--------------------------------------------------------------------------
        */
        $sitter = User::findOrFail($validated['sitter_id']);
        $priceField = str_replace('-', '_', $service->slug) . '_price';
        $basePrice = $sitter->sitterProfile->{$priceField};

        if (!$basePrice || $basePrice <= 0) {
            throw new \Exception('Service price not available.');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Validasi kepemilikan kucing (registered)
        |--------------------------------------------------------------------------
        */
        if ($validated['cat_type'] === 'registered') {
            $validCatCount = Cat::where('user_id', Auth::id())
                ->whereIn('id', $validated['registered_cat_ids'])
                ->count();

            if ($validCatCount !== count($validated['registered_cat_ids'])) {
                throw new \Exception('Invalid cat selection.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Hitung durasi
        |--------------------------------------------------------------------------
        */
        $startDate = \Carbon\Carbon::parse($validated['start_date']);

        if ($isSingleDay) {
            $endDate = $startDate->copy();
            $duration = 1;
        } else {
            $endDate = \Carbon\Carbon::parse($validated['end_date']);
            $duration = $startDate->diffInDays($endDate) + 1;
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Hitung jumlah kucing
        |--------------------------------------------------------------------------
        */
        $totalCats = $validated['cat_type'] === 'registered'
            ? count($validated['registered_cat_ids'])
            : count($validated['new_cats']);

        /*
        |--------------------------------------------------------------------------
        | 8. Hitung harga
        |--------------------------------------------------------------------------
        */
        $pricing = (new Booking())->calculatePricing(
            $basePrice,
            $duration,
            $validated['delivery_method'],
            $totalCats
        );

        /*
        |--------------------------------------------------------------------------
        | 9. Simpan booking
        |--------------------------------------------------------------------------
        */
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'sitter_id' => $validated['sitter_id'],
            'service_id' => $service->id,
            'booking_code' => Booking::generateBookingCode(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration' => $duration,
            'total_cats' => $totalCats,
            'delivery_method' => $validated['delivery_method'],
            'address_id' => $validated['delivery_method'] === 'pickup'
                ? $validated['user_address_id']
                : null,
            'special_notes' => $validated['special_notes'] ?? null,
            'status' => 'pending',
            'service_price' => $pricing['service_price'],
            'delivery_fee' => $pricing['delivery_fee'],
            'subtotal' => $pricing['subtotal'],
            'platform_fee' => $pricing['platform_fee'],
            'total_price' => $pricing['total_price'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 10. Simpan kucing ke booking
        |--------------------------------------------------------------------------
        */
        if ($validated['cat_type'] === 'registered') {
            foreach ($validated['registered_cat_ids'] as $catId) {
                BookingCat::create([
                    'booking_id' => $booking->id,
                    'cat_id' => $catId,
                    'cat_type' => 'registered',
                ]);
            }
        } else {
            foreach ($validated['new_cats'] as $cat) {
                BookingCat::create([
                    'booking_id' => $booking->id,
                    'cat_type' => 'new',
                    'new_cat_name' => $cat['name'],
                    'new_cat_breed' => $cat['breed'] ?? null,
                    'new_cat_age' => $cat['age'] ?? null,
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('booking.confirmation', $booking->id)
            ->with('success', 'Booking created successfully.');

    } catch (\Exception $e) {
        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

/**
 * Show booking confirmation page
 */
public function confirmation($id)
{
    $booking = Booking::where('id', $id)
                     ->where('user_id', Auth::id())
                     ->with([
                         'sitter.sitterProfile',
                         'sitter.addresses',
                         'service',
                         'bookingCats.cat',
                         'address'
                     ])
                     ->firstOrFail();

    return view('pages.dashboard_user.booking-confirmation', compact('booking'));
}

    /**
     * Cancel booking
     */
    public function cancel(Request $request, $id)
    {
        $validated = $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::where('id', $id)
                             ->where('user_id', Auth::id())
                             ->whereIn('status', ['pending', 'confirmed'])
                             ->with('payment')
                             ->firstOrFail();

            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => $validated['cancel_reason'],
            ]);

            // If payment exists and is confirmed/held, process refund
            if ($booking->payment && in_array($booking->payment->payment_status, ['confirmed', 'held'])) {
                $booking->payment->refund($validated['cancel_reason']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'redirect' => route('my-request.show', $booking->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show payment page
     */
    public function payment($id)
    {
        $booking = Booking::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->where('status', 'confirmed')
                         ->with(['sitter', 'service', 'bookingCats.cat', 'payment'])
                         ->firstOrFail();

        // Check if already paid
        if ($booking->payment && $booking->payment->payment_status !== 'pending') {
            return redirect()->route('my-request.show', $booking->id)
                ->with('info', 'This booking has already been paid.');
        }

        return view('pages.dashboard_user.payment', compact('booking'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:bank_transfer,gopay,shopeepay,ovo,dana,credit_card,debit_card,virtual_account,qris',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // For manual bank transfer
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::where('id', $id)
                             ->where('user_id', Auth::id())
                             ->where('status', 'confirmed')
                             ->with('payment')
                             ->firstOrFail();

            // Check if payment already exists
            if ($booking->payment) {
                // Update existing payment
                $payment = $booking->payment;
            } else {
                // Calculate fees
                $amount = $booking->total_price;
                $platformFee = $amount * 0.10; // 10% platform fee
                $sitterEarning = $amount - $platformFee;

                // Create new payment
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'user_id' => Auth::id(),
                    'sitter_id' => $booking->sitter_id,
                    'payment_code' => Payment::generatePaymentCode(),
                    'amount' => $amount,
                    'platform_fee' => $platformFee,
                    'sitter_earning' => $sitterEarning,
                    'payment_status' => 'pending',
                    'payout_status' => 'pending',
                ]);

                // Create sitter earning record
                SitterEarning::create([
                    'user_id' => $booking->sitter_id,
                    'booking_id' => $booking->id,
                    'payment_id' => $payment->id,
                    'earning_code' => SitterEarning::generateEarningCode(),
                    'booking_amount' => $amount,
                    'platform_fee' => $platformFee,
                    'net_earning' => $sitterEarning,
                    'status' => 'pending',
                ]);
            }

            // Handle payment proof upload for manual transfer
            $paymentProof = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('payment_proofs', $filename, 'public');
                $paymentProof = 'payment_proofs/' . $filename;
            }

            // Update payment method and proof
            $payment->update([
                'payment_method' => $validated['payment_method'],
                'payment_proof' => $paymentProof,
                'payment_gateway' => $this->getPaymentGateway($validated['payment_method']),
            ]);

            // For demo purposes, auto-confirm payment
            // In production, this would be handled by payment gateway webhook
            if (in_array($validated['payment_method'], ['bank_transfer']) && $paymentProof) {
                // Manual transfer needs admin verification
                $payment->update(['payment_status' => 'pending']);
            } else {
                // Auto-confirm for e-wallets (in production, wait for gateway confirmation)
                $this->confirmPayment($payment);
            }

            DB::commit();

            return redirect()->route('my-request.payment.success', $booking->id)
                ->with('success', 'Payment submitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Payment success page
     */
    public function paymentSuccess($id)
    {
        $booking = Booking::where('id', $id)
                         ->where('user_id', Auth::id())
                         ->with(['payment', 'sitter', 'service'])
                         ->firstOrFail();

        return view('pages.dashboard_user.payment-success', compact('booking'));
    }

    /**
     * Confirm payment (helper method)
     */
    private function confirmPayment(Payment $payment)
    {
        $payment->confirmPayment();
        $payment->holdInEscrow();
    }

    /**
     * Get payment gateway based on method
     */
    private function getPaymentGateway($method)
    {
        if ($method === 'bank_transfer') {
            return 'manual';
        }
        
        if (in_array($method, ['gopay', 'shopeepay', 'ovo', 'dana', 'qris'])) {
            return 'midtrans'; // or 'xendit'
        }
        
        if (in_array($method, ['credit_card', 'debit_card', 'virtual_account'])) {
            return 'midtrans';
        }
        
        return null;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create($sitter_id)
    {
        // Hardcoded sitters data (same as FindSitter & SitterProfile)
        $allSitters = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'location' => 'Jakarta Selatan',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=FF9800&color=fff',
                'rating' => 4.9,
                'reviews_count' => 127,
                'verified' => true,
                'services' => [
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 75000,
                        'icon' => 'fa-home',
                        'description' => 'Full day care at my place with feeding, playing, and monitoring',
                        'is_single_day' => false
                    ],
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 50000,
                        'icon' => 'fa-cut',
                        'description' => 'Professional grooming including bathing, brushing, and nail trimming',
                        'is_single_day' => true
                    ],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Ahmad Pratama',
                'location' => 'Jakarta Pusat',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Pratama&size=200&background=2196F3&color=fff',
                'rating' => 4.8,
                'reviews_count' => 95,
                'verified' => true,
                'services' => [
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 80000,
                        'icon' => 'fa-cut',
                        'description' => 'Premium grooming service with professional equipment',
                        'is_single_day' => true
                    ],
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 70000,
                        'icon' => 'fa-home',
                        'description' => 'Day care service at my certified facility',
                        'is_single_day' => false
                    ],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Lisa Anderson',
                'location' => 'Jakarta Utara',
                'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&size=200&background=4CAF50&color=fff',
                'rating' => 5.0,
                'reviews_count' => 203,
                'verified' => true,
                'services' => [
                    [
                        'type' => 'cat-sitting',
                        'name' => 'Cat Sitting',
                        'price' => 95000,
                        'icon' => 'fa-home',
                        'description' => 'Professional cat care with medical knowledge and experience',
                        'is_single_day' => false
                    ],
                    [
                        'type' => 'grooming',
                        'name' => 'Grooming',
                        'price' => 75000,
                        'icon' => 'fa-cut',
                        'description' => 'Gentle grooming with health check included',
                        'is_single_day' => true
                    ],
                    [
                        'type' => 'home-visit',
                        'name' => 'Home Visit',
                        'price' => 60000,
                        'icon' => 'fa-walking',
                        'description' => 'Visit your home to feed and check on your cat',
                        'is_single_day' => false
                    ],
                ],
            ],
        ];

        // Find sitter by ID
        $sitter = collect($allSitters)->firstWhere('id', $sitter_id);

        // If sitter not found, redirect back
        if (!$sitter) {
            return redirect()->back()->with('error', 'Sitter not found');
        }

        // Add sitter address to sitter data
        $sitter['address'] = 'Jl. Sudirman No. 45, RT 005/RW 002, Karet Tengsin, ' . $sitter['location'];

        // Hardcoded registered cats (user's cats)
        $registeredCats = [
            [
                'id' => 1,
                'name' => 'Luna',
                'breed' => 'Persian',
                'age' => '2 years',
                'photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=100'
            ],
            [
                'id' => 2,
                'name' => 'Milo',
                'breed' => 'British Shorthair',
                'age' => '3 years',
                'photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7e1d0f?w=100'
            ],
            [
                'id' => 3,
                'name' => 'Whiskers',
                'breed' => 'Maine Coon',
                'age' => '1 year',
                'photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=100'
            ],
        ];

        // Hardcoded user addresses (from profile)
        $userAddresses = [
            [
                'id' => 1,
                'label' => 'Home',
                'full_address' => 'Jl. Kebon Jeruk No. 123, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk, Jakarta Barat, DKI Jakarta, 11530'
            ],
            [
                'id' => 2,
                'label' => 'Office',
                'full_address' => 'Jl. Thamrin No. 8, Menteng, Jakarta Pusat, DKI Jakarta, 10230'
            ],
        ];

        return view('pages.dashboard_user.booking-form', compact('sitter', 'registeredCats', 'userAddresses'));
    }

    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'sitter_id' => 'required|integer',
            'service_type' => 'required|string',
            'cat_type' => 'required|in:registered,new',
            'registered_cat_id' => 'required_if:cat_type,registered',
            'new_cat_name' => 'required_if:cat_type,new|max:100',
            'new_cat_breed' => 'nullable|max:100',
            'new_cat_age' => 'nullable|max:50',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'delivery_method' => 'required|in:dropoff,pickup',
            'user_address_id' => 'required_if:delivery_method,pickup',
            'special_notes' => 'nullable|string|max:500',
            'terms_accepted' => 'required|accepted',
        ], [
            // Custom error messages
            'sitter_id.required' => 'Sitter information is missing',
            'service_type.required' => 'Please select a service',
            'cat_type.required' => 'Please select a cat type',
            'registered_cat_id.required_if' => 'Please select a cat from your registered cats',
            'new_cat_name.required_if' => 'Please enter your cat\'s name',
            'start_date.required' => 'Please select a start date',
            'start_date.after_or_equal' => 'Start date must be today or in the future',
            'end_date.required' => 'Please select an end date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'delivery_method.required' => 'Please select a delivery method',
            'user_address_id.required_if' => 'Please select your address for pick-up service',
            'terms_accepted.accepted' => 'You must accept the Terms of Service and Cancellation Policy',
        ]);

        // Calculate duration and total price
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $duration = $startDate->diffInDays($endDate) + 1;

        // Calculate delivery fee
        $deliveryFee = $validated['delivery_method'] === 'pickup' ? 50000 : 0;

        // Generate booking code (simple format)
        $bookingCode = 'BOOK-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // For now, store booking data in session for confirmation page
        session([
            'pending_booking' => [
                'booking_code' => $bookingCode,
                'sitter_id' => $validated['sitter_id'],
                'service_type' => $validated['service_type'],
                'cat_type' => $validated['cat_type'],
                'cat_id' => $validated['cat_type'] === 'registered' ? $validated['registered_cat_id'] : null,
                'cat_name' => $validated['cat_type'] === 'new' ? $validated['new_cat_name'] : null,
                'cat_breed' => $validated['cat_type'] === 'new' ? $validated['new_cat_breed'] : null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'duration' => $duration,
                'delivery_method' => $validated['delivery_method'],
                'user_address_id' => $validated['delivery_method'] === 'pickup' ? $validated['user_address_id'] : null,
                'delivery_fee' => $deliveryFee,
                'special_notes' => $validated['special_notes'] ?? null,
                'status' => 'Waiting Sitter Confirmation',
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]
        ]);

        // Redirect to booking confirmation page
        return redirect()->route('booking.confirmation');
    }

    public function confirmation()
    {
        // Get booking data from session
        $sessionBooking = session('pending_booking');

        // If no pending booking, redirect to dashboard
        if (!$sessionBooking) {
            return redirect()->route('user.dashboard')
                ->with('error', 'No pending booking found.');
        }

        // Hardcoded sitters data
        $allSitters = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'location' => 'Jakarta Selatan',
                'address' => 'Jl. Sudirman No. 45, RT 005/RW 002, Karet Tengsin, Jakarta Selatan, DKI Jakarta, 12920',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=FF9800&color=fff',
                'rating' => 4.9,
                'services' => [
                    ['type' => 'cat-sitting', 'name' => 'Cat Sitting', 'price' => 75000],
                    ['type' => 'grooming', 'name' => 'Grooming', 'price' => 50000],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Ahmad Pratama',
                'location' => 'Jakarta Pusat',
                'address' => 'Jl. MH Thamrin No. 10, Menteng, Jakarta Pusat, DKI Jakarta, 10230',
                'avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Pratama&size=200&background=2196F3&color=fff',
                'rating' => 4.8,
                'services' => [
                    ['type' => 'grooming', 'name' => 'Grooming', 'price' => 80000],
                    ['type' => 'cat-sitting', 'name' => 'Cat Sitting', 'price' => 70000],
                ],
            ],
            [
                'id' => 3,
                'name' => 'Lisa Anderson',
                'location' => 'Jakarta Utara',
                'address' => 'Jl. Pantai Indah Kapuk No. 88, Penjaringan, Jakarta Utara, DKI Jakarta, 14460',
                'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&size=200&background=4CAF50&color=fff',
                'rating' => 5.0,
                'services' => [
                    ['type' => 'cat-sitting', 'name' => 'Cat Sitting', 'price' => 95000],
                    ['type' => 'grooming', 'name' => 'Grooming', 'price' => 75000],
                    ['type' => 'home-visit', 'name' => 'Home Visit', 'price' => 60000],
                ],
            ],
        ];

        // Hardcoded registered cats
        $allCats = [
            ['id' => 1, 'name' => 'Luna', 'breed' => 'Persian'],
            ['id' => 2, 'name' => 'Milo', 'breed' => 'British Shorthair'],
            ['id' => 3, 'name' => 'Whiskers', 'breed' => 'Maine Coon'],
        ];

        // Hardcoded user addresses
        $allAddresses = [
            ['id' => 1, 'label' => 'Home', 'full_address' => 'Jl. Kebon Jeruk No. 123, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk, Jakarta Barat, DKI Jakarta, 11530'],
            ['id' => 2, 'label' => 'Office', 'full_address' => 'Jl. Thamrin No. 8, Menteng, Jakarta Pusat, DKI Jakarta, 10230'],
        ];

        // Find sitter
        $sitter = collect($allSitters)->firstWhere('id', $sessionBooking['sitter_id']);
        
        // Find service
        $service = collect($sitter['services'])->firstWhere('type', $sessionBooking['service_type']);

        // Find cat
        $catName = '';
        $catBreed = '';
        if ($sessionBooking['cat_type'] === 'registered') {
            $cat = collect($allCats)->firstWhere('id', $sessionBooking['cat_id']);
            $catName = $cat['name'];
            $catBreed = $cat['breed'];
        } else {
            $catName = $sessionBooking['cat_name'];
            $catBreed = $sessionBooking['cat_breed'] ?? 'Not specified';
        }

        // Find address
        $userAddress = '';
        if ($sessionBooking['delivery_method'] === 'pickup') {
            $address = collect($allAddresses)->firstWhere('id', $sessionBooking['user_address_id']);
            $userAddress = $address['full_address'] ?? 'Address not found';
        }

        // Calculate prices
        $servicePrice = $service['price'] * $sessionBooking['duration'];
        $deliveryFee = $sessionBooking['delivery_fee'];
        $subtotal = $servicePrice + $deliveryFee;
        $platformFee = $subtotal * 0.05;
        $totalPrice = $subtotal + $platformFee;

        // Format dates
        $startDate = \Carbon\Carbon::parse($sessionBooking['start_date']);
        $endDate = \Carbon\Carbon::parse($sessionBooking['end_date']);
        
        if ($sessionBooking['duration'] == 1) {
            $dateRange = $startDate->format('M d, Y');
            $durationText = '1 day';
        } else {
            $dateRange = $startDate->format('M d') . ' - ' . $endDate->format('M d, Y');
            $durationText = $sessionBooking['duration'] . ' days';
        }

        // Prepare booking data for view
        $booking = [
            'code' => $sessionBooking['booking_code'],
            'status' => $sessionBooking['status'],
            'service_name' => $service['name'],
            'service_price' => 'Rp ' . number_format($servicePrice, 0, ',', '.'),
            'sitter_name' => $sitter['name'],
            'sitter_avatar' => $sitter['avatar'],
            'sitter_rating' => $sitter['rating'],
            'sitter_address' => $sitter['address'],
            'cat_name' => $catName,
            'cat_breed' => $catBreed,
            'date_range' => $dateRange,
            'duration' => $durationText,
            'delivery_method' => $sessionBooking['delivery_method'],
            'user_address' => $userAddress,
            'delivery_fee' => $deliveryFee,
            'delivery_fee_formatted' => 'Rp ' . number_format($deliveryFee, 0, ',', '.'),
            'platform_fee' => 'Rp ' . number_format($platformFee, 0, ',', '.'),
            'total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'special_notes' => $sessionBooking['special_notes'],
        ];

        return view('pages.dashboard_user.booking-confirmation', compact('booking'));
    }
}
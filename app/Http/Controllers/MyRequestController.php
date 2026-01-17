<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyRequestController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');
        
        // Get user's bookings
        $query = Booking::where('user_id', Auth::id())
                       ->with(['sitter.sitterProfile', 'service', 'bookingCats.cat']);

        // Filter by status
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        // Count by status
        $allBookings = Booking::where('user_id', Auth::id())->get();
        $statusCounts = [
            'all' => $allBookings->count(),
            'pending' => $allBookings->where('status', 'pending')->count(),
            'confirmed' => $allBookings->where('status', 'confirmed')->count(),
            'in_progress' => $allBookings->where('status', 'in_progress')->count(),
            'completed' => $allBookings->where('status', 'completed')->count(),
            'cancelled' => $allBookings->where('status', 'cancelled')->count(),
        ];

        // Map bookings for view
        $bookings = $bookings->map(function($booking) {
            $cat = $booking->bookingCats->first();
            
            return [
                'id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'status' => $booking->status,
                'service' => $booking->service->name,
                'service_icon' => $booking->service->icon_class,
                'cat_name' => $cat ? $cat->cat_name : 'N/A',
                'cat_photo' => $cat && $cat->cat ? $cat->cat->photo_url : 'https://placekitten.com/200/200',
                'sitter' => [
                    'id' => $booking->sitter->id,
                    'name' => $booking->sitter->name,
                    'photo' => $booking->sitter->avatar_url,
                    'rating' => $booking->sitter->sitterProfile->rating_average,
                    'location' => $booking->sitter->addresses->first()->city ?? 'N/A',
                ],
                'start_date' => $booking->start_date->format('Y-m-d'),
                'end_date' => $booking->end_date->format('Y-m-d'),
                'duration' => $booking->duration,
                'price' => $booking->service_price,
                'platform_fee' => $booking->platform_fee,
                'total_price' => $booking->total_price,
                'special_notes' => $booking->special_notes,
                'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
                'completed_at' => $booking->completed_at ? $booking->completed_at->format('Y-m-d H:i:s') : null,
                'cancelled_at' => $booking->cancelled_at ? $booking->cancelled_at->format('Y-m-d H:i:s') : null,
                'cancel_reason' => $booking->cancel_reason,
                'review_given' => $booking->review ? true : false,
            ];
        });

        return view('pages.dashboard_user.my-request.index', [
            'bookings' => $bookings,
            'statusFilter' => $statusFilter,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
                         ->with([
                             'sitter.sitterProfile',
                             'sitter.addresses',
                             'service',
                             'bookingCats.cat',
                             'address',
                             'payment'
                         ])
                         ->findOrFail($id);

        $cat = $booking->bookingCats->first();

        $bookingData = [
            'id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'status' => $booking->status,
            'service' => $booking->service->name,
            'service_icon' => $booking->service->icon_class,
            'cat_name' => $cat ? $cat->cat_name : 'N/A',
            'cat_breed' => $cat ? $cat->cat_breed : 'N/A',
            'cat_age' => $cat && $cat->cat ? $cat->cat->age : 'N/A',
            'cat_photo' => $cat && $cat->cat ? $cat->cat->photo_url : 'https://placekitten.com/400/400',
            'sitter' => [
                'id' => $booking->sitter->id,
                'name' => $booking->sitter->name,
                'photo' => $booking->sitter->avatar_url,
                'rating' => $booking->sitter->sitterProfile->rating_average,
                'total_reviews' => $booking->sitter->sitterProfile->total_reviews,
                'location' => $booking->sitter->addresses->first()->city ?? 'N/A',
                'phone' => $booking->sitter->phone,
                'joined_date' => $booking->sitter->created_at->format('F Y'),
            ],
            'start_date' => $booking->start_date->format('Y-m-d H:i:s'),
            'end_date' => $booking->end_date->format('Y-m-d H:i:s'),
            'duration' => $booking->duration,
            'price' => $booking->service_price,
            'platform_fee' => $booking->platform_fee,
            'total_price' => $booking->total_price,
            'special_notes' => $booking->special_notes,
            'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            'confirmed_at' => $booking->confirmed_at ? $booking->confirmed_at->format('Y-m-d H:i:s') : null,
            'payment_status' => $booking->payment ? $booking->payment->payment_status : 'pending',
            'payment_method' => $booking->payment ? $booking->payment->payment_method : null,
        ];

        return view('pages.dashboard_user.my-request.show', [
            'booking' => $bookingData
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get stats from database
        $stats = [
            'totalBookings' => Booking::where('user_id', $user->id)->count(),
            'activeBookings' => Booking::where('user_id', $user->id)
                ->whereIn('status', ['confirmed', 'payment_confirmed', 'in_progress'])
                ->count(),
            'completedBookings' => Booking::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'myCats' => Cat::where('user_id', $user->id)->where('is_active', true)->count(),
        ];

        // Get upcoming bookings
        $upcomingBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'payment_confirmed'])
            ->where('start_date', '>=', now())
            ->with(['sitter.addresses', 'service']) // Load sitter's addresses
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get()
            ->map(function($booking) {
                return (object)[
                    'id' => $booking->id,
                    'start_date' => $booking->start_date->format('M d, Y'),
                    'end_date' => $booking->end_date->format('M d, Y'),
                    'status' => $booking->status,
                    'sitter_name' => $booking->sitter->name,
                    'sitter_id' => $booking->sitter_id,
                    'sitter_photo' => $booking->sitter->avatar_url,
                    'location' => $booking->sitter->addresses->first()->city ?? 'N/A', // Fixed: direct access
                    'total_price' => $booking->total_price,
                ];
            });

        // Get recommended sitters
        $recommendedSitters = User::select('users.*')
            ->join('pet_sitter_profiles', 'users.id', '=', 'pet_sitter_profiles.user_id')
            ->where('users.role', 'sitter')
            ->where('users.status', 'active')
            ->where('pet_sitter_profiles.is_verified', true)
            ->where('pet_sitter_profiles.is_available', true)
            ->with(['sitterProfile', 'addresses'])
            ->orderByDesc('pet_sitter_profiles.rating_average')
            ->limit(3)
            ->get()
            ->map(function($sitter) {
                $profile = $sitter->sitterProfile;
                $address = $sitter->addresses->first();
                
                return (object)[
                    'id' => $sitter->id,
                    'name' => $sitter->name,
                    'photo' => $sitter->avatar_url,
                    'location' => $address->city ?? 'N/A',
                    'rating' => $profile->rating_average ?? 5.0,
                    'reviews_count' => $profile->total_reviews ?? 0,
                    'completed_bookings' => $profile->total_bookings ?? 0,
                    'experience_years' => $profile->years_of_experience ?? 1,
                    'price_per_day' => $profile->cat_sitting_price ?? 0,
                    'is_verified' => $profile->is_verified ?? false,
                ];
            });

        return view('pages.dashboard_user.dashboard', [
            'user' => $user,
            'totalBookings' => $stats['totalBookings'],
            'activeBookings' => $stats['activeBookings'],
            'completedBookings' => $stats['completedBookings'],
            'myCats' => $stats['myCats'],
            'upcomingBookings' => $upcomingBookings,
            'recommendedSitters' => $recommendedSitters,
        ]);
    }
}
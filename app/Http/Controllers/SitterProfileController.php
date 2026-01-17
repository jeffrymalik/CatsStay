<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Add this import

class SitterProfileController extends Controller
{
    public function show($id)
    {
        $user = User::where('role', 'sitter')
                   ->where('id', $id)
                   ->with(['sitterProfile', 'addresses', 'receivedReviews.user'])
                   ->firstOrFail();

        $profile = $user->sitterProfile;
        $address = $user->addresses->first();

        // Map services
        $services = $profile->services_with_pricing;

        // Map reviews
        $reviews = $user->receivedReviews()
                       ->public()
                       ->latest()
                       ->limit(10)
                       ->get()
                       ->map(function($review) {
                           return [
                               'user' => $review->user->name,
                               'rating' => $review->rating,
                               'date' => $review->time_ago,
                               'comment' => $review->review_text,
                               'avatar' => $review->user->avatar_url,
                           ];
                       });

        $sitter = [
            'id' => $user->id,
            'name' => $user->name,
            'location' => $address->city ?? 'N/A',
            'location_slug' => $address ? Str::slug($address->city) : 'na', // Changed here
            'avatar' => $user->avatar_url,
            'rating' => $profile->rating_average,
            'reviews_count' => $profile->total_reviews,
            'bio' => $user->bio,
            'bookings_count' => $profile->total_bookings,
            'experience_years' => $profile->years_of_experience,
            'verified' => $profile->is_verified,
            'response_time' => $profile->response_time,
            'services' => $services,
            'gallery' => $profile->home_photos ?? [],
            'reviews' => $reviews,
        ];

        return view('pages.dashboard_user.sitter-profile', compact('sitter'));
    }
}
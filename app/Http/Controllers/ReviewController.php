<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Show review form for a completed booking
     */
    public function create($booking_id)
    {
        $booking = Booking::where('user_id', Auth::id())
                         ->where('id', $booking_id)
                         ->where('status', 'completed')
                         ->with(['sitter', 'service'])
                         ->firstOrFail();

        // Check if already reviewed
        if ($booking->review) {
            return redirect()->route('my-request.index')
                ->with('error', 'You have already reviewed this booking');
        }

        $bookingData = [
            'id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'sitter_id' => $booking->sitter_id,
            'sitter_name' => $booking->sitter->name,
            'sitter_avatar' => $booking->sitter->avatar_url,
            'service_name' => $booking->service->name,
            'dates' => $booking->date_range,
            'status' => $booking->status,
        ];

        return view('pages.dashboard_user.write-review', ['booking' => $bookingData]);
    }

    /**
     * Store review
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'sitter_id' => 'required|integer|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:20|max:500',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'recommendation' => 'nullable|in:yes_definitely,yes_with_reservations,not_sure,no',
        ]);

        // Verify booking belongs to user and is completed
        $booking = Booking::where('id', $validated['booking_id'])
                         ->where('user_id', Auth::id())
                         ->where('status', 'completed')
                         ->firstOrFail();

        // Check if already reviewed
        if ($booking->review) {
            return redirect()->route('my-request.index')
                ->with('error', 'You have already reviewed this booking');
        }

        // Handle photo uploads
        $photoUrls = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $photoUrls[] = $path;
            }
        }

        // Create review
        Review::create([
            'booking_id' => $validated['booking_id'],
            'user_id' => Auth::id(),
            'sitter_id' => $validated['sitter_id'],
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'recommendation' => $validated['recommendation'],
            'photos' => $photoUrls,
            'is_approved' => true,
        ]);

        // Update booking status
        $booking->update(['status' => 'reviewed']);

        // Update sitter stats
        $booking->sitter->sitterProfile->updateStats();

        return redirect()->route('my-request.index')
            ->with('success', 'Thank you for your review! It has been published.');
    }
}
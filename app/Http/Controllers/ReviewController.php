<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Show review form for a completed booking
     */
    public function create($booking_id)
    {
        // Hardcoded completed bookings data
        // In real app, this would fetch from database with status = 'completed'
        $allBookings = [
            [
                'id' => 1,
                'booking_code' => 'BOOK-042',
                'sitter_id' => 1,
                'sitter_name' => 'Sarah Johnson',
                'sitter_avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=FF9800&color=fff',
                'service_name' => 'Cat Sitting',
                'dates' => 'Dec 1-3, 2024',
                'status' => 'completed',
            ],
            [
                'id' => 2,
                'booking_code' => 'BOOK-038',
                'sitter_id' => 2,
                'sitter_name' => 'Ahmad Pratama',
                'sitter_avatar' => 'https://ui-avatars.com/api/?name=Ahmad+Pratama&size=200&background=2196F3&color=fff',
                'service_name' => 'Grooming',
                'dates' => 'Nov 20, 2024',
                'status' => 'completed',
            ],
            [
                'id' => 3,
                'booking_code' => 'BOOK-025',
                'sitter_id' => 3,
                'sitter_name' => 'Lisa Anderson',
                'sitter_avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&size=200&background=4CAF50&color=fff',
                'service_name' => 'Home Visit',
                'dates' => 'Nov 15-18, 2024',
                'status' => 'completed',
            ],
        ];

        // Find booking by ID
        $booking = collect($allBookings)->firstWhere('id', $booking_id);

        // If booking not found, redirect back
        if (!$booking) {
            return redirect()->route('my-request.index')
                ->with('error', 'Booking not found');
        }

        // Check if booking is completed
        if ($booking['status'] !== 'completed') {
            return redirect()->route('my-request.index')
                ->with('error', 'You can only review completed bookings');
        }

        // TODO: Check if user already reviewed this booking
        // In real app: Review::where('booking_id', $booking_id)->where('user_id', auth()->id())->exists()

        return view('pages.dashboard_user.write-review', compact('booking'));
    }

    /**
     * Store review
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'booking_id' => 'required|integer',
            'sitter_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:20|max:500',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'image|mimes:jpeg,png,webp|max:2048', // 2MB max
            'recommendation' => 'nullable|in:yes_definitely,yes_with_reservations,not_sure,no',
        ], [
            // Custom error messages
            'rating.required' => 'Please select a star rating',
            'rating.min' => 'Rating must be between 1 and 5',
            'rating.max' => 'Rating must be between 1 and 5',
            'review_text.required' => 'Please write a review',
            'review_text.min' => 'Review must be at least 20 characters',
            'review_text.max' => 'Review must not exceed 500 characters',
            'photos.max' => 'You can upload maximum 3 photos',
            'photos.*.image' => 'All files must be images',
            'photos.*.mimes' => 'Photos must be in JPG, PNG, or WEBP format',
            'photos.*.max' => 'Each photo must not exceed 2MB',
        ]);

        // Handle photo uploads
        $photoUrls = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // In real app: Store in storage/app/public/reviews
                // $path = $photo->store('reviews', 'public');
                // $photoUrls[] = Storage::url($path);
                
                // For now, use placeholder
                $photoUrls[] = 'https://via.placeholder.com/400x400?text=Review+Photo';
            }
        }

        // In real implementation:
        // 1. Create review record in database
        // 2. Update booking status to 'reviewed'
        // 3. Update sitter's average rating
        // 4. Send notification to sitter
        
        // Store review data in session for demonstration
        session([
            'new_review' => [
                'booking_id' => $validated['booking_id'],
                'sitter_id' => $validated['sitter_id'],
                'rating' => $validated['rating'],
                'review_text' => $validated['review_text'],
                'photos' => $photoUrls,
                'recommendation' => $validated['recommendation'] ?? null,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]
        ]);

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully!',
                'redirect_url' => route('my-request.index'),
            ]);
        }

        // Regular form submission redirect
        return redirect()->route('my-request.index')
            ->with('success', 'Thank you for your review! It has been published.');
    }
}
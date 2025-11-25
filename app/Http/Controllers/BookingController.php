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

        return view('pages.dashboard_user.booking-form', compact('sitter', 'registeredCats'));
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
            'terms_accepted.accepted' => 'You must accept the Terms of Service and Cancellation Policy',
        ]);

        // Calculate duration and total price
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $duration = $startDate->diffInDays($endDate) + 1;

        // In real implementation:
        // 1. Create booking record in database
        // 2. Send notification to sitter
        // 3. Send confirmation email to user
        // 4. Redirect to payment page
        
        // For now, store booking data in session for payment page
        session([
            'pending_booking' => [
                'sitter_id' => $validated['sitter_id'],
                'service_type' => $validated['service_type'],
                'cat_type' => $validated['cat_type'],
                'cat_id' => $validated['cat_type'] === 'registered' ? $validated['registered_cat_id'] : null,
                'cat_name' => $validated['cat_type'] === 'new' ? $validated['new_cat_name'] : null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'duration' => $duration,
                'special_notes' => $validated['special_notes'] ?? null,
            ]
        ]);

        // Option 1: Redirect to payment page (if payment gateway ready)
        // return redirect()->route('payment.checkout')->with('success', 'Booking created! Please complete payment.');
        
        // Option 2: Redirect to dashboard with success message (for now)
        return redirect()->route('user.dashboard')
            ->with('success', 'Booking request sent successfully! The sitter will respond soon.');
        
        // Option 3: Redirect to booking confirmation page
        // return redirect()->route('booking.confirmation')->with('success', 'Booking created successfully!');
    }
}
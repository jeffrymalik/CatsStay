<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyRequestController extends Controller
{
    public function index(Request $request)
    {
        // Hardcoded bookings data for UI testing
        $bookings = [
            [
                'id' => 1,
                'booking_code' => 'BOOK-001',
                'status' => 'pending',
                'service' => 'Cat Sitting',
                'service_icon' => 'fa-home',
                'cat_name' => 'Luna',
                'cat_photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=200',
                'sitter' => [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'photo' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FFA726&color=fff&size=200',
                    'rating' => 4.9,
                    'location' => 'Central Jakarta'
                ],
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-05',
                'duration' => 5,
                'price' => 750000,
                'platform_fee' => 37500,
                'total_price' => 787500,
                'special_notes' => 'Please feed twice a day',
                'created_at' => '2024-11-20 10:30:00'
            ],
            [
                'id' => 2,
                'booking_code' => 'BOOK-002',
                'status' => 'confirmed',
                'service' => 'Grooming',
                'service_icon' => 'fa-scissors',
                'cat_name' => 'Milo',
                'cat_photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=200',
                'sitter' => [
                    'id' => 2,
                    'name' => 'Michael Chen',
                    'photo' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=FFA726&color=fff&size=200',
                    'rating' => 4.8,
                    'location' => 'South Jakarta'
                ],
                'start_date' => '2024-11-28',
                'end_date' => '2024-11-28',
                'duration' => 1,
                'price' => 150000,
                'platform_fee' => 7500,
                'total_price' => 157500,
                'special_notes' => null,
                'created_at' => '2024-11-18 14:20:00'
            ],
            [
                'id' => 3,
                'booking_code' => 'BOOK-003',
                'status' => 'in_progress',
                'service' => 'Home Visit',
                'service_icon' => 'fa-house-user',
                'cat_name' => 'Whiskers',
                'cat_photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7aa5c0?w=200',
                'sitter' => [
                    'id' => 3,
                    'name' => 'Amanda Lee',
                    'photo' => 'https://ui-avatars.com/api/?name=Amanda+Lee&background=FFA726&color=fff&size=200',
                    'rating' => 5.0,
                    'location' => 'West Jakarta'
                ],
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-27',
                'duration' => 3,
                'price' => 300000,
                'platform_fee' => 15000,
                'total_price' => 315000,
                'special_notes' => 'Key under the mat',
                'created_at' => '2024-11-22 09:15:00'
            ],
            [
                'id' => 4,
                'booking_code' => 'BOOK-004',
                'status' => 'completed',
                'service' => 'Cat Sitting',
                'service_icon' => 'fa-home',
                'cat_name' => 'Luna',
                'cat_photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=200',
                'sitter' => [
                    'id' => 4,
                    'name' => 'David Martinez',
                    'photo' => 'https://ui-avatars.com/api/?name=David+Martinez&background=FFA726&color=fff&size=200',
                    'rating' => 4.7,
                    'location' => 'North Jakarta'
                ],
                'start_date' => '2024-11-10',
                'end_date' => '2024-11-13',
                'duration' => 4,
                'price' => 600000,
                'platform_fee' => 30000,
                'total_price' => 630000,
                'special_notes' => null,
                'created_at' => '2024-11-08 16:45:00',
                'completed_at' => '2024-11-13 18:00:00',
                'review_given' => false
            ],
            [
                'id' => 5,
                'booking_code' => 'BOOK-005',
                'status' => 'completed',
                'service' => 'Grooming',
                'service_icon' => 'fa-scissors',
                'cat_name' => 'Milo',
                'cat_photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=200',
                'sitter' => [
                    'id' => 5,
                    'name' => 'Emily Watson',
                    'photo' => 'https://ui-avatars.com/api/?name=Emily+Watson&background=FFA726&color=fff&size=200',
                    'rating' => 4.9,
                    'location' => 'East Jakarta'
                ],
                'start_date' => '2024-11-05',
                'end_date' => '2024-11-05',
                'duration' => 1,
                'price' => 120000,
                'platform_fee' => 6000,
                'total_price' => 126000,
                'special_notes' => null,
                'created_at' => '2024-11-03 11:30:00',
                'completed_at' => '2024-11-05 15:30:00',
                'review_given' => true
            ],
            [
                'id' => 6,
                'booking_code' => 'BOOK-006',
                'status' => 'cancelled',
                'service' => 'Home Visit',
                'service_icon' => 'fa-house-user',
                'cat_name' => 'Whiskers',
                'cat_photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7aa5c0?w=200',
                'sitter' => [
                    'id' => 6,
                    'name' => 'James Brown',
                    'photo' => 'https://ui-avatars.com/api/?name=James+Brown&background=FFA726&color=fff&size=200',
                    'rating' => 4.6,
                    'location' => 'Central Jakarta'
                ],
                'start_date' => '2024-11-15',
                'end_date' => '2024-11-17',
                'duration' => 3,
                'price' => 270000,
                'platform_fee' => 13500,
                'total_price' => 283500,
                'special_notes' => null,
                'created_at' => '2024-11-12 13:20:00',
                'cancelled_at' => '2024-11-14 10:00:00',
                'cancel_reason' => 'Change of plans'
            ]
        ];

        // Filter by status if provided
        $statusFilter = $request->query('status', 'all');
        
        if ($statusFilter !== 'all') {
            $bookings = array_filter($bookings, function($booking) use ($statusFilter) {
                return $booking['status'] === $statusFilter;
            });
        }

        // Count bookings by status
        $allBookings = [
            [
                'id' => 1,
                'booking_code' => 'BOOK-001',
                'status' => 'pending',
                'service' => 'Cat Sitting',
                'service_icon' => 'fa-home',
                'cat_name' => 'Luna',
                'cat_photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=200',
                'sitter' => [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'photo' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FFA726&color=fff&size=200',
                    'rating' => 4.9,
                    'location' => 'Central Jakarta'
                ],
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-05',
                'duration' => 5,
                'price' => 750000,
                'platform_fee' => 37500,
                'total_price' => 787500,
                'special_notes' => 'Please feed twice a day',
                'created_at' => '2024-11-20 10:30:00'
            ],
            [
                'id' => 2,
                'booking_code' => 'BOOK-002',
                'status' => 'confirmed',
                'service' => 'Grooming',
                'service_icon' => 'fa-scissors',
                'cat_name' => 'Milo',
                'cat_photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=200',
                'sitter' => [
                    'id' => 2,
                    'name' => 'Michael Chen',
                    'photo' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=FFA726&color=fff&size=200',
                    'rating' => 4.8,
                    'location' => 'South Jakarta'
                ],
                'start_date' => '2024-11-28',
                'end_date' => '2024-11-28',
                'duration' => 1,
                'price' => 150000,
                'platform_fee' => 7500,
                'total_price' => 157500,
                'special_notes' => null,
                'created_at' => '2024-11-18 14:20:00'
            ],
            [
                'id' => 3,
                'booking_code' => 'BOOK-003',
                'status' => 'in_progress',
                'service' => 'Home Visit',
                'service_icon' => 'fa-house-user',
                'cat_name' => 'Whiskers',
                'cat_photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7aa5c0?w=200',
                'sitter' => [
                    'id' => 3,
                    'name' => 'Amanda Lee',
                    'photo' => 'https://ui-avatars.com/api/?name=Amanda+Lee&background=FFA726&color=fff&size=200',
                    'rating' => 5.0,
                    'location' => 'West Jakarta'
                ],
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-27',
                'duration' => 3,
                'price' => 300000,
                'platform_fee' => 15000,
                'total_price' => 315000,
                'special_notes' => 'Key under the mat',
                'created_at' => '2024-11-22 09:15:00'
            ],
            [
                'id' => 4,
                'booking_code' => 'BOOK-004',
                'status' => 'completed',
                'service' => 'Cat Sitting',
                'service_icon' => 'fa-home',
                'cat_name' => 'Luna',
                'cat_photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=200',
                'sitter' => [
                    'id' => 4,
                    'name' => 'David Martinez',
                    'photo' => 'https://ui-avatars.com/api/?name=David+Martinez&background=FFA726&color=fff&size=200',
                    'rating' => 4.7,
                    'location' => 'North Jakarta'
                ],
                'start_date' => '2024-11-10',
                'end_date' => '2024-11-13',
                'duration' => 4,
                'price' => 600000,
                'platform_fee' => 30000,
                'total_price' => 630000,
                'special_notes' => null,
                'created_at' => '2024-11-08 16:45:00',
                'completed_at' => '2024-11-13 18:00:00',
                'review_given' => false
            ],
            [
                'id' => 5,
                'booking_code' => 'BOOK-005',
                'status' => 'completed',
                'service' => 'Grooming',
                'service_icon' => 'fa-scissors',
                'cat_name' => 'Milo',
                'cat_photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=200',
                'sitter' => [
                    'id' => 5,
                    'name' => 'Emily Watson',
                    'photo' => 'https://ui-avatars.com/api/?name=Emily+Watson&background=FFA726&color=fff&size=200',
                    'rating' => 4.9,
                    'location' => 'East Jakarta'
                ],
                'start_date' => '2024-11-05',
                'end_date' => '2024-11-05',
                'duration' => 1,
                'price' => 120000,
                'platform_fee' => 6000,
                'total_price' => 126000,
                'special_notes' => null,
                'created_at' => '2024-11-03 11:30:00',
                'completed_at' => '2024-11-05 15:30:00',
                'review_given' => true
            ],
            [
                'id' => 6,
                'booking_code' => 'BOOK-006',
                'status' => 'cancelled',
                'service' => 'Home Visit',
                'service_icon' => 'fa-house-user',
                'cat_name' => 'Whiskers',
                'cat_photo' => 'https://images.unsplash.com/photo-1573865526739-10c1dd7aa5c0?w=200',
                'sitter' => [
                    'id' => 6,
                    'name' => 'James Brown',
                    'photo' => 'https://ui-avatars.com/api/?name=James+Brown&background=FFA726&color=fff&size=200',
                    'rating' => 4.6,
                    'location' => 'Central Jakarta'
                ],
                'start_date' => '2024-11-15',
                'end_date' => '2024-11-17',
                'duration' => 3,
                'price' => 270000,
                'platform_fee' => 13500,
                'total_price' => 283500,
                'special_notes' => null,
                'created_at' => '2024-11-12 13:20:00',
                'cancelled_at' => '2024-11-14 10:00:00',
                'cancel_reason' => 'Change of plans'
            ]
        ];

        $statusCounts = [
            'all' => count($allBookings),
            'pending' => count(array_filter($allBookings, fn($b) => $b['status'] === 'pending')),
            'confirmed' => count(array_filter($allBookings, fn($b) => $b['status'] === 'confirmed')),
            'in_progress' => count(array_filter($allBookings, fn($b) => $b['status'] === 'in_progress')),
            'completed' => count(array_filter($allBookings, fn($b) => $b['status'] === 'completed')),
            'cancelled' => count(array_filter($allBookings, fn($b) => $b['status'] === 'cancelled'))
        ];

        return view('pages.dashboard_user.my-request.index', [
            'bookings' => $bookings,
            'statusFilter' => $statusFilter,
            'statusCounts' => $statusCounts
        ]);
    }

    public function show($id)
    {
        // Hardcoded single booking detail for UI testing
        $bookings = [
            1 => [
                'id' => 1,
                'booking_code' => 'BOOK-001',
                'status' => 'pending',
                'service' => 'Cat Sitting',
                'service_icon' => 'fa-home',
                'cat_name' => 'Luna',
                'cat_breed' => 'Persian',
                'cat_age' => '2 years',
                'cat_photo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400',
                'sitter' => [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'photo' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FFA726&color=fff&size=400',
                    'rating' => 4.9,
                    'total_reviews' => 156,
                    'location' => 'Central Jakarta',
                    'phone' => '+62 812-3456-7890',
                    'joined_date' => 'January 2023'
                ],
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-05',
                'duration' => 5,
                'price' => 750000,
                'platform_fee' => 37500,
                'total_price' => 787500,
                'special_notes' => 'Please feed twice a day (morning and evening). Luna likes to play with feather toys. She\'s shy at first but warms up quickly.',
                'created_at' => '2024-11-20 10:30:00',
                'payment_status' => 'pending',
                'payment_method' => null
            ],
            2 => [
                'id' => 2,
                'booking_code' => 'BOOK-002',
                'status' => 'confirmed',
                'service' => 'Grooming',
                'service_icon' => 'fa-scissors',
                'cat_name' => 'Milo',
                'cat_breed' => 'British Shorthair',
                'cat_age' => '3 years',
                'cat_photo' => 'https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=400',
                'sitter' => [
                    'id' => 2,
                    'name' => 'Michael Chen',
                    'photo' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=FFA726&color=fff&size=400',
                    'rating' => 4.8,
                    'total_reviews' => 98,
                    'location' => 'South Jakarta',
                    'phone' => '+62 813-9876-5432',
                    'joined_date' => 'March 2023'
                ],
                'start_date' => '2024-11-28',
                'end_date' => '2024-11-28',
                'duration' => 1,
                'price' => 150000,
                'platform_fee' => 7500,
                'total_price' => 157500,
                'special_notes' => null,
                'created_at' => '2024-11-18 14:20:00',
                'confirmed_at' => '2024-11-19 09:15:00',
                'payment_status' => 'paid',
                'payment_method' => 'Bank Transfer'
            ]
        ];

        $booking = $bookings[$id] ?? abort(404);

        return view('pages.dashboard_user.my-request.show', [
            'booking' => $booking
        ]);
    }
}
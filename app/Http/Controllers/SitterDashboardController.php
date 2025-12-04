<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitterDashboardController extends Controller
{
    /**
     * Display the sitter dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get authenticated sitter info (assuming user has sitter profile)
        $sitter = [
            'id' => 1,
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@example.com',
            'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FF9800&color=fff',
            'rating' => 4.8,
            'total_reviews' => 24,
            'member_since' => '2023-01-15'
        ];

        // Statistics for dashboard cards
        $stats = [
            'total_orders' => 47,
            'daily_earnings' => 450000,
            'yesterday_earnings' => 380000,
            'monthly_earnings' => 8750000,
            'pending_requests' => 3,
            'average_rating' => 4.8,
            'total_reviews' => 24,
            'completed_bookings' => 42,
            'active_bookings' => 2,
            'cancelled_bookings' => 3
        ];

        // Earnings data for period switcher
        $earnings_data = [
            'today' => [
                'amount' => 450000,
                'label' => 'Hari Ini',
                'date' => date('d F Y'),
                'bookings' => 3
            ],
            'yesterday' => [
                'amount' => 380000,
                'label' => 'Kemarin',
                'date' => date('d F Y', strtotime('-1 day')),
                'bookings' => 2
            ],
            'month' => [
                'amount' => 8750000,
                'label' => 'Bulan Ini',
                'date' => date('F Y'),
                'bookings' => 18
            ]
        ];

        // Chart data for earnings trend (6 months)
        $chart_data = [
            '6_months' => [
                'labels' => ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
                'data' => [1850000, 2100000, 1950000, 2300000, 2050000, 2200000],
                'total' => 12450000,
                'average' => 2075000,
                'bookings' => [8, 9, 8, 10, 9, 10]
            ],
            '12_months' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'data' => [1500000, 1650000, 1800000, 1750000, 1900000, 1850000, 2100000, 1950000, 2300000, 2050000, 2200000, 1800000],
                'total' => 22850000,
                'average' => 1904167,
                'bookings' => [6, 7, 8, 7, 8, 8, 9, 8, 10, 9, 10, 8]
            ],
            '3_months' => [
                'labels' => ['Sep', 'Okt', 'Nov'],
                'data' => [2300000, 2050000, 2200000],
                'total' => 6550000,
                'average' => 2183333,
                'bookings' => [10, 9, 10]
            ]
        ];

        // Notifications & Alerts
        $notifications = [
            [
                'id' => 1,
                'type' => 'new_request',
                'icon' => 'inbox',
                'category' => 'request',
                'user_name' => 'Michael Chen',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=4CAF50&color=fff',
                'title' => 'Request Baru dari Michael Chen',
                'message' => 'Cat Boarding - 3 hari (15-18 Des 2024)',
                'service' => 'Cat Boarding',
                'duration' => '3 hari',
                'date_range' => '15-18 Des 2024',
                'cats' => '1 kucing (Milo)',
                'time_ago' => '5 menit yang lalu',
                'is_new' => true,
                'is_urgent' => false,
                'created_at' => now()->subMinutes(5)
            ],
            [
                'id' => 2,
                'type' => 'new_request',
                'icon' => 'inbox',
                'category' => 'request',
                'user_name' => 'Lisa Anderson',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&background=2196F3&color=fff',
                'title' => 'Request Baru dari Lisa Anderson',
                'message' => 'Daily Visit - 5 hari (20-25 Des 2024)',
                'service' => 'Daily Visit',
                'duration' => '5 hari',
                'date_range' => '20-25 Des 2024',
                'cats' => '2 kucing (Luna & Max)',
                'time_ago' => '2 jam yang lalu',
                'is_new' => true,
                'is_urgent' => false,
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 3,
                'type' => 'booking_upcoming',
                'icon' => 'calendar-check',
                'category' => 'booking',
                'user_name' => 'Sarah Williams',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Sarah+Williams&background=FF9800&color=fff',
                'title' => 'Booking Dimulai Besok!',
                'message' => 'Sarah Williams - Cat Sitting (1 Des 2024)',
                'service' => 'Cat Sitting',
                'date' => '1 Des 2024',
                'time' => '09:00',
                'time_ago' => 'Besok, 09:00',
                'is_new' => false,
                'is_urgent' => true,
                'created_at' => now()->subHours(12)
            ],
            [
                'id' => 4,
                'type' => 'new_review',
                'icon' => 'star',
                'category' => 'review',
                'user_name' => 'David Martinez',
                'user_avatar' => 'https://ui-avatars.com/api/?name=David+Martinez&background=FFC107&color=fff',
                'title' => 'Review Baru - Rating 5⭐',
                'message' => 'David Martinez memberikan review positif',
                'rating' => 5,
                'review_text' => 'Excellent service! My cat was very happy and well cared for.',
                'time_ago' => '1 hari yang lalu',
                'is_new' => false,
                'is_urgent' => false,
                'created_at' => now()->subDay()
            ],
            [
                'id' => 5,
                'type' => 'booking_today',
                'icon' => 'clock',
                'category' => 'booking',
                'user_name' => 'Emma Thompson',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Emma+Thompson&background=9C27B0&color=fff',
                'title' => 'Booking Dimulai Hari Ini!',
                'message' => 'Emma Thompson - Daily Visit (30 Nov 2024)',
                'service' => 'Daily Visit',
                'date' => '30 Nov 2024',
                'time' => '14:00',
                'time_ago' => 'Hari ini, 14:00',
                'is_new' => false,
                'is_urgent' => true,
                'created_at' => now()->subHours(6)
            ]
        ];

        // Recent Booking Requests (Top 3 pending)
        $recent_requests = [
            [
                'id' => 1,
                'booking_code' => 'REQ-2024-001',
                'user_name' => 'Michael Chen',
                'user_email' => 'michael.chen@example.com',
                'user_phone' => '+62 812-3456-7890',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=4CAF50&color=fff',
                'service' => 'Cat Boarding',
                'service_type' => 'boarding',
                'date_range' => '15-18 Des 2024',
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-18',
                'duration' => '3 hari',
                'duration_days' => 3,
                'cats' => [
                    [
                        'name' => 'Milo',
                        'breed' => 'Persian',
                        'age' => 2,
                        'gender' => 'Male'
                    ]
                ],
                'cats_count' => 1,
                'cats_display' => '1 kucing (Milo)',
                'total_price' => 450000,
                'notes' => 'Milo suka makanan basah dan perlu dimandikan setiap hari',
                'status' => 'pending',
                'created_at' => '2024-11-30 08:30:00',
                'time_ago' => '2 jam yang lalu'
            ],
            [
                'id' => 2,
                'booking_code' => 'REQ-2024-002',
                'user_name' => 'Lisa Anderson',
                'user_email' => 'lisa.anderson@example.com',
                'user_phone' => '+62 813-9876-5432',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Lisa+Anderson&background=2196F3&color=fff',
                'service' => 'Daily Visit',
                'service_type' => 'daily_visit',
                'date_range' => '20-25 Des 2024',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-25',
                'duration' => '5 hari',
                'duration_days' => 5,
                'cats' => [
                    [
                        'name' => 'Luna',
                        'breed' => 'British Shorthair',
                        'age' => 3,
                        'gender' => 'Female'
                    ],
                    [
                        'name' => 'Max',
                        'breed' => 'Maine Coon',
                        'age' => 1,
                        'gender' => 'Male'
                    ]
                ],
                'cats_count' => 2,
                'cats_display' => '2 kucing (Luna & Max)',
                'total_price' => 750000,
                'notes' => 'Luna dan Max perlu diberi makan 2x sehari, pagi dan sore',
                'status' => 'pending',
                'created_at' => '2024-11-30 06:00:00',
                'time_ago' => '5 jam yang lalu'
            ],
            [
                'id' => 3,
                'booking_code' => 'REQ-2024-003',
                'user_name' => 'John Smith',
                'user_email' => 'john.smith@example.com',
                'user_phone' => '+62 821-5555-4444',
                'user_avatar' => 'https://ui-avatars.com/api/?name=John+Smith&background=FF9800&color=fff',
                'service' => 'Cat Sitting',
                'service_type' => 'sitting',
                'date_range' => '10-12 Des 2024',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-12',
                'duration' => '2 hari',
                'duration_days' => 2,
                'cats' => [
                    [
                        'name' => 'Whiskers',
                        'breed' => 'Siamese',
                        'age' => 4,
                        'gender' => 'Male'
                    ]
                ],
                'cats_count' => 1,
                'cats_display' => '1 kucing (Whiskers)',
                'total_price' => 300000,
                'notes' => 'Whiskers sangat aktif, perlu waktu bermain minimal 30 menit sehari',
                'status' => 'accepted',
                'accepted_at' => '2024-11-29 15:00:00',
                'created_at' => '2024-11-29 10:00:00',
                'time_ago' => '1 hari yang lalu'
            ]
        ];

        // Upcoming Bookings (Next 3 confirmed bookings)
        $upcoming_bookings = [
            [
                'id' => 1,
                'booking_code' => 'BKG-2024-101',
                'user_name' => 'Sarah Williams',
                'user_email' => 'sarah.williams@example.com',
                'user_phone' => '+62 856-7777-8888',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Sarah+Williams&background=E91E63&color=fff',
                'service' => 'Cat Sitting',
                'service_type' => 'sitting',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-01',
                'date_display' => '01 Des',
                'day' => '01',
                'month' => 'Des',
                'time' => '09:00 - 18:00',
                'duration' => '1 hari',
                'cats' => [
                    [
                        'name' => 'Bella',
                        'breed' => 'Ragdoll',
                        'age' => 2
                    ],
                    [
                        'name' => 'Charlie',
                        'breed' => 'Scottish Fold',
                        'age' => 3
                    ]
                ],
                'cats_display' => 'Bella & Charlie',
                'location' => 'South Jakarta',
                'address' => 'Jl. Cipete Raya No. 45, Cipete Selatan',
                'total_price' => 200000,
                'status' => 'confirmed',
                'status_display' => 'Besok',
                'days_until' => 1
            ],
            [
                'id' => 2,
                'booking_code' => 'BKG-2024-102',
                'user_name' => 'David Martinez',
                'user_email' => 'david.martinez@example.com',
                'user_phone' => '+62 877-3333-2222',
                'user_avatar' => 'https://ui-avatars.com/api/?name=David+Martinez&background=00BCD4&color=fff',
                'service' => 'Cat Boarding',
                'service_type' => 'boarding',
                'start_date' => '2024-12-05',
                'end_date' => '2024-12-08',
                'date_display' => '05 Des',
                'day' => '05',
                'month' => 'Des',
                'time' => '3 hari',
                'duration' => '3 hari',
                'cats' => [
                    [
                        'name' => 'Oliver',
                        'breed' => 'Bengal',
                        'age' => 1
                    ]
                ],
                'cats_display' => 'Oliver',
                'location' => 'Central Jakarta',
                'address' => 'Jl. Sudirman No. 123, Tanah Abang',
                'total_price' => 450000,
                'status' => 'confirmed',
                'status_display' => '5 hari lagi',
                'days_until' => 5
            ],
            [
                'id' => 3,
                'booking_code' => 'BKG-2024-103',
                'user_name' => 'Emma Thompson',
                'user_email' => 'emma.thompson@example.com',
                'user_phone' => '+62 888-1111-9999',
                'user_avatar' => 'https://ui-avatars.com/api/?name=Emma+Thompson&background=673AB7&color=fff',
                'service' => 'Daily Visit',
                'service_type' => 'daily_visit',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-15',
                'date_display' => '10 Des',
                'day' => '10',
                'month' => 'Des',
                'time' => '5 hari',
                'duration' => '5 hari',
                'cats' => [
                    [
                        'name' => 'Simba',
                        'breed' => 'Orange Tabby',
                        'age' => 2
                    ]
                ],
                'cats_display' => 'Simba',
                'location' => 'North Jakarta',
                'address' => 'Jl. Kelapa Gading Barat No. 88, Kelapa Gading',
                'total_price' => 500000,
                'status' => 'confirmed',
                'status_display' => '10 hari lagi',
                'days_until' => 10
            ]
        ];

        // Quick Actions data
        $quick_actions = [
            [
                'title' => 'View My Schedule',
                'description' => 'Lihat jadwal booking',
                'icon' => 'calendar-alt',
                'route' => 'sitter.schedule',
                'class' => 'schedule'
            ],
            [
                'title' => 'Edit Services',
                'description' => 'Kelola layanan Anda',
                'icon' => 'cog',
                'route' => 'sitter.services',
                'class' => 'services'
            ],
            [
                'title' => 'Update Profile',
                'description' => 'Edit profil sitter',
                'icon' => 'user-edit',
                'route' => 'sitter.profile',
                'class' => 'profile'
            ],
            [
                'title' => 'View Earnings',
                'description' => 'Lihat detail pendapatan',
                'icon' => 'chart-line',
                'route' => 'sitter.earnings',
                'class' => 'earnings'
            ]
        ];

        // Return view with all data
        return view('pages.dashboard_sitter.dashboard', compact(
            'sitter',
            'stats',
            'earnings_data',
            'chart_data',
            'notifications',
            'recent_requests',
            'upcoming_bookings',
            'quick_actions'
        ));
    }

    /**
     * Accept a booking request
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptRequest(Request $request, $id)
    {
        // Logic untuk accept request
        // Nanti akan update database
        
        return response()->json([
            'success' => true,
            'message' => 'Request berhasil diterima!',
            'data' => [
                'request_id' => $id,
                'status' => 'accepted',
                'accepted_at' => now()
            ]
        ]);
    }

    /**
     * Reject a booking request
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rejectRequest(Request $request, $id)
    {
        // Validate rejection reason
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        // Logic untuk reject request
        // Nanti akan update database
        
        return response()->json([
            'success' => true,
            'message' => 'Request berhasil ditolak',
            'data' => [
                'request_id' => $id,
                'status' => 'rejected',
                'reason' => $request->reason,
                'rejected_at' => now()
            ]
        ]);
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markNotificationsRead()
    {
        // Logic untuk mark all notifications as read
        // Nanti akan update database
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai dibaca',
            'data' => [
                'marked_count' => 5,
                'marked_at' => now()
            ]
        ]);
    }

    /**
     * Get earnings data for chart
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEarningsData(Request $request)
    {
        $period = $request->input('period', '6'); // 3, 6, or 12 months

        $chart_data = [
            '3' => [
                'labels' => ['Sep', 'Okt', 'Nov'],
                'data' => [2300000, 2050000, 2200000],
                'total' => 6550000,
                'average' => 2183333
            ],
            '6' => [
                'labels' => ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
                'data' => [1850000, 2100000, 1950000, 2300000, 2050000, 2200000],
                'total' => 12450000,
                'average' => 2075000
            ],
            '12' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                'data' => [1500000, 1650000, 1800000, 1750000, 1900000, 1850000, 2100000, 1950000, 2300000, 2050000, 2200000, 1800000],
                'total' => 22850000,
                'average' => 1904167
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $chart_data[$period] ?? $chart_data['6']
        ]);
    }
}
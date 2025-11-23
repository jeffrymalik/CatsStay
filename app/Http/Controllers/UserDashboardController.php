<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard
     */
    public function index()
    {
        // Get user data
        $user = Auth::user();

        // Stats data (nanti diganti dengan query real dari database)
        $stats = [
            'totalBookings' => 12,      // Total all bookings
            'activeBookings' => 3,       // Currently active bookings
            'myCats' => 5,               // Total registered cats
            'unreadMessages' => 2,       // Unread messages count
        ];

        // Upcoming bookings (dummy data - nanti diganti dengan query real)
        $upcomingBookings = [
            // Uncomment untuk test dengan data
            // (object)[
            //     'id' => 1,
            //     'start_date' => 'Dec 25, 2024',
            //     'end_date' => 'Dec 30, 2024',
            //     'status' => 'confirmed',
            //     'sitter_name' => 'Anggara',
            //     'sitter_id' => 1,
            //     'sitter_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop',
            //     'location' => 'Jakarta Selatan',
            //     'total_price' => 300000,
            // ],
            // (object)[
            //     'id' => 2,
            //     'start_date' => 'Jan 5, 2025',
            //     'end_date' => 'Jan 10, 2025',
            //     'status' => 'pending',
            //     'sitter_name' => 'Nazar',
            //     'sitter_id' => 2,
            //     'sitter_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop',
            //     'location' => 'Jakarta Pusat',
            //     'total_price' => 450000,
            // ],
        ];

        // Pass data ke view
        return view('pages.dashboard_user.dashboard', [
            'user' => $user,
            'totalBookings' => $stats['totalBookings'],
            'activeBookings' => $stats['activeBookings'],
            'myCats' => $stats['myCats'],
            'unreadMessages' => $stats['unreadMessages'],
            'upcomingBookings' => $upcomingBookings,
        ]);
    }

    /**
     * Contoh query untuk real data (uncomment nanti setelah database ready)
     */
    private function getRealStats()
    {
        $user = Auth::user();

        return [
            // Total bookings user ini
            // 'totalBookings' => Booking::where('user_id', $user->id)->count(),
            
            // Active bookings (status confirmed dan tanggal masih berlangsung)
            // 'activeBookings' => Booking::where('user_id', $user->id)
            //     ->where('status', 'confirmed')
            //     ->where('end_date', '>=', now())
            //     ->count(),
            
            // Total cats registered
            // 'myCats' => Cat::where('user_id', $user->id)->count(),
            
            // Unread messages
            // 'unreadMessages' => Message::where('receiver_id', $user->id)
            //     ->where('is_read', false)
            //     ->count(),
        ];
    }

    private function getUpcomingBookings()
    {
        $user = Auth::user();

        // Real query (uncomment setelah database ready)
        // return Booking::where('user_id', $user->id)
        //     ->whereIn('status', ['confirmed', 'pending'])
        //     ->where('start_date', '>=', now())
        //     ->orderBy('start_date', 'asc')
        //     ->with(['sitter', 'cat'])
        //     ->limit(5)
        //     ->get();

        return [];
    }
}
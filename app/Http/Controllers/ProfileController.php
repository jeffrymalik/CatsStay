<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display My Profile section
     */
    public function index()
    {
        // Hardcoded user data
        $user = [
            'name' => 'Jeffry Malik',
            'first_name' => 'Jeffry',
            'last_name' => 'Malik',
            'email' => 'jeffrymalik123@gmail.com',
            'phone' => '+62 812-3456-7890',
            'bio' => 'Cat owner from Jakarta who loves spending time with furry friends',
            'role' => 'normal',
            'photo' => null, // Will show initials
            'joined' => '15 October 2024',
        ];

        return view('pages.profile.index', compact('user'));
    }

    /**
     * Display Address section
     */
    public function address()
    {
        // Hardcoded user data
        $user = [
            'name' => 'Jeffry Malik',
            'first_name' => 'Jeffry',
            'last_name' => 'Malik',
            'email' => 'jeffrymalik123@gmail.com',
            'role' => 'normal',
            'photo' => null,
        ];

        // Hardcoded address data
        $address = [
            'country' => 'Indonesia',
            'city' => 'Jakarta Barat',
            'postal_code' => '11530',
            'province' => 'DKI Jakarta',
            'full_address' => 'Jl. Kebon Jeruk No. 123, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk',
        ];

        return view('pages.profile.address', compact('user', 'address'));
    }

    /**
     * Display My Reviews section (completed bookings only)
     */
    public function reviews()
    {
        // Hardcoded user data
        $user = [
            'name' => 'Jeffry Malik',
            'first_name' => 'Jeffry',
            'last_name' => 'Malik',
            'email' => 'jeffrymalik123@gmail.com',
            'role' => 'normal',
            'photo' => null,
        ];

        // Hardcoded reviews data (from completed bookings)
        $reviews = [
            [
                'id' => 1,
                'booking_code' => 'BOOK-001',
                'sitter_name' => 'Sarah Johnson',
                'sitter_photo' => null,
                'service_type' => 'Cat Sitting',
                'rating' => 5,
                'review' => 'Excellent service! Luna was very happy and well taken care of. Sarah sent me daily updates with photos and videos. I could tell Luna felt comfortable and safe. Highly recommended!',
                'date' => '2024-11-22',
                'time_ago' => '3 days ago',
                'can_edit' => true,
            ],
            [
                'id' => 2,
                'booking_code' => 'BOOK-002',
                'sitter_name' => 'Michael Chen',
                'sitter_photo' => null,
                'service_type' => 'Grooming',
                'rating' => 4,
                'review' => 'Great grooming service! Milo looks amazing and his coat is so shiny now. Michael was professional and gentle with him. Will definitely book again.',
                'date' => '2024-11-18',
                'time_ago' => '1 week ago',
                'can_edit' => false, // Past 7-day edit window
            ],
            [
                'id' => 3,
                'booking_code' => 'BOOK-003',
                'sitter_name' => 'Amanda Lee',
                'sitter_photo' => null,
                'service_type' => 'Home Visit',
                'rating' => 5,
                'review' => 'Amanda was wonderful! She came exactly on time and spent quality time with Whiskers. Left detailed notes about the visit. Very professional and caring.',
                'date' => '2024-11-10',
                'time_ago' => '2 weeks ago',
                'can_edit' => false,
            ],
        ];

        return view('pages.profile.reviews', compact('user', 'reviews'));
    }

    /**
     * Display Notifications section (inbox/history)
     */
    public function notifications()
    {
        // Hardcoded user data
        $user = [
            'name' => 'Jeffry Malik',
            'first_name' => 'Jeffry',
            'last_name' => 'Malik',
            'email' => 'jeffrymalik123@gmail.com',
            'role' => 'normal',
            'photo' => null,
        ];

        // Hardcoded notifications data
        $notifications = [
            [
                'id' => 1,
                'type' => 'booking',
                'icon' => 'fa-calendar-check',
                'title' => 'Booking Confirmed',
                'message' => 'Your booking with Sarah Johnson has been confirmed for tomorrow.',
                'time' => '2 hours ago',
                'is_read' => false,
                'link' => '/my-request/1',
            ],
            [
                'id' => 2,
                'type' => 'payment',
                'icon' => 'fa-credit-card',
                'title' => 'Payment Successful',
                'message' => 'Payment for booking BOOK-001 has been processed successfully.',
                'time' => 'Yesterday',
                'is_read' => false,
                'link' => '/my-request/1',
            ],
            [
                'id' => 3,
                'type' => 'message',
                'icon' => 'fa-comment',
                'title' => 'New Message',
                'message' => 'Sarah Johnson: "Looking forward to meeting Luna! Any special instructions?"',
                'time' => 'Yesterday',
                'is_read' => false,
                'link' => '/messages/1',
            ],
            [
                'id' => 4,
                'type' => 'review',
                'icon' => 'fa-star',
                'title' => 'Review Reminder',
                'message' => 'Your booking with Michael Chen is complete. Please leave a review!',
                'time' => '3 days ago',
                'is_read' => true,
                'link' => '/my-request/2',
            ],
            [
                'id' => 5,
                'type' => 'booking',
                'icon' => 'fa-calendar-check',
                'title' => 'Booking Completed',
                'message' => 'Your booking BOOK-002 with Michael Chen has been completed.',
                'time' => '1 week ago',
                'is_read' => true,
                'link' => '/my-request/2',
            ],
            [
                'id' => 6,
                'type' => 'message',
                'icon' => 'fa-comment',
                'title' => 'New Message',
                'message' => 'Amanda Lee: "Home visit completed! Whiskers was great today."',
                'time' => '2 weeks ago',
                'is_read' => true,
                'link' => '/messages/3',
            ],
        ];

        // Count unread notifications
        $unreadCount = collect($notifications)->where('is_read', false)->count();

        return view('pages.profile.notifications', compact('user', 'notifications', 'unreadCount'));
    }

    /**
     * Update profile (placeholder for future)
     */
    public function update(Request $request)
    {
        // TODO: Implement profile update logic
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update address (placeholder for future)
     */
    public function updateAddress(Request $request)
    {
        // TODO: Implement address update logic
        return redirect()->route('profile.address')->with('success', 'Address updated successfully!');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
            ],
            'new_password_confirmation' => 'required',
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        // TODO: When implementing with real database:
        // 1. Verify current password matches user's actual password
        // 2. Hash the new password
        // 3. Update password in database
        // 4. Send password change notification email
        // 5. Log out other sessions (optional)

        // For now, just simulate success
        // In production, you would do:
        /*
        use Illuminate\Support\Facades\Hash;
        
        $user = Auth::user();
        
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.index')
                ->with('error', 'Current password is incorrect!');
        }
        
        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        // Optional: Log out other sessions
        // Auth::logoutOtherDevices($request->new_password);
        
        // Optional: Send email notification
        // $user->notify(new PasswordChangedNotification());
        */

        return redirect()->route('profile.index')
            ->with('success', 'Password changed successfully!');
    }
}
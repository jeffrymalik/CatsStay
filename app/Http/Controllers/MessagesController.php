<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search', '');

        // Get all bookings where user is involved (as user or sitter)
        $bookings = Booking::where(function($query) use ($user) {
                            $query->where('user_id', $user->id)
                                  ->orWhere('sitter_id', $user->id);
                        })
                        ->whereNotNull('confirmed_at')
                        ->with(['user', 'sitter', 'lastMessage'])
                        ->get();

        // Map to conversations
        $conversations = $bookings->map(function($booking) use ($user) {
            // Determine the other party
            $otherUser = $booking->user_id === $user->id ? $booking->sitter : $booking->user;
            
            $lastMsg = $booking->lastMessage;
            
            // Count unread messages
            $unreadCount = Message::where('booking_id', $booking->id)
                                 ->where('receiver_id', $user->id)
                                 ->where('is_read', false)
                                 ->count();

            return [
                'id' => $booking->id,
                'sitter' => [
                    'id' => $otherUser->id,
                    'name' => $otherUser->name,
                    'photo' => $otherUser->avatar_url,
                    'is_online' => false, // TODO: Implement online status
                    'last_seen' => $otherUser->last_login_at ? $otherUser->last_login_at->format('Y-m-d H:i:s') : null,
                ],
                'last_message' => $lastMsg ? $lastMsg->message : 'No messages yet',
                'last_message_time' => $lastMsg ? $lastMsg->created_at->format('Y-m-d H:i:s') : null,
                'last_message_sender' => $lastMsg ? ($lastMsg->sender_id === $user->id ? 'user' : 'sitter') : null,
                'unread_count' => $unreadCount,
                'booking_code' => $booking->booking_code,
            ];
        });

        // Filter by search
        if ($search) {
            $conversations = $conversations->filter(function($conv) use ($search) {
                return stripos($conv['sitter']['name'], $search) !== false;
            });
        }

        $totalUnread = $conversations->sum('unread_count');

        return view('pages.dashboard_user.messages.index', [
            'conversations' => $conversations->values(),
            'search' => $search,
            'totalUnread' => $totalUnread,
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $booking = Booking::where('id', $id)
                         ->where(function($query) use ($user) {
                             $query->where('user_id', $user->id)
                                   ->orWhere('sitter_id', $user->id);
                         })
                         ->with(['user', 'sitter', 'messages.sender'])
                         ->firstOrFail();

        // Determine the other party
        $otherUser = $booking->user_id === $user->id ? $booking->sitter : $booking->user;
        $profile = $otherUser->isSitter() ? $otherUser->sitterProfile : null;

        $conversation = [
            'id' => $booking->id,
            'sitter' => [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'photo' => $otherUser->avatar_url,
                'rating' => $profile ? $profile->rating_average : null,
                'is_online' => false, // TODO: Implement
            ],
            'booking_code' => $booking->booking_code,
            'messages' => $booking->messages->map(function($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_id === $user->id ? 'user' : 'sitter',
                    'sender_name' => $msg->sender_id === $user->id ? 'You' : $msg->sender->name,
                    'message' => $msg->message,
                    'timestamp' => $msg->created_at->format('Y-m-d H:i:s'),
                    'is_read' => $msg->is_read,
                ];
            }),
        ];

        // Mark messages as read
        Message::where('booking_id', $booking->id)
               ->where('receiver_id', $user->id)
               ->where('is_read', false)
               ->update([
                   'is_read' => true,
                   'read_at' => now(),
               ]);

        return view('pages.dashboard_user.messages.show', [
            'conversation' => $conversation
        ]);
    }

    public function send(Request $request, $id)
    {
        $user = Auth::user();
        
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $booking = Booking::where('id', $id)
                         ->where(function($query) use ($user) {
                             $query->where('user_id', $user->id)
                                   ->orWhere('sitter_id', $user->id);
                         })
                         ->firstOrFail();

        // Determine receiver
        $receiverId = $booking->user_id === $user->id ? $booking->sitter_id : $booking->user_id;

        $message = Message::create([
            'booking_id' => $booking->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender_type' => 'user',
                'sender_name' => 'You',
                'message' => $message->message,
                'timestamp' => $message->created_at->format('Y-m-d H:i:s'),
                'is_read' => false,
            ]
        ]);
    }
}
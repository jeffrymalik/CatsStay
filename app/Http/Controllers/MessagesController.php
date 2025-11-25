<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        // Hardcoded conversations for UI testing
        $conversations = [
            [
                'id' => 1,
                'sitter' => [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'photo' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FFA726&color=fff&size=200',
                    'is_online' => true
                ],
                'last_message' => 'Great! Luna really enjoyed her stay. She ate well and played a lot!',
                'last_message_time' => '2024-11-25 14:30:00',
                'last_message_sender' => 'sitter',
                'unread_count' => 2,
                'booking_code' => 'BOOK-001'
            ],
            [
                'id' => 2,
                'sitter' => [
                    'id' => 2,
                    'name' => 'Michael Chen',
                    'photo' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=FFA726&color=fff&size=200',
                    'is_online' => false,
                    'last_seen' => '2024-11-25 12:00:00'
                ],
                'last_message' => 'The grooming session is completed. Milo looks amazing!',
                'last_message_time' => '2024-11-25 11:00:00',
                'last_message_sender' => 'sitter',
                'unread_count' => 0,
                'booking_code' => 'BOOK-002'
            ],
            [
                'id' => 3,
                'sitter' => [
                    'id' => 3,
                    'name' => 'Amanda Lee',
                    'photo' => 'https://ui-avatars.com/api/?name=Amanda+Lee&background=FFA726&color=fff&size=200',
                    'is_online' => true
                ],
                'last_message' => 'Just finished the home visit. Everything went well!',
                'last_message_time' => '2024-11-25 10:15:00',
                'last_message_sender' => 'sitter',
                'unread_count' => 1,
                'booking_code' => 'BOOK-003'
            ],
            [
                'id' => 4,
                'sitter' => [
                    'id' => 4,
                    'name' => 'David Martinez',
                    'photo' => 'https://ui-avatars.com/api/?name=David+Martinez&background=FFA726&color=fff&size=200',
                    'is_online' => false,
                    'last_seen' => '2024-11-24 18:00:00'
                ],
                'last_message' => 'Thank you for choosing my service!',
                'last_message_time' => '2024-11-24 16:00:00',
                'last_message_sender' => 'sitter',
                'unread_count' => 0,
                'booking_code' => 'BOOK-004'
            ],
            [
                'id' => 5,
                'sitter' => [
                    'id' => 5,
                    'name' => 'Emily Watson',
                    'photo' => 'https://ui-avatars.com/api/?name=Emily+Watson&background=FFA726&color=fff&size=200',
                    'is_online' => false,
                    'last_seen' => '2024-11-20 14:00:00'
                ],
                'last_message' => 'Looking forward to grooming Milo next time!',
                'last_message_time' => '2024-11-20 13:00:00',
                'last_message_sender' => 'user',
                'unread_count' => 0,
                'booking_code' => 'BOOK-005'
            ]
        ];

        // Filter by search query if provided
        $search = $request->query('search', '');
        if ($search) {
            $conversations = array_filter($conversations, function($conv) use ($search) {
                return stripos($conv['sitter']['name'], $search) !== false;
            });
        }

        // Count unread messages
        $totalUnread = array_sum(array_column($conversations, 'unread_count'));

        return view('pages.dashboard_user.messages.index', [
            'conversations' => $conversations,
            'search' => $search,
            'totalUnread' => $totalUnread
        ]);
    }

    public function show($id)
    {
        // Hardcoded conversation detail
        $conversations = [
            1 => [
                'id' => 1,
                'sitter' => [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'photo' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=FFA726&color=fff&size=400',
                    'rating' => 4.9,
                    'is_online' => true
                ],
                'booking_code' => 'BOOK-001',
                'messages' => [
                    [
                        'id' => 1,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Hi Sarah! I just wanted to confirm the booking for Luna next week.',
                        'timestamp' => '2024-11-25 09:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 2,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Sarah Johnson',
                        'message' => 'Hello! Yes, I have your booking confirmed for December 1-5. Looking forward to taking care of Luna!',
                        'timestamp' => '2024-11-25 09:15:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 3,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Great! Just a reminder that Luna needs to be fed twice a day, morning and evening.',
                        'timestamp' => '2024-11-25 09:30:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 4,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Sarah Johnson',
                        'message' => 'Noted! I\'ll make sure she gets her meals on time. Does she have any favorite toys or activities?',
                        'timestamp' => '2024-11-25 09:45:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 5,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'She loves feather toys and laser pointers! She\'s also quite playful in the evening.',
                        'timestamp' => '2024-11-25 10:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 6,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Sarah Johnson',
                        'message' => 'Perfect! I have feather toys here. I\'ll make sure to give her plenty of playtime. 😊',
                        'timestamp' => '2024-11-25 10:15:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 7,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Thank you so much! I feel much better knowing she\'ll be in good hands.',
                        'timestamp' => '2024-11-25 10:30:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 8,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Sarah Johnson',
                        'message' => 'You\'re welcome! I\'ll send you updates and photos during her stay.',
                        'timestamp' => '2024-11-25 14:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 9,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Sarah Johnson',
                        'message' => 'Great! Luna really enjoyed her stay. She ate well and played a lot!',
                        'timestamp' => '2024-11-25 14:30:00',
                        'is_read' => false
                    ]
                ]
            ],
            2 => [
                'id' => 2,
                'sitter' => [
                    'id' => 2,
                    'name' => 'Michael Chen',
                    'photo' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=FFA726&color=fff&size=400',
                    'rating' => 4.8,
                    'is_online' => false,
                    'last_seen' => '2024-11-25 12:00:00'
                ],
                'booking_code' => 'BOOK-002',
                'messages' => [
                    [
                        'id' => 1,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Hi Michael! I\'d like to book a grooming session for Milo.',
                        'timestamp' => '2024-11-25 08:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 2,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Michael Chen',
                        'message' => 'Hello! I have availability this Thursday at 2 PM. Would that work for you?',
                        'timestamp' => '2024-11-25 08:30:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 3,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Perfect! Thursday at 2 PM works great.',
                        'timestamp' => '2024-11-25 09:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 4,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Michael Chen',
                        'message' => 'The grooming session is completed. Milo looks amazing!',
                        'timestamp' => '2024-11-25 11:00:00',
                        'is_read' => true
                    ]
                ]
            ],
            3 => [
                'id' => 3,
                'sitter' => [
                    'id' => 3,
                    'name' => 'Amanda Lee',
                    'photo' => 'https://ui-avatars.com/api/?name=Amanda+Lee&background=FFA726&color=fff&size=400',
                    'rating' => 5.0,
                    'is_online' => true
                ],
                'booking_code' => 'BOOK-003',
                'messages' => [
                    [
                        'id' => 1,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Hi Amanda! Can you do a home visit for Whiskers this week?',
                        'timestamp' => '2024-11-25 07:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 2,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Amanda Lee',
                        'message' => 'Yes! I can visit on Wednesday and Friday. What time works best?',
                        'timestamp' => '2024-11-25 07:30:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 3,
                        'sender_type' => 'user',
                        'sender_name' => 'You',
                        'message' => 'Morning time around 9 AM would be great!',
                        'timestamp' => '2024-11-25 08:00:00',
                        'is_read' => true
                    ],
                    [
                        'id' => 4,
                        'sender_type' => 'sitter',
                        'sender_name' => 'Amanda Lee',
                        'message' => 'Just finished the home visit. Everything went well!',
                        'timestamp' => '2024-11-25 10:15:00',
                        'is_read' => false
                    ]
                ]
            ]
        ];

        $conversation = $conversations[$id] ?? abort(404);

        return view('pages.dashboard_user.messages.show', [
            'conversation' => $conversation
        ]);
    }

    public function send(Request $request, $id)
    {
        // TODO: In real implementation, save message to database
        // For now, just return success
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => rand(100, 999),
                'sender_type' => 'user',
                'sender_name' => 'You',
                'message' => $request->message,
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'is_read' => false
            ]
        ]);
    }
}
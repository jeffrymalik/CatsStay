<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\SitterEarning;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SitterDashboardController extends Controller
{
    public function index()
    {
        $sitter = Auth::user();
        $profile = $sitter->sitterProfile;

        // Stats
        $stats = [
            // 🆕 TRANSAKSI HARI INI (yang sudah bayar)
            'today_transactions' => Booking::where('sitter_id', $sitter->id)
                                          ->whereHas('payment', function($q) {
                                              $q->whereIn('payment_status', ['confirmed', 'held']);
                                          })
                                          ->whereDate('created_at', today())
                                          ->count(),
            
            // 🆕 PENDAPATAN HARI INI (net earning setelah potong platform fee)
            'today_earnings' => Booking::where('sitter_id', $sitter->id)
                                      ->whereHas('payment', function($q) {
                                          $q->whereIn('payment_status', ['confirmed', 'held']);
                                      })
                                      ->whereDate('created_at', today())
                                      ->get()
                                      ->sum(function($booking) {
                                          return $booking->total_price - $booking->platform_fee;
                                      }),
            
            'total_orders' => $profile->total_bookings,
            'completed_requests' => $profile->completed_bookings,
            'pending_requests' => Booking::where('sitter_id', $sitter->id)->where('status', 'pending')->count(),
            'average_rating' => $profile->rating_average,
            'total_reviews' => $profile->total_reviews,
        ];

        // Earnings data for switcher
        $today = SitterEarning::where('user_id', $sitter->id)
                             ->whereDate('created_at', today())
                             ->sum('net_earning');
        
        $yesterday = SitterEarning::where('user_id', $sitter->id)
                                 ->whereDate('created_at', today()->subDay())
                                 ->sum('net_earning');
        
        $month = SitterEarning::where('user_id', $sitter->id)
                             ->whereMonth('created_at', now()->month)
                             ->sum('net_earning');

        $earnings_data = [
            'today' => $today,
            'yesterday' => $yesterday,
            'month' => $month,
        ];

        // Chart data (last 6 months)
        $chart_data = $this->getChartData($sitter->id, 6);

        // Notifications
        $notifications = $this->getNotifications($sitter->id);

        // Recent requests
        $recent_requests = Booking::where('sitter_id', $sitter->id)
                                 ->where('status', 'pending')
                                 ->with(['user', 'service', 'bookingCats.cat'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(3)
                                 ->get()
                                 ->map(function($booking) {
                                     $cat = $booking->bookingCats->first();
                                     
                                     // Get cat name based on type
                                     $catName = 'N/A';
                                     if ($cat) {
                                         if ($cat->cat_type === 'registered' && $cat->cat) {
                                             $catName = $cat->cat->name;
                                         } elseif ($cat->cat_type === 'new') {
                                             $catName = $cat->new_cat_name;
                                         }
                                     }
                                     
                                     return [
                                         'id' => $booking->id,
                                         'user_name' => $booking->user->name,
                                         'user_avatar' => $booking->user->avatar_url,
                                         'service' => $booking->service->name,
                                         'dates' => $booking->start_date->format('M d') . ' - ' . $booking->end_date->format('M d, Y'),
                                         'duration' => $booking->duration . ' ' . ($booking->duration > 1 ? 'days' : 'day'),
                                         'cats' => $catName,
                                         'status' => $booking->status,
                                     ];
                                 });

        // Upcoming bookings
        $upcoming_bookings = Booking::where('sitter_id', $sitter->id)
                                   ->whereIn('status', ['confirmed', 'payment_confirmed'])
                                   ->where('start_date', '>=', now())
                                   ->with(['user', 'service', 'bookingCats.cat'])
                                   ->orderBy('start_date', 'asc')
                                   ->limit(3)
                                   ->get()
                                   ->map(function($booking) {
                                       $cat = $booking->bookingCats->first();
                                       $daysUntil = now()->diffInDays($booking->start_date);
                                       
                                       // Get cat name based on type
                                       $catName = 'N/A';
                                       if ($cat) {
                                           if ($cat->cat_type === 'registered' && $cat->cat) {
                                               $catName = $cat->cat->name;
                                           } elseif ($cat->cat_type === 'new') {
                                               $catName = $cat->new_cat_name;
                                           }
                                       }
                                       
                                       return [
                                           'id' => $booking->id,
                                           'day' => $booking->start_date->format('d'),
                                           'month' => $booking->start_date->format('M'),
                                           'user_name' => $booking->user->name,
                                           'service' => $booking->service->name,
                                           'time' => $booking->start_date->format('h:i A') . ' - ' . $booking->end_date->format('h:i A'),
                                           'cats' => $catName,
                                           'location' => $booking->user->addresses->first()->city ?? 'N/A',
                                           'status' => $daysUntil === 0 ? 'today' : ($daysUntil === 1 ? 'tomorrow' : 'upcoming'),
                                           'status_text' => $daysUntil === 0 ? 'Today' : ($daysUntil === 1 ? 'Tomorrow' : "In {$daysUntil} days"),
                                       ];
                                   });

        // 🆕 Transaction History (Latest Paid Transactions)
        $transaction_history = Booking::where('sitter_id', $sitter->id)
                                     ->whereHas('payment', function($q) {
                                         $q->whereIn('payment_status', ['confirmed', 'held']);
                                     })
                                     ->with(['user', 'service', 'bookingCats.cat', 'payment'])
                                     ->orderBy('created_at', 'desc')
                                     ->limit(10)
                                     ->get()
                                     ->map(function($booking) {
                                         $cat = $booking->bookingCats->first();
                                         
                                         // Get cat name based on type
                                         $catName = 'N/A';
                                         if ($cat) {
                                             if ($cat->cat_type === 'registered' && $cat->cat) {
                                                 $catName = $cat->cat->name;
                                             } elseif ($cat->cat_type === 'new') {
                                                 $catName = $cat->new_cat_name;
                                             }
                                         }
                                         
                                         return [
                                             'id' => $booking->id,
                                             'booking_code' => $booking->booking_code,
                                             'user_name' => $booking->user->name,
                                             'user_avatar' => $booking->user->avatar_url,
                                             'service' => $booking->service->name,
                                             'cat_name' => $catName,
                                             'total_cats' => $booking->total_cats,
                                             'duration' => $booking->duration . ' ' . ($booking->duration > 1 ? 'days' : 'day'),
                                             'date' => $booking->created_at->format('M d, Y'),
                                             'start_date' => $booking->start_date->format('M d'),
                                             'end_date' => $booking->end_date->format('M d, Y'),
                                             'total_price' => $booking->total_price,
                                             'platform_fee' => $booking->platform_fee,
                                             'net_earning' => $booking->total_price - $booking->platform_fee,
                                             'payment_status' => $booking->payment->payment_status ?? 'pending',
                                             'payment_method' => $booking->payment->payment_method ?? 'N/A',
                                             'status' => $booking->status,
                                         ];
                                     });

        return view('pages.dashboard_sitter.dashboard', compact(
            'sitter',
            'stats',
            'earnings_data',
            'chart_data',
            'notifications',
            'recent_requests',
            'upcoming_bookings',
            'transaction_history'
        ));
    }

    /**
     * Get notifications for sitter
     */
    private function getNotifications($sitterId)
    {
        // Check if notifications exist in database
        $dbNotifications = Notification::where('user_id', $sitterId)
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get();

        // If database notifications exist, use them
        if ($dbNotifications->count() > 0) {
            return $dbNotifications->map(function($notif) {
                return [
                    'title' => $notif->title,
                    'message' => $notif->message,
                    'time' => $notif->created_at->diffForHumans(),
                    'type' => $notif->type,
                    'is_new' => !$notif->is_read,
                    'is_urgent' => $notif->is_urgent ?? false,
                ];
            });
        }

        // Otherwise return dummy notifications for demo
        return collect([
            [
                'title' => 'New Booking Request',
                'message' => 'You have a new booking request',
                'time' => '5 minutes ago',
                'type' => 'request',
                'is_new' => true,
                'is_urgent' => true,
            ],
            [
                'title' => 'Booking Confirmed',
                'message' => 'A customer confirmed their booking',
                'time' => '2 hours ago',
                'type' => 'booking',
                'is_new' => true,
                'is_urgent' => false,
            ],
            [
                'title' => 'New Review',
                'message' => 'You received a 5-star review',
                'time' => '1 day ago',
                'type' => 'review',
                'is_new' => false,
                'is_urgent' => false,
            ],
        ]);
    }

    /**
     * Get chart data for earnings trend
     */
    private function getChartData($sitterId, $months)
    {
        $data = [];
        $labels = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M');
            
            $earning = SitterEarning::where('user_id', $sitterId)
                                   ->whereYear('created_at', $date->year)
                                   ->whereMonth('created_at', $date->month)
                                   ->sum('net_earning');
            
            $data[] = $earning;
        }

        $total = array_sum($data);
        $average = $months > 0 ? $total / $months : 0;

        return [
            'labels' => $labels,
            'data' => $data,
            'total' => $total,
            'average' => round($average),
        ];
    }

    /**
     * AJAX endpoint for earnings data
     */
    public function getEarningsData(Request $request)
    {
        $period = $request->input('period', '6');
        $sitterId = Auth::id();

        $chartData = $this->getChartData($sitterId, (int)$period);

        return response()->json($chartData);
    }

    /**
     * Services management page
     */
    public function services()
    {
        $sitter = Auth::user();
        $profile = $sitter->sitterProfile;

        // Get all services from database
        $allServices = Service::active()->get();

        $services = $allServices->map(function($service) use ($profile, $sitter) {
            $offerField = $service->offer_field;
            $priceField = $service->price_field;
            $descriptionField = $service->description_field;

            return [
                'id' => $service->id,
                'name' => $service->name,
                'slug' => $service->slug,
                'icon' => $service->icon_class,
                'short_description' => $service->short_description,
                'description' => $profile->{$descriptionField} ?? $service->description,
                'is_enabled' => $profile->{$offerField} ?? false,
                'pricing' => [
                    'base_price' => $profile->{$priceField} ?? 0,
                ],
                'total_bookings' => Booking::where('sitter_id', $sitter->id)
                                          ->where('service_id', $service->id)
                                          ->count(),
                'rating' => $profile->rating_average,
            ];
        })->toArray();

        return view('pages.dashboard_sitter.services', compact('services', 'sitter'));
    }

    /**
     * Update services (toggle or update)
     */
    public function updateServices(Request $request)
    {
        $sitter = Auth::user();
        $profile = $sitter->sitterProfile;

        $action = $request->input('action');

        if ($action === 'toggle') {
            $validated = $request->validate([
                'service_id' => 'required|integer|exists:services,id',
            ]);

            $service = Service::findOrFail($validated['service_id']);
            $offerField = $service->offer_field;

            $profile->update([
                $offerField => !$profile->{$offerField}
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service status updated successfully!',
                'is_enabled' => $profile->{$offerField}
            ]);

        } elseif ($action === 'update_service') {
            $validated = $request->validate([
                'service_id' => 'required|integer|exists:services,id',
                'description' => 'nullable|string|max:1000',
                'base_price' => 'required|numeric|min:0',
            ]);

            $service = Service::findOrFail($validated['service_id']);
            $priceField = $service->price_field;
            $descriptionField = $service->description_field;
            $offerField = $service->offer_field;

            $profile->update([
                $priceField => $validated['base_price'],
                $descriptionField => $validated['description'],
            ]);

            if ($validated['base_price'] > 0 && !$profile->{$offerField}) {
                $profile->update([
                    $offerField => true
                ]);
            }

            return redirect()->back()->with('success', 'Service updated successfully!');
        }

        return redirect()->back()->with('error', 'Invalid action');
    }

    /**
     * Requests list page
     */
    public function requests(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $sitter = Auth::user();
        
        $statusMap = [
            'accepted' => 'confirmed',
            'rejected' => 'cancelled',
        ];
        
        $query = Booking::where('sitter_id', $sitter->id)
                       ->with(['user', 'service', 'bookingCats.cat', 'address']);

        if ($filter !== 'all') {
            $dbStatus = $statusMap[$filter] ?? $filter;
            $query->where('status', $dbStatus);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        $counts = [
            'all' => Booking::where('sitter_id', $sitter->id)->count(),
            'pending' => Booking::where('sitter_id', $sitter->id)->where('status', 'pending')->count(),
            'accepted' => Booking::where('sitter_id', $sitter->id)->where('status', 'confirmed')->count(),
            'rejected' => Booking::where('sitter_id', $sitter->id)->where('status', 'cancelled')->count(),
            'completed' => Booking::where('sitter_id', $sitter->id)->where('status', 'completed')->count(),
        ];

        $transformedRequests = $requests->map(function($booking) {
            $statusDisplay = $booking->status;
            if ($booking->status === 'confirmed') {
                $statusDisplay = 'accepted';
            } elseif ($booking->status === 'cancelled') {
                $statusDisplay = 'rejected';
            }
            
            $completedBookings = Booking::where('user_id', $booking->user_id)
                                       ->where('status', 'completed')
                                       ->count();
            
            $userAddress = $booking->address ?? $booking->user->addresses->where('is_primary', true)->first();
            
            return [
                'id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'status' => $statusDisplay,
                'user' => [
                    'name' => $booking->user->name,
                    'avatar' => $booking->user->avatar_url,
                    'rating' => 5.0,
                    'total_bookings' => $completedBookings,
                ],
                'service' => [
                    'type' => $booking->service->name,
                ],
                'schedule' => [
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'duration_text' => $booking->duration . ' ' . ($booking->duration > 1 ? 'days' : 'day'),
                ],
                'location' => [
                    'city' => $userAddress?->city ?? 'Unknown',
                    'distance' => '5 km',
                ],
                'cats' => $booking->bookingCats->map(function($bookingCat) {
                    if ($bookingCat->cat_type === 'registered' && $bookingCat->cat) {
                        $cat = $bookingCat->cat;
                        return [
                            'name' => $cat->name,
                            'photo' => $cat->photo_url,
                            'breed' => $cat->breed ?? 'Mixed Breed',
                            'gender' => ucfirst($cat->gender ?? 'unknown'),
                            'age' => $this->calculateAge($cat->date_of_birth),
                            'weight' => $cat->weight ? $cat->weight . ' kg' : 'N/A',
                            'special_needs' => $cat->care_instructions ?? null,
                        ];
                    } else {
                        return [
                            'name' => $bookingCat->new_cat_name ?? 'Unknown',
                            'photo' => asset('images/default-cat.png'),
                            'breed' => $bookingCat->new_cat_breed ?? 'Mixed Breed',
                            'gender' => 'Unknown',
                            'age' => $bookingCat->new_cat_age ?? 'N/A',
                            'weight' => 'N/A',
                            'special_needs' => null,
                        ];
                    }
                }),
                'pricing' => [
                    'total_price' => $booking->total_price,
                    'platform_fee' => $booking->platform_fee,
                    'your_earning' => $booking->total_price - $booking->platform_fee,
                ],
                'notes' => $booking->special_notes,
                'rejection_reason' => $booking->cancellation_reason ?? null,
                'review' => null,
                'time_ago' => $booking->created_at->diffForHumans(),
            ];
        });

        return view('pages.dashboard_sitter.requests', [
            'requests' => $transformedRequests,
            'filter' => $filter,
            'counts' => $counts,
        ]);
    }

    /**
     * Show single request detail
     */
    public function show($id)
    {
        $sitter = Auth::user();
        
        $booking = Booking::where('sitter_id', $sitter->id)
                         ->where('id', $id)
                         ->with(['user.bookingsAsUser', 'service', 'bookingCats.cat', 'address', 'review'])
                         ->firstOrFail();

        $statusDisplay = $booking->status;
        if ($booking->status === 'confirmed') {
            $statusDisplay = 'accepted';
        } elseif ($booking->status === 'cancelled') {
            $statusDisplay = 'rejected';
        }

        $transformedRequest = [
            'id' => $booking->id,
            'booking_code' => $booking->booking_code,
            'status' => $statusDisplay,
            'user' => [
                'name' => $booking->user->name,
                'avatar' => $booking->user->photo ? asset('storage/' . $booking->user->photo) : asset('images/default-avatar.png'),
                'rating' => $booking->user->rating ?? 5.0,
                'total_bookings' => $booking->user->bookingsAsUser()->where('status', 'completed')->count(),
                'member_since' => $booking->user->created_at->format('M Y'),
                'phone' => $booking->user->phone ?? 'Not provided',
                'email' => $booking->user->email,
            ],
            'service' => [
                'type' => $booking->service->name,
                'description' => $booking->service->description ?? '',
                'add_ons' => [],
            ],
            'schedule' => [
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'duration_text' => $booking->duration . ' ' . ($booking->duration > 1 ? 'days' : 'day'),
                'duration_days' => $booking->duration,
            ],
            'location' => [
                'city' => $booking->address->city ?? $booking->user->city ?? 'Unknown',
                'full_address' => $booking->address ? $booking->address->full_address : 'Address not provided',
                'distance' => '5 km',
            ],
            'cats' => $booking->bookingCats->map(function($bookingCat) {
                if ($bookingCat->cat_type === 'registered' && $bookingCat->cat) {
                    $cat = $bookingCat->cat;
                    return [
                        'name' => $cat->name,
                        'photo' => $cat->photo ? asset('storage/' . $cat->photo) : asset('images/default-cat.png'),
                        'breed' => $cat->breed ?? 'Mixed Breed',
                        'gender' => ucfirst($cat->gender),
                        'age' => $cat->age . ' ' . ($cat->age > 1 ? 'years' : 'year'),
                        'weight' => $cat->weight . ' kg',
                        'color' => $cat->color ?? 'Not specified',
                        'vaccinated' => $cat->is_vaccinated ?? false,
                        'spayed' => $cat->is_neutered ?? false,
                        'temperament' => $cat->temperament ?? 'Friendly',
                        'medical_conditions' => $cat->medical_conditions,
                        'allergies' => $cat->allergies,
                        'special_needs' => $cat->special_needs,
                        'diet' => $cat->diet_preferences,
                        'behavior_notes' => $cat->behavior_notes,
                    ];
                } else {
                    return [
                        'name' => $bookingCat->new_cat_name ?? 'Unknown',
                        'photo' => asset('images/default-cat.png'),
                        'breed' => $bookingCat->new_cat_breed ?? 'Mixed Breed',
                        'gender' => 'Unknown',
                        'age' => $bookingCat->new_cat_age ?? 'N/A',
                        'weight' => 'N/A',
                        'color' => 'Not specified',
                        'vaccinated' => false,
                        'spayed' => false,
                        'temperament' => 'Unknown',
                        'medical_conditions' => null,
                        'allergies' => null,
                        'special_needs' => null,
                        'diet' => null,
                        'behavior_notes' => null,
                    ];
                }
            })->toArray(),
            'pricing' => [
                'base_price' => $booking->service_price ?? $booking->total_price,
                'subtotal' => $booking->subtotal ?? $booking->total_price,
                'platform_fee' => $booking->platform_fee,
                'your_earning' => $booking->total_price - $booking->platform_fee,
                'addons_total' => 0,
                'cat_multiplier' => count($booking->bookingCats),
            ],
            'notes' => $booking->special_notes,
            'rejection_reason' => $booking->cancel_reason ?? null,
            'review' => $booking->review ? [
                'rating' => $booking->review->rating,
                'comment' => $booking->review->comment,
                'created_at' => $booking->review->created_at->diffForHumans(),
                'photos' => [],
            ] : null,
            'created_at' => $booking->created_at,
            'accepted_at' => $booking->confirmed_at ?? null,
            'rejected_at' => $booking->cancelled_at ?? null,
            'completed_at' => $booking->completed_at ?? null,
        ];

        return view('pages.dashboard_sitter.detail-request', ['request' => $transformedRequest]);
    }

    /**
     * Accept booking request
     */
    public function acceptRequest($id)
    {
        $booking = Booking::where('sitter_id', Auth::id())
                         ->where('id', $id)
                         ->where('status', 'pending')
                         ->firstOrFail();

        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Request accepted successfully!');
    }

    /**
     * Reject booking request
     */
    public function rejectRequest(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $booking = Booking::where('sitter_id', Auth::id())
                         ->where('id', $id)
                         ->where('status', 'pending')
                         ->firstOrFail();

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => 'sitter',
            'cancel_reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Request rejected.');
    }

    /**
     * Calculate age from date of birth
     */
    private function calculateAge($dateOfBirth)
    {
        if (!$dateOfBirth) {
            return 'N/A';
        }

        try {
            $dob = Carbon::parse($dateOfBirth);
            $years = $dob->diffInYears(now());
            $months = $dob->diffInMonths(now()) % 12;

            if ($years > 0) {
                return $years . ' ' . ($years > 1 ? 'years' : 'year') . 
                       ($months > 0 ? ', ' . $months . ' ' . ($months > 1 ? 'months' : 'month') : '');
            } elseif ($months > 0) {
                return $months . ' ' . ($months > 1 ? 'months' : 'month');
            } else {
                $days = $dob->diffInDays(now());
                return $days . ' ' . ($days > 1 ? 'days' : 'day');
            }
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}
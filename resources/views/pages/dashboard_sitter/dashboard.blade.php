@extends('layout.main')
@section('title', 'Pet Sitter Dashboard - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/dashboard-sitter.css')}}">
@endsection

@section('content')
<!-- Dashboard Container -->
<div class="dashboard-container">
    
    <!-- Welcome Banner -->
    <div class="welcome-section">
        <div class="welcome-text">
            <h1>Welcome Back, {{ Auth::user()->name }}! 👋</h1>
            <p>Manage your pet sitting services with ease</p>
        </div>
        <div class="welcome-date">
            <i class="fas fa-calendar-alt"></i>
            <span id="current-date"></span>
        </div>
    </div>
<!-- Statistics Cards -->
<!-- Statistics Cards -->
<div class="stats-grid">
    <!-- 🆕 TODAY'S TRANSACTIONS -->
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-content">
            <h3>Today's Transactions</h3>
            <p class="stat-number" data-target="{{ $stats['today_transactions'] }}">0</p>
            <div class="stat-footer">
                <span class="stat-label">Paid bookings today</span>
            </div>
        </div>
    </div>

    <!-- 🆕 TODAY'S EARNINGS -->
    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-content">
            <h3>Today's Earnings</h3>
            <p class="stat-number-currency">Rp {{ number_format($stats['today_earnings'], 0, ',', '.') }}</p>
            <div class="stat-footer">
                <span class="stat-label">Net income today</span>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h3>Total Orders</h3>
            <p class="stat-number" data-target="{{ $stats['total_orders'] }}">0</p>
            <div class="stat-footer">
                <span class="stat-label">All time bookings</span>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-content">
            <h3>Pending Requests</h3>
            <p class="stat-number" data-target="{{ $stats['pending_requests'] }}">0</p>
            <div class="stat-footer">
                <span class="stat-badge pending">
                    <i class="fas fa-clock"></i> Awaiting response
                </span>
            </div>
        </div>
    </div>

    <!-- Completed Requests -->
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>Completed Requests</h3>
            <p class="stat-number" data-target="{{ $stats['completed_requests'] }}">0</p>
            <div class="stat-footer">
                <span class="stat-label">Successfully completed</span>
            </div>
        </div>
    </div>

    <!-- Average Rating -->
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-content">
            <h3>Average Rating</h3>
            <p class="stat-number">{{ $stats['average_rating'] }}</p>
            <div class="stat-footer">
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($stats['average_rating']))
                            <i class="fas fa-star"></i>
                        @elseif($i - 0.5 <= $stats['average_rating'])
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span class="review-count">({{ $stats['total_reviews'] }} reviews)</span>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- <!-- Chart & Quick Actions Grid -->
    <div class="chart-actions-grid">
        <!-- Earnings Chart -->
        <div class="chart-card fade-in">
            <div class="card-header">
                <h2><i class="fas fa-chart-line"></i> Earnings Trend</h2>
                <div class="chart-controls">
                    <select id="chart-period" class="chart-select">
                        <option value="6">Last 6 Months</option>
                        <option value="12">Last 12 Months</option>
                        <option value="3">Last 3 Months</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="earningsChart"></canvas>
            </div>
            <div class="chart-summary">
                <div class="summary-item">
                    <span class="summary-label">Total Earnings (6 Months)</span>
                    <span class="summary-value" id="total-earnings">Rp {{ number_format($chart_data['6']['total'], 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Monthly Average</span>
                    <span class="summary-value" id="avg-earnings">Rp {{ number_format($chart_data['6']['average'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-card fade-in">
            <div class="card-header">
                <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <button class="action-btn schedule">
                        <div class="action-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="action-text">
                            <h4>My Schedule</h4>
                            <p>View your bookings</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn services">
                        <div class="action-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="action-text">
                            <h4>Manage Services</h4>
                            <p>Edit your offerings</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn profile">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="action-text">
                            <h4>Update Profile</h4>
                            <p>Edit sitter details</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn earnings">
                        <div class="action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-text">
                            <h4>View Earnings</h4>
                            <p>Detailed reports</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <!-- Notifications & Recent Requests Grid -->
    <div class="notifications-requests-grid">
        <!-- Notifications -->
        <div class="notifications-card fade-in">
            <div class="card-header">
                <h2><i class="fas fa-bell"></i> Notifications & Alerts</h2>
                <button class="mark-read-btn" id="mark-all-read">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            </div>
            <div class="card-body">
                <div class="notification-list">
                    @foreach($notifications as $notification)
                    <div class="notification-item {{ $notification['is_new'] ? 'new' : '' }} {{ $notification['is_urgent'] ? 'urgent' : '' }}">
                        <div class="notif-icon {{ $notification['type'] }}">
                            @if($notification['type'] == 'request')
                                <i class="fas fa-inbox"></i>
                            @elseif($notification['type'] == 'booking')
                                <i class="fas fa-calendar-check"></i>
                            @elseif($notification['type'] == 'review')
                                <i class="fas fa-star"></i>
                            @endif
                        </div>
                        <div class="notif-content">
                            <h4>{{ $notification['title'] }}</h4>
                            <p>{{ $notification['message'] }}</p>
                            <span class="notif-time"><i class="far fa-clock"></i> {{ $notification['time'] }}</span>
                        </div>
                        <button class="notif-action">View</button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="recent-requests-card fade-in">
            <div class="card-header">
                <h2><i class="fas fa-clipboard-check"></i> Recent Requests</h2>
                <a {{ route('pet-sitter.requests.index', ['filter' => 'pending']) }}" class="view-all-link" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="request-list">
                    @foreach($recent_requests as $request)
                    <div class="request-item {{ $request['status'] }}">
                        <div class="request-header">
                            <img src="{{ $request['user_avatar'] }}" alt="{{ $request['user_name'] }}">
                            <div class="request-user-info">
                                <h4>{{ $request['user_name'] }}</h4>
                                <span class="request-status {{ $request['status'] }}">
                                    @if($request['status'] == 'pending')
                                        <i class="fas fa-clock"></i> Pending
                                    @else
                                        <i class="fas fa-check-circle"></i> Accepted
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>{{ $request['service'] }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $request['dates'] }} ({{ $request['duration'] }})</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-cat"></i>
                                <span>{{ $request['cats'] }}</span>
                            </div>
                        </div>
                        
                        @if($request['status'] == 'pending')
                        <div class="request-actions">
                            <form action="{{ route('pet-sitter.requests.accept', $request['id']) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-accept">
                                    <i class="fas fa-check"></i> Accept
                                </button>
                            </form>
                            <form action="{{ route('pet-sitter.requests.reject', $request['id']) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-reject">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="request-footer">
                            <span class="accepted-text">
                                <i class="fas fa-check-circle"></i> You accepted this request
                            </span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Transaction History Table -->
    <div class="transaction-history-card fade-in">
        <div class="card-header">
            <h2><i class="fas fa-receipt"></i> Transaction History</h2>
            <a href="{{ route('pet-sitter.requests.index', ['filter' => 'all']) }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>Booking Code</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Cat(s)</th>
                            <th>Schedule</th>
                            <th>Duration</th>
                            <th>Total Price</th>
                            <th>Platform Fee</th>
                            <th>Your Earning</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaction_history as $transaction)
                        <tr>
                            <td>
                                <span class="booking-code">{{ $transaction['booking_code'] }}</span>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <img src="{{ $transaction['user_avatar'] }}" alt="{{ $transaction['user_name'] }}" class="customer-avatar">
                                    <span>{{ $transaction['user_name'] }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="service-name">{{ $transaction['service'] }}</span>
                            </td>
                            <td>
                                <div class="cat-info-cell">
                                    <span class="cat-name">{{ $transaction['cat_name'] }}</span>
                                    @if($transaction['total_cats'] > 1)
                                    <span class="cat-count">+{{ $transaction['total_cats'] - 1 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="schedule">{{ $transaction['start_date'] }} - {{ $transaction['end_date'] }}</span>
                            </td>
                            <td>
                                <span class="duration">{{ $transaction['duration'] }}</span>
                            </td>
                            <td>
                                <span class="price total">Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="price fee">Rp {{ number_format($transaction['platform_fee'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="price earning">Rp {{ number_format($transaction['net_earning'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="payment-method">
                                    @if($transaction['payment_method'] === 'bank_transfer')
                                        <i class="fas fa-university"></i> Bank
                                    @elseif(in_array($transaction['payment_method'], ['gopay', 'ovo', 'dana']))
                                        <i class="fas fa-wallet"></i> E-Wallet
                                    @elseif($transaction['payment_method'] === 'credit_card')
                                        <i class="fas fa-credit-card"></i> Card
                                    @else
                                        <i class="fas fa-money-bill"></i> {{ ucfirst(str_replace('_', ' ', $transaction['payment_method'])) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $transaction['status'] }}">
                                    @if($transaction['status'] === 'pending')
                                        <i class="fas fa-clock"></i> Pending
                                    @elseif($transaction['status'] === 'confirmed')
                                        <i class="fas fa-check-circle"></i> Confirmed
                                    @elseif($transaction['status'] === 'completed')
                                        <i class="fas fa-check-double"></i> Completed
                                    @else
                                        <i class="fas fa-times-circle"></i> {{ ucfirst($transaction['status']) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="date">{{ $transaction['date'] }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No transactions yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        <!-- Upcoming Bookings -->
    <div class="upcoming-bookings-card fade-in">
        <div class="card-header">
            <h2><i class="fas fa-calendar-week"></i> Upcoming Bookings</h2>
            <a href="#" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body">
            <div class="booking-timeline">
                @foreach($upcoming_bookings as $booking)
                <div class="booking-item">
                    <div class="booking-date">
                        <div class="date-box">
                            <span class="day">{{ $booking['day'] }}</span>
                            <span class="month">{{ $booking['month'] }}</span>
                        </div>
                    </div>
                    <div class="booking-info">
                        <h4>{{ $booking['user_name'] }} - {{ $booking['service'] }}</h4>
                        <div class="booking-meta">
                            <span><i class="fas fa-clock"></i> {{ $booking['time'] }}</span>
                            <span><i class="fas fa-cat"></i> {{ $booking['cats'] }}</span>
                            <span><i class="fas fa-map-marker-alt"></i> {{ $booking['location'] }}</span>
                        </div>
                    </div>
                    <div class="booking-status {{ $booking['status'] }}">
                        @if($booking['status'] == 'tomorrow')
                            <i class="fas fa-exclamation-circle"></i>
                        @else
                            <i class="fas fa-calendar-day"></i>
                        @endif
                        {{ $booking['status_text'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


</div>

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js/sitter/dashboard-sitter.js')}}"></script>
@endsection
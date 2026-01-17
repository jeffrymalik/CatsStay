@extends('layout.main')
@section('title', 'Booking Requests - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/requests.css')}}">
@endsection

@section('content')
<div class="requests-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-clipboard-list"></i> Booking Requests</h1>
            <p>Manage all your booking requests from cat owners</p>
        </div>
    </div>

    <!-- Success/Error Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="close-alert" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button class="close-alert" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="{{ route('pet-sitter.requests.index', ['filter' => 'all']) }}" 
           class="tab {{ $filter === 'all' ? 'active' : '' }}">
            All Requests
            <span class="count">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('pet-sitter.requests.index', ['filter' => 'pending']) }}" 
           class="tab {{ $filter === 'pending' ? 'active' : '' }}">
            Pending
            <span class="count pending">{{ $counts['pending'] }}</span>
        </a>
        <a href="{{ route('pet-sitter.requests.index', ['filter' => 'accepted']) }}" 
           class="tab {{ $filter === 'accepted' ? 'active' : '' }}">
            Accepted
            <span class="count accepted">{{ $counts['accepted'] }}</span>
        </a>
        <a href="{{ route('pet-sitter.requests.index', ['filter' => 'rejected']) }}" 
           class="tab {{ $filter === 'rejected' ? 'active' : '' }}">
            Rejected
            <span class="count rejected">{{ $counts['rejected'] }}</span>
        </a>
        <a href="{{ route('pet-sitter.requests.index', ['filter' => 'completed']) }}" 
           class="tab {{ $filter === 'completed' ? 'active' : '' }}">
            Completed
            <span class="count completed">{{ $counts['completed'] }}</span>
        </a>
    </div>

    <!-- Search & Sort Bar -->
    <div class="search-bar">
        <div class="search-input-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search by name, booking code, or service...">
        </div>
        <div class="sort-wrapper">
            <label><i class="fas fa-sort"></i> Sort by:</label>
            <select id="sortSelect">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="price-high">Price: High to Low</option>
                <option value="price-low">Price: Low to High</option>
            </select>
        </div>
    </div>

    <!-- Requests List -->
    <div class="requests-list" id="requestsList">
        @forelse($requests as $request)
        <div class="request-card {{ $request['status'] }}" data-request-id="{{ $request['id'] }}">
            
            <!-- Card Header -->
            <div class="card-header">
                <div class="user-info">
                    <img src="{{ $request['user']['avatar'] }}" alt="{{ $request['user']['name'] }}" class="user-avatar">
                    <div class="user-details">
                        <h3>{{ $request['user']['name'] }}</h3>
                        <div class="user-meta">
                            <span class="rating">
                                <i class="fas fa-star"></i> {{ number_format($request['user']['rating'], 1) }}
                            </span>
                            <span class="bookings">
                                <i class="fas fa-history"></i> {{ $request['user']['total_bookings'] }} bookings
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-status">
                    <span class="status-badge {{ $request['status'] }}">
                        @if($request['status'] === 'pending')
                            <i class="fas fa-clock"></i> Pending
                        @elseif($request['status'] === 'accepted')
                            <i class="fas fa-check-circle"></i> Accepted
                        @elseif($request['status'] === 'rejected')
                            <i class="fas fa-times-circle"></i> Rejected
                        @elseif($request['status'] === 'completed')
                            <i class="fas fa-check-double"></i> Completed
                        @endif
                    </span>
                    <span class="booking-code">{{ $request['booking_code'] }}</span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                
                <!-- Service & Schedule Info -->
                <div class="info-section">
                    <div class="info-row">
                        <div class="info-item">
                            <i class="fas fa-concierge-bell"></i>
                            <div>
                                <span class="label">Service</span>
                                <span class="value">{{ $request['service']['type'] }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <span class="label">Schedule</span>
                                <span class="value">
                                    {{ \Carbon\Carbon::parse($request['schedule']['start_date'])->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($request['schedule']['end_date'])->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <span class="label">Duration</span>
                                <span class="value">{{ $request['schedule']['duration_text'] }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="label">Location</span>
                                <span class="value">{{ $request['location']['city'] }} ({{ $request['location']['distance'] }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cats Info -->
                <div class="cats-section">
                    <h4><i class="fas fa-cat"></i> Cat Information ({{ count($request['cats']) }})</h4>
                    <div class="cats-grid">
                        @foreach($request['cats'] as $cat)
                        <div class="cat-card">
                            <img src="{{ $cat['photo'] }}" alt="{{ $cat['name'] }}" class="cat-photo">
                            <div class="cat-details">
                                <h5>{{ $cat['name'] }}</h5>
                                <p class="cat-breed">{{ $cat['breed'] }}</p>
                                <div class="cat-meta">
                                    <span><i class="fas fa-venus-mars"></i> {{ $cat['gender'] }}</span>
                                    <span><i class="fas fa-birthday-cake"></i> {{ $cat['age'] }}</span>
                                    <span><i class="fas fa-weight"></i> {{ $cat['weight'] }}</span>
                                </div>
                                @if($cat['special_needs'])
                                <p class="special-needs">
                                    <i class="fas fa-info-circle"></i> {{ $cat['special_needs'] }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pricing Info -->
                <div class="pricing-section">
                    <div class="pricing-row">
                        <span class="pricing-label">Total Price:</span>
                        <span class="pricing-value">Rp {{ number_format($request['pricing']['total_price'], 0, ',', '.') }}</span>
                    </div>
                    <div class="pricing-row">
                        <span class="pricing-label">Platform Fee:</span>
                        <span class="pricing-value text-red">- Rp {{ number_format($request['pricing']['platform_fee'], 0, ',', '.') }}</span>
                    </div>
                    <div class="pricing-row total">
                        <span class="pricing-label">Your Earning:</span>
                        <span class="pricing-value">Rp {{ number_format($request['pricing']['your_earning'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Notes -->
                @if($request['notes'])
                <div class="notes-section">
                    <h4><i class="fas fa-sticky-note"></i> Special Notes</h4>
                    <p>{{ $request['notes'] }}</p>
                </div>
                @endif

                <!-- Rejection Reason (if rejected) -->
                @if($request['status'] === 'rejected' && $request['rejection_reason'])
                <div class="rejection-section">
                    <h4><i class="fas fa-exclamation-triangle"></i> Rejection Reason</h4>
                    <p>{{ $request['rejection_reason'] }}</p>
                </div>
                @endif

                <!-- Review (if completed) -->
                @if($request['status'] === 'completed' && $request['review'])
                <div class="review-section">
                    <h4><i class="fas fa-star"></i> Client Review</h4>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $request['review']['rating'] ? 'filled' : '' }}"></i>
                        @endfor
                        <span class="rating-text">{{ $request['review']['rating'] }}/5</span>
                    </div>
                    <p class="review-comment">{{ $request['review']['comment'] }}</p>
                </div>
                @endif

            </div>

            <!-- Card Footer / Actions -->
            <div class="card-footer">
                <span class="time-ago">
                    <i class="far fa-clock"></i> {{ $request['time_ago'] }}
                </span>
                
                <div class="card-actions">
                    <button class="btn-view" onclick="window.location.href='{{ route('pet-sitter.requests.show', $request['id']) }}'">
                        <i class="fas fa-eye"></i> View Details
                    </button>
                    
                    @if($request['status'] === 'pending')
                    <form action="{{ route('pet-sitter.requests.accept', $request['id']) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-accept" onclick="return confirm('Accept this booking request?')">
                            <i class="fas fa-check"></i> Accept
                        </button>
                    </form>
                    <button class="btn-reject" onclick="showRejectModal({{ $request['id'] }})">
                        <i class="fas fa-times"></i> Reject
                    </button>
                    @elseif($request['status'] === 'accepted')
                    <a href="#" class="btn-contact">
                        <i class="fas fa-comment"></i> Contact Owner
                    </a>
                    @endif
                </div>
            </div>

        </div>
        @empty
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No Requests Found</h3>
            <p>
                @if($filter === 'pending')
                    You don't have any pending requests at the moment.
                @elseif($filter === 'accepted')
                    You haven't accepted any requests yet.
                @elseif($filter === 'rejected')
                    You haven't rejected any requests.
                @elseif($filter === 'completed')
                    You don't have any completed bookings yet.
                @else
                    No booking requests available.
                @endif
            </p>
        </div>
        @endforelse
    </div>

</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-times-circle"></i> Reject Booking Request</h3>
            <button class="close-modal" onclick="closeRejectModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <p>Please provide a reason for rejecting this booking request:</p>
                <textarea name="reason" id="rejectReason" rows="4" placeholder="e.g., Schedule conflict, too far from my location, etc." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-submit-reject">
                    <i class="fas fa-times"></i> Reject Request
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/sitter/requests.js')}}"></script>
@endsection
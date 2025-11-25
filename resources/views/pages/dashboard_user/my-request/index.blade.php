@extends('layout.main')

@section('title', 'My Request - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my-request.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="my-request-container">
    <div class="my-request-wrapper">
        
        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-clipboard-list"></i>
                    My Request
                </h1>
                <p class="page-subtitle">Track and manage all your booking requests</p>
            </div>
        </div>

        {{-- Status Filters --}}
        <div class="status-filters">
                <a href="/my-request?status=all" class="filter-tab {{ $statusFilter === 'all' ? 'active' : '' }}">
                    <span class="filter-label">All Bookings</span>
                    <span class="filter-count">{{ $statusCounts['all'] }}</span>
                </a>
                <a href="/my-request?status=pending" class="filter-tab {{ $statusFilter === 'pending' ? 'active' : '' }}">
                    <span class="filter-label">Pending</span>
                    <span class="filter-count">{{ $statusCounts['pending'] }}</span>
                </a>
                <a href="/my-request?status=confirmed" class="filter-tab {{ $statusFilter === 'confirmed' ? 'active' : '' }}">
                    <span class="filter-label">Confirmed</span>
                    <span class="filter-count">{{ $statusCounts['confirmed'] }}</span>
                </a>
                <a href="/my-request?status=in_progress" class="filter-tab {{ $statusFilter === 'in_progress' ? 'active' : '' }}">
                    <span class="filter-label">In Progress</span>
                    <span class="filter-count">{{ $statusCounts['in_progress'] }}</span>
                </a>
                <a href="/my-request?status=completed" class="filter-tab {{ $statusFilter === 'completed' ? 'active' : '' }}">
                    <span class="filter-label">Completed</span>
                    <span class="filter-count">{{ $statusCounts['completed'] }}</span>
                </a>
                <a href="/my-request?status=cancelled" class="filter-tab {{ $statusFilter === 'cancelled' ? 'active' : '' }}">
                    <span class="filter-label">Cancelled</span>
                    <span class="filter-count">{{ $statusCounts['cancelled'] }}</span>
                </a>
            </div>

            <!-- Bookings Grid -->
            @if(count($bookings) > 0)
                <div class="bookings-grid">
                    @foreach($bookings as $booking)
                        <div class="booking-card">
                            <!-- Status Badge -->
                            <div class="booking-status-badge status-{{ $booking['status'] }}">
                                @if($booking['status'] === 'pending')
                                    <i class="fas fa-clock"></i>
                                    <span>Pending</span>
                                @elseif($booking['status'] === 'confirmed')
                                    <i class="fas fa-check-circle"></i>
                                    <span>Confirmed</span>
                                @elseif($booking['status'] === 'in_progress')
                                    <i class="fas fa-spinner"></i>
                                    <span>In Progress</span>
                                @elseif($booking['status'] === 'completed')
                                    <i class="fas fa-check-double"></i>
                                    <span>Completed</span>
                                @elseif($booking['status'] === 'cancelled')
                                    <i class="fas fa-times-circle"></i>
                                    <span>Cancelled</span>
                                @endif
                            </div>

                            <!-- Booking Header -->
                            <div class="booking-header">
                                <div class="sitter-info">
                                    <img src="{{ $booking['sitter']['photo'] }}" alt="{{ $booking['sitter']['name'] }}" class="sitter-photo">
                                    <div class="sitter-details">
                                        <h3 class="sitter-name">{{ $booking['sitter']['name'] }}</h3>
                                        <div class="sitter-meta">
                                            <span class="rating">
                                                <i class="fas fa-star"></i>
                                                {{ $booking['sitter']['rating'] }}
                                            </span>
                                            <span class="separator">•</span>
                                            <span class="location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $booking['sitter']['location'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-code">
                                    <span>{{ $booking['booking_code'] }}</span>
                                </div>
                            </div>

                            <!-- Booking Details -->
                            <div class="booking-body">
                                <!-- Service & Cat -->
                                <div class="booking-info-row">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas {{ $booking['service_icon'] }}"></i>
                                            Service
                                        </div>
                                        <div class="info-value">{{ $booking['service'] }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-paw"></i>
                                            Cat
                                        </div>
                                        <div class="info-value">{{ $booking['cat_name'] }}</div>
                                    </div>
                                </div>

                                <!-- Date & Duration -->
                                <div class="booking-info-row">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar"></i>
                                            Date
                                        </div>
                                        <div class="info-value">
                                            {{ date('d M Y', strtotime($booking['start_date'])) }}
                                            @if($booking['start_date'] !== $booking['end_date'])
                                                - {{ date('d M Y', strtotime($booking['end_date'])) }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-clock"></i>
                                            Duration
                                        </div>
                                        <div class="info-value">{{ $booking['duration'] }} {{ $booking['duration'] > 1 ? 'days' : 'day' }}</div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="booking-price">
                                    <span class="price-label">Total Price</span>
                                    <span class="price-value">Rp {{ number_format($booking['total_price'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Booking Actions -->
                            <div class="booking-actions">
                                <a href="/my-request/{{ $booking['id'] }}" class="btn-action btn-primary">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>

                                @if($booking['status'] === 'pending' || $booking['status'] === 'confirmed')
                                    <button class="btn-action btn-secondary" onclick="cancelBooking({{ $booking['id'] }})">
                                        <i class="fas fa-times"></i>
                                        Cancel
                                    </button>
                                @endif

                                @if($booking['status'] === 'confirmed' || $booking['status'] === 'in_progress')
                                    <a href="/messages/{{ $booking['sitter']['id'] }}" class="btn-action btn-secondary">
                                        <i class="fas fa-comment"></i>
                                        Chat
                                    </a>
                                @endif

                                @if($booking['status'] === 'completed' && !($booking['review_given'] ?? false))
                                    <a href="/reviews/create?booking={{ $booking['id'] }}" class="btn-action btn-review">
                                        <i class="fas fa-star"></i>
                                        Leave Review
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="empty-title">No bookings found</h3>
                    <p class="empty-message">
                        @if($statusFilter === 'all')
                            You haven't made any booking requests yet.
                        @else
                            No {{ $statusFilter }} bookings at the moment.
                        @endif
                    </p>
                    <a href="/select-service" class="btn-primary">
                        <i class="fas fa-search"></i>
                        Find a Sitter
                    </a>
                </div>
            @endif
        </div>

        {{-- Back to Dashboard --}}
        <div class="back-button-wrapper">
            <a href="{{ route('user.dashboard') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
            </a>
        </div>

    </div>
</div>

{{-- Cancel Booking Modal --}}
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Cancel Booking</h3>
                <button class="modal-close" onclick="closeCancelModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this booking?</p>
                <div class="cancel-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Cancellation policy applies. Please review terms before proceeding.</span>
                </div>
                <div class="form-group">
                    <label for="cancelReason">Reason for cancellation</label>
                    <textarea id="cancelReason" rows="4" placeholder="Please tell us why you're cancelling..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeCancelModal()">
                    Keep Booking
                </button>
                <button class="btn-danger" onclick="confirmCancel()">
                    <i class="fas fa-times-circle"></i>
                    Cancel Booking
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/my-request.js') }}"></script>
@endsection
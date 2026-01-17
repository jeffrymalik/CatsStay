@extends('layout.main')

@section('title', 'Booking Details - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my-request.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="my-request-container">
    <div class="my-request-wrapper">
        
        {{-- Back Button --}}
        <div class="back-button-container">
            <a href="{{ route('my-request.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Back to My Request</span>
            </a>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Booking Detail Container -->
        <div class="detail-container">
            <!-- Left Column: Booking Info -->
            <div class="detail-main">
                <!-- Status Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Booking Status</h2>
                        <div class="booking-status-badge-large status-{{ $booking['status'] }}">
                            @if($booking['status'] === 'pending')
                                <i class="fas fa-clock"></i>
                                <span>Pending Confirmation</span>
                            @elseif($booking['status'] === 'confirmed')
                                <i class="fas fa-check-circle"></i>
                                <span>Confirmed</span>
                            @elseif($booking['status'] === 'in_progress')
                                <i class="fas fa-spinner"></i>
                                <span>Service In Progress</span>
                            @elseif($booking['status'] === 'completed')
                                <i class="fas fa-check-double"></i>
                                <span>Completed</span>
                            @elseif($booking['status'] === 'cancelled')
                                <i class="fas fa-times-circle"></i>
                                <span>Cancelled</span>
                            @endif
                        </div>
                    </div>
                    <div class="detail-card-body">
                        <div class="booking-code-large">
                            <span class="booking-code-label">Booking Code</span>
                            <span class="booking-code-value">{{ $booking['booking_code'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Sitter Info Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Pet Sitter Information</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="sitter-detail-info">
                            <img src="{{ $booking['sitter']['photo'] }}" alt="{{ $booking['sitter']['name'] }}" class="sitter-detail-photo">
                            <div class="sitter-detail-content">
                                <h3 class="sitter-detail-name">{{ $booking['sitter']['name'] }}</h3>
                                <div class="sitter-detail-meta">
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        {{ $booking['sitter']['rating'] }} ({{ $booking['sitter']['total_reviews'] }} reviews)
                                    </span>
                                </div>
                                <div class="sitter-detail-info-row">
                                    <div class="info-item-small">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $booking['sitter']['location'] }}</span>
                                    </div>
                                    <div class="info-item-small">
                                        <i class="fas fa-phone"></i>
                                        <span>{{ $booking['sitter']['phone'] }}</span>
                                    </div>
                                </div>
                                <div class="sitter-actions">
                                    <a href="/sitter/{{ $booking['sitter']['id'] }}" class="btn-secondary-small">
                                        <i class="fas fa-user"></i>
                                        View Profile
                                    </a>
                                    @if($booking['status'] === 'confirmed' || $booking['status'] === 'in_progress')
                                        <a href="/messages/{{ $booking['sitter']['id'] }}" class="btn-primary-small">
                                            <i class="fas fa-comment"></i>
                                            Chat Sitter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Details Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Service Details</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="detail-info-grid">
                            <div class="detail-info-item">
                                <div class="detail-info-label">
                                    <i class="fas {{ $booking['service_icon'] }}"></i>
                                    Service Type
                                </div>
                                <div class="detail-info-value">{{ $booking['service'] }}</div>
                            </div>
                            <div class="detail-info-item">
                                <div class="detail-info-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Start Date
                                </div>
                                <div class="detail-info-value">{{ date('d F Y', strtotime($booking['start_date'])) }}</div>
                            </div>
                            <div class="detail-info-item">
                                <div class="detail-info-label">
                                    <i class="fas fa-calendar-check"></i>
                                    End Date
                                </div>
                                <div class="detail-info-value">{{ date('d F Y', strtotime($booking['end_date'])) }}</div>
                            </div>
                            <div class="detail-info-item">
                                <div class="detail-info-label">
                                    <i class="fas fa-clock"></i>
                                    Duration
                                </div>
                                <div class="detail-info-value">{{ $booking['duration'] }} {{ $booking['duration'] > 1 ? 'days' : 'day' }}</div>
                            </div>
                        </div>

                        @if($booking['special_notes'])
                            <div class="special-notes">
                                <div class="special-notes-label">
                                    <i class="fas fa-sticky-note"></i>
                                    Special Notes
                                </div>
                                <div class="special-notes-content">
                                    {{ $booking['special_notes'] }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cat Information Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Cat Information</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="cat-detail-info">
                            <img src="{{ $booking['cat_photo'] }}" alt="{{ $booking['cat_name'] }}" class="cat-detail-photo">
                            <div class="cat-detail-content">
                                <h3 class="cat-detail-name">{{ $booking['cat_name'] }}</h3>
                                <div class="cat-detail-meta">
                                    <span class="cat-meta-item">
                                        <i class="fas fa-paw"></i>
                                        {{ $booking['cat_breed'] }}
                                    </span>
                                    <span class="separator">•</span>
                                    <span class="cat-meta-item">
                                        <i class="fas fa-birthday-cake"></i>
                                        {{ $booking['cat_age'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Price Summary & Actions -->
            <div class="detail-sidebar">
                <!-- Price Summary Card -->
                <div class="detail-card sticky-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Price Summary</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="price-breakdown">
                            <div class="price-row">
                                <span class="price-label">Service Price</span>
                                <span class="price-value">Rp {{ number_format($booking['price'], 0, ',', '.') }}</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Platform Fee (5%)</span>
                                <span class="price-value">Rp {{ number_format($booking['platform_fee'], 0, ',', '.') }}</span>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-row price-total">
                                <span class="price-label">Total</span>
                                <span class="price-value">Rp {{ number_format($booking['total_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="payment-status">
                            <span class="payment-status-label">Payment Status:</span>
                            <span class="payment-status-badge {{ $booking['payment_status'] }}">
                                @if($booking['payment_status'] === 'paid' || $booking['payment_status'] === 'confirmed')
                                    <i class="fas fa-check-circle"></i> Paid
                                @else
                                    <i class="fas fa-clock"></i> Pending
                                @endif
                            </span>
                        </div>

                        @if($booking['payment_status'] === 'pending' && $booking['status'] === 'confirmed')
                            <a href="{{ route('my-request.payment', $booking['id']) }}" class="btn-primary btn-full">
                                <i class="fas fa-credit-card"></i>
                                Pay Now
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Actions</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="action-buttons">
                            @if($booking['status'] === 'pending' || $booking['status'] === 'confirmed')
                                <button class="btn-danger btn-full" onclick="cancelBooking({{ $booking['id'] }})">
                                    <i class="fas fa-times-circle"></i>
                                    Cancel Booking
                                </button>
                            @endif

                            @if($booking['status'] === 'completed' && !($booking['review_given'] ?? false))
                                <a href="/reviews/create?booking={{ $booking['id'] }}" class="btn-review btn-full">
                                    <i class="fas fa-star"></i>
                                    Leave Review
                                </a>
                            @endif

                            <button class="btn-secondary btn-full" onclick="window.print()">
                                <i class="fas fa-print"></i>
                                Print Details
                            </button>

                            <a href="/support?booking={{ $booking['booking_code'] }}" class="btn-secondary btn-full">
                                <i class="fas fa-question-circle"></i>
                                Need Help?
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Booking Timeline</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Booking Created</div>
                                    <div class="timeline-date">{{ date('d M Y, H:i', strtotime($booking['created_at'])) }}</div>
                                </div>
                            </div>

                            @if(isset($booking['confirmed_at']))
                                <div class="timeline-item active">
                                    <div class="timeline-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Confirmed by Sitter</div>
                                        <div class="timeline-date">{{ date('d M Y, H:i', strtotime($booking['confirmed_at'])) }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($booking['status'] === 'pending')
                                <div class="timeline-item pending">
                                    <div class="timeline-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Waiting Confirmation</div>
                                        <div class="timeline-date">Pending</div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($booking['completed_at']))
                                <div class="timeline-item active">
                                    <div class="timeline-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Service Completed</div>
                                        <div class="timeline-date">{{ date('d M Y, H:i', strtotime($booking['completed_at'])) }}</div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($booking['cancelled_at']))
                                <div class="timeline-item cancelled">
                                    <div class="timeline-icon">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Booking Cancelled</div>
                                        <div class="timeline-date">{{ date('d M Y, H:i', strtotime($booking['cancelled_at'])) }}</div>
                                        @if(isset($booking['cancel_reason']))
                                            <div class="timeline-note">Reason: {{ $booking['cancel_reason'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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

@endsection

@section('js')
<script src="{{ asset('js/my-request.js') }}"></script>
<style>
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .alert-success {
        background: #d4edda;
        border: 2px solid #c3e6cb;
        color: #155724;
    }
    .alert-danger {
        background: #f8d7da;
        border: 2px solid #f5c6cb;
        color: #721c24;
    }
    .alert i {
        font-size: 1.2rem;
    }
</style>
@endsection
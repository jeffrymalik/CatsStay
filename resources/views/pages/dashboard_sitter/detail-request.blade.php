@extends('layout.main')
@section('title', 'Request Details - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/request-detail.css')}}">
@endsection

@section('content')
<div class="detail-container">
    
    <!-- Header with Back Button -->
    <div class="detail-header">
        <a href="{{ route('pet-sitter.requests.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Requests
        </a>
        <div class="header-info">
            <h1>Booking Request Details</h1>
            <span class="booking-code">{{ $request['booking_code'] }}</span>
        </div>
        <div class="status-badge-large {{ $request['status'] }}">
            @if($request['status'] === 'pending')
                <i class="fas fa-clock"></i> Pending Review
            @elseif($request['status'] === 'accepted')
                <i class="fas fa-check-circle"></i> Accepted
            @elseif($request['status'] === 'rejected')
                <i class="fas fa-times-circle"></i> Rejected
            @elseif($request['status'] === 'completed')
                <i class="fas fa-check-double"></i> Completed
            @endif
        </div>
    </div>

    <div class="detail-content">
        
        <!-- Left Column -->
        <div class="detail-left">
            
            <!-- Owner Information Card -->
            <div class="info-card owner-card">
                <div class="card-header">
                    <h2><i class="fas fa-user"></i> Cat Owner Information</h2>
                </div>
                <div class="card-body">
                    <div class="owner-profile">
                        <img src="{{ $request['user']['avatar'] }}" alt="{{ $request['user']['name'] }}" class="owner-avatar">
                        <div class="owner-details">
                            <h3>{{ $request['user']['name'] }}</h3>
                            <div class="owner-meta">
                                <div class="meta-item">
                                    <i class="fas fa-star"></i>
                                    <span>{{ $request['user']['rating'] }} Rating</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-history"></i>
                                    <span>{{ $request['user']['total_bookings'] }} Bookings</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Member since {{ $request['user']['member_since'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="owner-contact">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span class="label">Phone Number</span>
                                <span class="value">{{ $request['user']['phone'] }}</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="label">Email Address</span>
                                <span class="value">{{ $request['user']['email'] }}</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="label">Location</span>
                                <span class="value">{{ $request['location']['full_address'] }}</span>
                            </div>
                        </div>
                    </div>

                    @if($request['status'] === 'accepted' || $request['status'] === 'completed')
                    <div class="contact-actions">
                        <a href="tel:{{ $request['user']['phone'] }}" class="btn-contact-action phone">
                            <i class="fas fa-phone"></i> Call Owner
                        </a>
                        <a href="mailto:{{ $request['user']['email'] }}" class="btn-contact-action email">
                            <i class="fas fa-envelope"></i> Send Email
                        </a>
                        <button class="btn-contact-action message">
                            <i class="fas fa-comment"></i> Send Message
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Cat Information Card -->
            <div class="info-card cats-card">
                <div class="card-header">
                    <h2><i class="fas fa-cat"></i> Cat Information ({{ count($request['cats']) }})</h2>
                </div>
                <div class="card-body">
                    @foreach($request['cats'] as $index => $cat)
                    <div class="cat-detail-card {{ $index > 0 ? 'mt-20' : '' }}">
                        <div class="cat-header">
                            <img src="{{ $cat['photo'] }}" alt="{{ $cat['name'] }}" class="cat-photo-large">
                            <div class="cat-basic-info">
                                <h3>{{ $cat['name'] }}</h3>
                                <p class="cat-breed">{{ $cat['breed'] }}</p>
                                <div class="cat-quick-stats">
                                    <span><i class="fas fa-venus-mars"></i> {{ $cat['gender'] }}</span>
                                    <span><i class="fas fa-birthday-cake"></i> {{ $cat['age'] }}</span>
                                    <span><i class="fas fa-weight"></i> {{ $cat['weight'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="cat-info-grid">
                            <div class="info-item">
                                <span class="label">Color</span>
                                <span class="value">{{ $cat['color'] }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Vaccinated</span>
                                <span class="value {{ $cat['vaccinated'] ? 'text-green' : 'text-red' }}">
                                    <i class="fas fa-{{ $cat['vaccinated'] ? 'check-circle' : 'times-circle' }}"></i>
                                    {{ $cat['vaccinated'] ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="label">Spayed/Neutered</span>
                                <span class="value">{{ $cat['spayed'] ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Temperament</span>
                                <span class="value">{{ $cat['temperament'] }}</span>
                            </div>
                        </div>

                        @if($cat['medical_conditions'])
                        <div class="cat-medical">
                            <h4><i class="fas fa-heartbeat"></i> Medical Conditions</h4>
                            <p>{{ $cat['medical_conditions'] }}</p>
                        </div>
                        @endif

                        @if($cat['allergies'])
                        <div class="cat-allergies">
                            <h4><i class="fas fa-exclamation-triangle"></i> Allergies</h4>
                            <p>{{ $cat['allergies'] }}</p>
                        </div>
                        @endif

                        @if($cat['special_needs'])
                        <div class="cat-special-needs">
                            <h4><i class="fas fa-info-circle"></i> Special Care Instructions</h4>
                            <p>{{ $cat['special_needs'] }}</p>
                        </div>
                        @endif

                        @if($cat['diet'])
                        <div class="cat-diet">
                            <h4><i class="fas fa-utensils"></i> Diet & Feeding</h4>
                            <p>{{ $cat['diet'] }}</p>
                        </div>
                        @endif

                        @if($cat['behavior_notes'])
                        <div class="cat-behavior">
                            <h4><i class="fas fa-paw"></i> Behavior Notes</h4>
                            <p>{{ $cat['behavior_notes'] }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="detail-right">
            
            <!-- Service Details Card -->
            <div class="info-card service-card">
                <div class="card-header">
                    <h2><i class="fas fa-concierge-bell"></i> Service Details</h2>
                </div>
                <div class="card-body">
                    <div class="service-type">
                        <div class="service-icon {{ strtolower(str_replace(' ', '-', $request['service']['type'])) }}">
                            @if($request['service']['type'] === 'Cat Sitting')
                                <i class="fas fa-home"></i>
                            @elseif($request['service']['type'] === 'Grooming')
                                <i class="fas fa-cut"></i>
                            @else
                                <i class="fas fa-user-md"></i>
                            @endif
                        </div>
                        <div>
                            <h3>{{ $request['service']['type'] }}</h3>
                            <p>{{ $request['service']['description'] }}</p>
                        </div>
                    </div>

                    <div class="service-details-grid">
                        <div class="detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <div>
                                <span class="label">Start Date & Time</span>
                                <span class="value">{{ date('l, M d, Y - H:i', strtotime($request['schedule']['start_date'])) }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-times"></i>
                            <div>
                                <span class="label">End Date & Time</span>
                                <span class="value">{{ date('l, M d, Y - H:i', strtotime($request['schedule']['end_date'])) }}</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-hourglass-half"></i>
                            <div>
                                <span class="label">Total Duration</span>
                                <span class="value">{{ $request['schedule']['duration_text'] }} ({{ $request['schedule']['duration_days'] }} days)</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="label">Service Location</span>
                                <span class="value">{{ $request['location']['city'] }}</span>
                                <span class="sub-value">{{ $request['location']['distance'] }} from your location</span>
                            </div>
                        </div>
                    </div>

                    @if($request['service']['add_ons'] && count($request['service']['add_ons']) > 0)
                    <div class="add-ons-section">
                        <h4><i class="fas fa-plus-circle"></i> Additional Services</h4>
                        <ul class="add-ons-list">
                            @foreach($request['service']['add_ons'] as $addon)
                            <li>
                                <i class="fas fa-check"></i>
                                {{ $addon['name'] }}
                                <span class="addon-price">+ Rp {{ number_format($addon['price'], 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Breakdown Card -->
            <div class="info-card pricing-card">
                <div class="card-header">
                    <h2><i class="fas fa-receipt"></i> Pricing Breakdown</h2>
                </div>
                <div class="card-body">
                    <div class="pricing-breakdown">
                        <div class="pricing-row">
                            <span>Base Price ({{ $request['service']['type'] }})</span>
                            <span>Rp {{ number_format($request['pricing']['base_price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="pricing-row">
                            <span>Duration ({{ $request['schedule']['duration_days'] }} days)</span>
                            <span>× {{ $request['schedule']['duration_days'] }}</span>
                        </div>
                        
                        @if($request['service']['add_ons'] && count($request['service']['add_ons']) > 0)
                        <div class="pricing-row">
                            <span>Additional Services</span>
                            <span>Rp {{ number_format($request['pricing']['addons_total'], 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($request['pricing']['cat_multiplier'] > 1)
                        <div class="pricing-row">
                            <span>Multiple Cats (×{{ count($request['cats']) }})</span>
                            <span>× {{ $request['pricing']['cat_multiplier'] }}</span>
                        </div>
                        @endif

                        <div class="pricing-divider"></div>

                        <div class="pricing-row subtotal">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($request['pricing']['subtotal'], 0, ',', '.') }}</span>
                        </div>

                        <div class="pricing-row fee">
                            <span>Platform Fee (10%)</span>
                            <span class="text-red">- Rp {{ number_format($request['pricing']['platform_fee'], 0, ',', '.') }}</span>
                        </div>

                        <div class="pricing-divider"></div>

                        <div class="pricing-row total">
                            <span>Your Earnings</span>
                            <span class="amount">Rp {{ number_format($request['pricing']['your_earning'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="payment-info">
                        <i class="fas fa-info-circle"></i>
                        <p>Payment will be released to your account 24 hours after service completion.</p>
                    </div>
                </div>
            </div>

            <!-- Special Notes Card -->
            @if($request['notes'])
            <div class="info-card notes-card">
                <div class="card-header">
                    <h2><i class="fas fa-sticky-note"></i> Special Instructions</h2>
                </div>
                <div class="card-body">
                    <p class="notes-content">{{ $request['notes'] }}</p>
                </div>
            </div>
            @endif

            <!-- Request Timeline Card -->
            <div class="info-card timeline-card">
                <div class="card-header">
                    <h2><i class="fas fa-history"></i> Request Timeline</h2>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Request Submitted</h4>
                                <p>{{ date('M d, Y - H:i', strtotime($request['created_at'])) }}</p>
                            </div>
                        </div>

                        @if($request['status'] === 'accepted')
                        <div class="timeline-item active">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Request Accepted</h4>
                                <p>{{ date('M d, Y - H:i', strtotime($request['accepted_at'])) }}</p>
                            </div>
                        </div>
                        @endif

                        @if($request['status'] === 'rejected')
                        <div class="timeline-item rejected">
                            <div class="timeline-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Request Rejected</h4>
                                <p>{{ date('M d, Y - H:i', strtotime($request['rejected_at'])) }}</p>
                                @if($request['rejection_reason'])
                                <p class="rejection-reason">Reason: {{ $request['rejection_reason'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($request['status'] === 'completed')
                        <div class="timeline-item completed">
                            <div class="timeline-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Service Completed</h4>
                                <p>{{ date('M d, Y - H:i', strtotime($request['completed_at'])) }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review Card (if completed) -->
            @if($request['status'] === 'completed' && isset($request['review']))
            <div class="info-card review-card">
                <div class="card-header">
                    <h2><i class="fas fa-star"></i> Client Review</h2>
                </div>
                <div class="card-body">
                    <div class="review-rating-large">
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $request['review']['rating'] ? 'filled' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="rating-number">{{ $request['review']['rating'] }}/5</span>
                    </div>
                    <p class="review-comment">{{ $request['review']['comment'] }}</p>
                    <div class="review-date">
                        <i class="far fa-clock"></i> {{ $request['review']['created_at'] }}
                    </div>

                    @if($request['review']['photos'] && count($request['review']['photos']) > 0)
                    <div class="review-photos">
                        <h4>Photos from this booking:</h4>
                        <div class="photos-grid">
                            @foreach($request['review']['photos'] as $photo)
                            <img src="{{ $photo }}" alt="Review photo" class="review-photo">
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>

    <!-- Action Buttons (Fixed Bottom) -->
    @if($request['status'] === 'pending')
    <div class="action-bar">
        <div class="action-container">
            <button class="btn-reject-large" onclick="showRejectModal({{ $request['id'] }})">
                <i class="fas fa-times"></i> Reject Request
            </button>
            <form action="{{ route('pet-sitter.requests.accept', $request['id']) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-accept-large" onclick="return confirmAccept()">
                    <i class="fas fa-check"></i> Accept Booking
                </button>
            </form>
        </div>
    </div>
    @endif

</div>

<!-- Reject Modal (sama seperti di index) -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-times-circle"></i> Reject Booking Request</h3>
            <button class="close-modal" onclick="closeRejectModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="rejectForm" action="{{ route('pet-sitter.requests.reject', $request['id']) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p>Please provide a reason for rejecting this booking request:</p>
                <div class="reason-options">
                    <label class="reason-option">
                        <input type="radio" name="reason_type" value="schedule_conflict">
                        <span>Schedule conflict / Not available</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="reason_type" value="location">
                        <span>Location too far from my area</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="reason_type" value="special_needs">
                        <span>Cannot accommodate cat's special needs</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="reason_type" value="pricing">
                        <span>Pricing doesn't match my rate</span>
                    </label>
                    <label class="reason-option">
                        <input type="radio" name="reason_type" value="other">
                        <span>Other reason (please specify)</span>
                    </label>
                </div>
                <textarea name="reason" id="rejectReason" rows="4" placeholder="Additional details (optional)"></textarea>
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
<script src="{{asset('js/sitter/request-detail.js')}}"></script>
@endsection
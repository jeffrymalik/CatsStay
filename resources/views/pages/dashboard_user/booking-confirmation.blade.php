@extends('layout.main')

@section('title', 'Booking Confirmation - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/booking-confirmation.css') }}">
<style>
    /* Additional styles for multiple cats display */
    .cats-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }
    
    .cats-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .cats-section-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }
    
    .cats-count-badge {
        background: #FF6B35;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 15px;
    }
    
    .cat-card-confirmation {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px;
        transition: all 0.3s;
    }
    
    .cat-card-confirmation:hover {
        border-color: #FF6B35;
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.1);
    }
    
    .cat-photo-wrapper {
        position: relative;
        margin-bottom: 12px;
    }
    
    .cat-photo-confirmation {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .cat-type-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .cat-type-badge.registered {
        background: #28a745;
        color: white;
    }
    
    .cat-type-badge.new {
        background: #ffc107;
        color: #000;
    }
    
    .cat-details {
        padding: 0;
    }
    
    .cat-name-confirmation {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    
    .cat-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #7f8c8d;
        margin-bottom: 4px;
    }
    
    .cat-info-item i {
        width: 14px;
        color: #95a5a6;
    }
    
    .new-cats-info {
        background: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 12px 15px;
        border-radius: 8px;
        margin-top: 15px;
        display: flex;
        gap: 10px;
        align-items: start;
    }
    
    .new-cats-info i {
        color: #2196F3;
        margin-top: 2px;
    }
    
    .new-cats-info p {
        margin: 0;
        font-size: 14px;
        color: #495057;
    }
    
    .new-cats-info a {
        color: #FF6B35;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')

<div class="confirmation-container">
    <div class="confirmation-wrapper">

        {{-- Success Icon --}}
        <div class="success-icon-wrapper">
            <div class="success-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 class="success-title">Booking Successful!</h1>
            <p class="success-subtitle">Your booking request has been sent to the sitter</p>
        </div>

        {{-- Booking Code Card --}}
        <div class="booking-code-card">
            <div class="booking-code-label">Booking Code</div>
            <div class="booking-code">{{ $booking->booking_code }}</div>
            <div class="booking-status">
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>
        </div>

        <div class="confirmation-content-grid">

            {{-- Left: Booking Details --}}
            <div class="confirmation-section">

                {{-- Cats Section (NEW - Multiple Cats) --}}
                <div class="cats-section">
                    <div class="cats-section-header">
                        <i class="fas fa-cat" style="color: #FF6B35; font-size: 20px;"></i>
                        <h3>Cat(s) for this Booking</h3>
                        <span class="cats-count-badge">
                            {{ $booking->total_cats }} {{ Str::plural('cat', $booking->total_cats) }}
                        </span>
                    </div>
                    
                    <div class="cats-grid">
                        @foreach($booking->bookingCats as $bookingCat)
                        <div class="cat-card-confirmation">
                            <div class="cat-photo-wrapper">
                                 @if($bookingCat->cat_type === 'registered' && $bookingCat->cat)
                <img src="{{ $bookingCat->cat->photo_url }}" 
                     alt="{{ $bookingCat->cat->name }}" 
                     class="cat-photo-confirmation">
            @else
                <img src="{{ asset('images/default-cat.jpg') }}" 
                     alt="{{ $bookingCat->new_cat_name }}" 
                     class="cat-photo-confirmation">
            @endif
                                @if($bookingCat->cat_type === 'registered')
                                <span class="cat-type-badge registered">
                                    <i class="fas fa-check"></i>
                                    Registered
                                </span>
                                @else
                                <span class="cat-type-badge new">
                                    <i class="fas fa-plus"></i>
                                    New
                                </span>
                                @endif
                            </div>
                            
                            <div class="cat-details">
                                <h4 class="cat-name-confirmation">{{ $bookingCat->cat_name }}</h4>
                                <div class="cat-info-item">
                                    <i class="fas fa-paw"></i>
                                    <span>{{ $bookingCat->cat_breed }}</span>
                                </div>
                                @if($bookingCat->cat_age && $bookingCat->cat_age !== 'Not specified')
                                <div class="cat-info-item">
                                    <i class="fas fa-birthday-cake"></i>
                                    <span>{{ $bookingCat->cat_age }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($booking->bookingCats->where('cat_type', 'new')->count() > 0)
                    <div class="new-cats-info">
                        <i class="fas fa-info-circle"></i>
                        <p>You can register your new cats in the <a href="{{ route('my-cats.index') }}">My Cats</a> section for easier booking next time.</p>
                    </div>
                    @endif
                </div>

                {{-- Booking Details --}}
                <div class="details-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Booking Details</h3>
                    </div>

                    <div class="details-grid">
                        <div class="detail-item">
                            <span class="detail-label">Service</span>
                            <span class="detail-value">{{ $booking->service->name }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Sitter</span>
                            <div class="sitter-info">
                                <img src="{{ $booking->sitter->avatar_url }}" 
                                     alt="{{ $booking->sitter->name }}" 
                                     class="sitter-avatar-small">
                                <div>
                                    <div class="detail-value">{{ $booking->sitter->name }}</div>
                                    <div class="sitter-rating">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($booking->sitter->sitterProfile->rating_average, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Number of Cats</span>
                            <span class="detail-value">
                                <strong>{{ $booking->total_cats }}</strong> {{ Str::plural('cat', $booking->total_cats) }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Dates</span>
                            <span class="detail-value">{{ $booking->date_range }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Duration</span>
                            <span class="detail-value">{{ $booking->duration }} {{ Str::plural('day', $booking->duration) }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Delivery Method</span>
                            <span class="detail-value">
                                @if($booking->delivery_method === 'pickup')
                                    <i class="fas fa-car"></i> Pick-up Service
                                @else
                                    <i class="fas fa-map-marker-alt"></i> Drop-off
                                @endif
                            </span>
                        </div>

                        @if($booking->delivery_method === 'pickup' && $booking->address)
                        <div class="detail-item full-width">
                            <span class="detail-label">Your Address</span>
                            <span class="detail-value">{{ $booking->address->formatted_address }}</span>
                        </div>
                        @else
                        <div class="detail-item full-width">
                            <span class="detail-label">Sitter's Address</span>
                            <span class="detail-value">
                                {{ $booking->sitter->addresses->first()->formatted_address ?? 'Address not available' }}
                            </span>
                        </div>
                        @endif

                        @if($booking->special_notes)
                        <div class="detail-item full-width">
                            <span class="detail-label">Special Notes</span>
                            <span class="detail-value">{{ $booking->special_notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Next Steps --}}
                <div class="next-steps-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Next Steps</h3>
                    </div>

                    <div class="steps-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Wait for Sitter Confirmation</h4>
                                <p>The sitter will review your request and respond within 24 hours.</p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Complete Payment</h4>
                                <p>Once confirmed, you'll receive payment instructions via notification.</p>
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Prepare for Service</h4>
                                <p>Get your cat(s) ready according to the scheduled date and delivery method.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right: Payment Summary --}}
            <div class="confirmation-sidebar">

                {{-- Price Summary --}}
                <div class="price-summary-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h3>Payment Summary</h3>
                    </div>

                    <div class="price-items">
                        <div class="price-item">
                            <span class="price-label">
                                {{ $booking->service->name }}
                                <br>
                                <small style="color: #7f8c8d;">
                                    (Rp {{ number_format($booking->service_price / $booking->duration / $booking->total_cats, 0, ',', '.') }} 
                                    × {{ $booking->duration }} {{ Str::plural('day', $booking->duration) }} 
                                    × {{ $booking->total_cats }} {{ Str::plural('cat', $booking->total_cats) }})
                                </small>
                            </span>
                            <span class="price-value">Rp {{ number_format($booking->service_price, 0, ',', '.') }}</span>
                        </div>

                        @if($booking->delivery_fee > 0)
                        <div class="price-item">
                            <span class="price-label">Pick-up Service</span>
                            <span class="price-value">Rp {{ number_format($booking->delivery_fee, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="price-item">
                            <span class="price-label">Platform Fee (5%)</span>
                            <span class="price-value">Rp {{ number_format($booking->platform_fee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="price-divider"></div>

                    <div class="price-total">
                        <span class="price-total-label">Total Payment</span>
                        <span class="price-total-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="payment-note">
                        <i class="fas fa-info-circle"></i>
                        <p>Payment will be requested after sitter confirmation</p>
                    </div>
                </div>

                {{-- Payment Methods Info --}}
                <div class="payment-methods-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3>Payment Methods</h3>
                    </div>

                    <div class="payment-methods-list">
                        <div class="payment-method-item">
                            <div class="payment-icon gopay">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">GoPay</div>
                                <div class="payment-desc">Instant & secure</div>
                            </div>
                        </div>

                        <div class="payment-method-item">
                            <div class="payment-icon ovo">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">OVO</div>
                                <div class="payment-desc">Fast payment</div>
                            </div>
                        </div>

                        <div class="payment-method-item">
                            <div class="payment-icon dana">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="payment-info">
                                <div class="payment-name">DANA</div>
                                <div class="payment-desc">Easy & quick</div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-info-note">
                        <p><strong>Note:</strong> You can choose your preferred e-wallet after sitter confirms your booking.</p>
                    </div>
                </div>

                {{-- Important Info --}}
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="info-content">
                        <h4>Important Information</h4>
                        <ul>
                            <li>Payment must be completed within 24 hours after sitter confirmation</li>
                            <li>Booking will be auto-cancelled if payment not received</li>
                            <li>Full refund available if cancelled before service date</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="action-buttons">
            <a href="{{ route('my-request.index') }}" class="btn-primary">
                <i class="fas fa-clipboard-list"></i>
                View My Requests
            </a>
            <a href="{{ route('user.dashboard') }}" class="btn-secondary">
                <i class="fas fa-home"></i>
                Back to Dashboard
            </a>
        </div>

        {{-- Additional Info --}}
        <div class="additional-info">
            <p>Questions about your booking? <a href="#" class="link-orange">Contact Support</a></p>
        </div>

    </div>
</div>

@endsection

@section('js')
<script>
    // Auto-scroll to top on page load
    window.scrollTo(0, 0);
    
    // Copy booking code functionality
    document.querySelector('.booking-code')?.addEventListener('click', function() {
        const code = this.textContent;
        navigator.clipboard.writeText(code).then(() => {
            // Show copied notification
            const notification = document.createElement('div');
            notification.className = 'copy-notification';
            notification.textContent = 'Booking code copied!';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                opacity: 0;
                transform: translateY(-20px);
                transition: all 0.3s ease;
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        });
    });
</script>
@endsection
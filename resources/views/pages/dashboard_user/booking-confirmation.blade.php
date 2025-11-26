@extends('layout.main')

@section('title', 'Booking Confirmation - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/booking-confirmation.css') }}">
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
            <div class="booking-code">{{ $booking['code'] }}</div>
            <div class="booking-status">
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking['status'])) }}">
                    {{ $booking['status'] }}
                </span>
            </div>
        </div>

        <div class="confirmation-content-grid">

            {{-- Left: Booking Details --}}
            <div class="confirmation-section">

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
                            <span class="detail-value">{{ $booking['service_name'] }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Sitter</span>
                            <div class="sitter-info">
                                <img src="{{ $booking['sitter_avatar'] }}" alt="{{ $booking['sitter_name'] }}" class="sitter-avatar-small">
                                <div>
                                    <div class="detail-value">{{ $booking['sitter_name'] }}</div>
                                    <div class="sitter-rating">
                                        <i class="fas fa-star"></i>
                                        {{ $booking['sitter_rating'] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Cat</span>
                            <span class="detail-value">{{ $booking['cat_name'] }} ({{ $booking['cat_breed'] }})</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Dates</span>
                            <span class="detail-value">{{ $booking['date_range'] }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Duration</span>
                            <span class="detail-value">{{ $booking['duration'] }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Delivery Method</span>
                            <span class="detail-value">
                                @if($booking['delivery_method'] === 'pickup')
                                    <i class="fas fa-car"></i> Pick-up Service
                                @else
                                    <i class="fas fa-map-marker-alt"></i> Drop-off
                                @endif
                            </span>
                        </div>

                        @if($booking['delivery_method'] === 'pickup')
                        <div class="detail-item full-width">
                            <span class="detail-label">Your Address</span>
                            <span class="detail-value">{{ $booking['user_address'] }}</span>
                        </div>
                        @else
                        <div class="detail-item full-width">
                            <span class="detail-label">Sitter's Address</span>
                            <span class="detail-value">{{ $booking['sitter_address'] }}</span>
                        </div>
                        @endif

                        @if($booking['special_notes'])
                        <div class="detail-item full-width">
                            <span class="detail-label">Special Notes</span>
                            <span class="detail-value">{{ $booking['special_notes'] }}</span>
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
                                <p>Get your cat ready according to the scheduled date and delivery method.</p>
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
                            <span class="price-label">{{ $booking['service_name'] }}</span>
                            <span class="price-value">{{ $booking['service_price'] }}</span>
                        </div>

                        @if($booking['delivery_fee'] > 0)
                        <div class="price-item">
                            <span class="price-label">Pick-up Service</span>
                            <span class="price-value">{{ $booking['delivery_fee_formatted'] }}</span>
                        </div>
                        @endif

                        <div class="price-item">
                            <span class="price-label">Platform Fee (5%)</span>
                            <span class="price-value">{{ $booking['platform_fee'] }}</span>
                        </div>
                    </div>

                    <div class="price-divider"></div>

                    <div class="price-total">
                        <span class="price-total-label">Total Payment</span>
                        <span class="price-total-value">{{ $booking['total_price'] }}</span>
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
                View My Request
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
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        });
    });
</script>
@endsection
@extends('layout.main')

@section('title', 'Payment - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="payment-container">
    <div class="payment-wrapper">
        
        {{-- Back Button --}}
        <div class="back-button-container">
            <a href="{{ route('my-request.show', $booking->id) }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Booking Details</span>
            </a>
        </div>

        <div class="payment-content">
            {{-- Left: Payment Form --}}
            <div class="payment-form-section">
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">
                            <i class="fas fa-credit-card"></i>
                            Choose Payment Method
                        </h2>
                    </div>
                    <div class="detail-card-body">
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('my-request.process-payment', $booking->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                            @csrf
                            
                            {{-- E-Wallet Options --}}
                            <div class="payment-section">
                                <h3 class="payment-section-title">E-Wallet</h3>
                                <div class="payment-methods">
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="gopay" required>
                                        <div class="payment-method-card">
                                            <i class="fas fa-wallet"></i>
                                            <span>GoPay</span>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="shopeepay">
                                        <div class="payment-method-card">
                                            <i class="fas fa-shopping-bag"></i>
                                            <span>ShopeePay</span>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="ovo">
                                        <div class="payment-method-card">
                                            <i class="fas fa-mobile-alt"></i>
                                            <span>OVO</span>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="dana">
                                        <div class="payment-method-card">
                                            <i class="fas fa-wallet"></i>
                                            <span>DANA</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Bank Transfer --}}
                            {{-- <div class="payment-section">
                                <h3 class="payment-section-title">Bank Transfer</h3>
                                <div class="payment-methods">
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="bank_transfer">
                                        <div class="payment-method-card">
                                            <i class="fas fa-university"></i>
                                            <span>Manual Transfer</span>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="virtual_account">
                                        <div class="payment-method-card">
                                            <i class="fas fa-money-check"></i>
                                            <span>Virtual Account</span>
                                        </div>
                                    </label>
                                </div>
                            </div> --}}

                            {{-- Card Payment --}}
                            {{-- <div class="payment-section">
                                <h3 class="payment-section-title">Card Payment</h3>
                                <div class="payment-methods">
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="credit_card">
                                        <div class="payment-method-card">
                                            <i class="fas fa-credit-card"></i>
                                            <span>Credit Card</span>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="debit_card">
                                        <div class="payment-method-card">
                                            <i class="fas fa-credit-card"></i>
                                            <span>Debit Card</span>
                                        </div>
                                    </label>
                                </div>
                            </div> --}}

                            {{-- QRIS
                            <div class="payment-section">
                                <h3 class="payment-section-title">QRIS</h3>
                                <div class="payment-methods">
                                    <label class="payment-method">
                                        <input type="radio" name="payment_method" value="qris">
                                        <div class="payment-method-card">
                                            <i class="fas fa-qrcode"></i>
                                            <span>Scan QRIS</span>
                                        </div>
                                    </label>
                                </div>
                            </div> --}}

                            {{-- Payment Proof Upload (for manual transfer) --}}
                            <div id="proofUploadSection" style="display: none;" class="payment-section">
                                <h3 class="payment-section-title">Upload Payment Proof</h3>
                                <div class="upload-area">
                                    <input type="file" name="payment_proof" id="paymentProof" accept="image/*">
                                    <label for="paymentProof" class="upload-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Click to upload payment proof</span>
                                        <small>JPG, JPEG, PNG (max 2MB)</small>
                                    </label>
                                    <div id="previewArea"></div>
                                </div>
                                @error('payment_proof')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn-primary btn-full btn-lg" id="submitBtn">
                                <i class="fas fa-check-circle"></i>
                                Confirm Payment - Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right: Order Summary --}}
            <div class="payment-summary-section">
                <div class="detail-card sticky-card">
                    <div class="detail-card-header">
                        <h2 class="detail-card-title">Order Summary</h2>
                    </div>
                    <div class="detail-card-body">
                        <div class="booking-summary">
                            <div class="summary-row">
                                <span class="label">Booking Code</span>
                                <span class="value">{{ $booking->booking_code }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Service</span>
                                <span class="value">{{ $booking->service->name }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Pet Sitter</span>
                                <span class="value">{{ $booking->sitter->name }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Duration</span>
                                <span class="value">{{ $booking->duration }} {{ $booking->duration > 1 ? 'days' : 'day' }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">Start Date</span>
                                <span class="value">{{ $booking->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="summary-row">
                                <span class="label">End Date</span>
                                <span class="value">{{ $booking->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="price-divider"></div>

                        <div class="price-breakdown">
                            <div class="price-row">
                                <span class="price-label">Service Price</span>
                                <span class="price-value">Rp {{ number_format($booking->service_price, 0, ',', '.') }}</span>
                            </div>
                            @if($booking->delivery_fee > 0)
                            <div class="price-row">
                                <span class="price-label">Delivery Fee</span>
                                <span class="price-value">Rp {{ number_format($booking->delivery_fee, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="price-row">
                                <span class="price-label">Platform Fee (5%)</span>
                                <span class="price-value">Rp {{ number_format($booking->platform_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-row price-total">
                                <span class="price-label">Total Payment</span>
                                <span class="price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="payment-info">
                            <i class="fas fa-shield-alt"></i>
                            <span>Your payment is secure and protected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
// Show payment proof upload for bank transfer
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const proofSection = document.getElementById('proofUploadSection');
        if (this.value === 'bank_transfer') {
            proofSection.style.display = 'block';
            document.getElementById('paymentProof').required = true;
        } else {
            proofSection.style.display = 'none';
            document.getElementById('paymentProof').required = false;
        }
    });
});

// Preview uploaded image
document.getElementById('paymentProof')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewArea').innerHTML = `
                <div class="image-preview">
                    <img src="${e.target.result}" alt="Payment Proof">
                    <button type="button" class="remove-preview" onclick="removePreview()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
});

function removePreview() {
    document.getElementById('paymentProof').value = '';
    document.getElementById('previewArea').innerHTML = '';
}

// Form submission
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
});

// Alert styles
const style = document.createElement('style');
style.textContent = `
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .alert-danger {
        background: #fee;
        border: 2px solid #fcc;
        color: #c33;
    }
    .alert-danger i {
        font-size: 1.2rem;
    }
`;
document.head.appendChild(style);
</script>
@endsection
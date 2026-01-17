@extends('layout.main')

@section('title', 'Payment Successful - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
.success-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
}

.success-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    max-width: 600px;
    width: 100%;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.success-icon {
    width: 100px;
    height: 100px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    animation: scaleIn 0.5s ease-out;
}

.success-icon i {
    font-size: 3rem;
    color: white;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.success-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.success-message {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.payment-details {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    text-align: left;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #dee2e6;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-size: 0.9rem;
    color: #6c757d;
}

.detail-value {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2c3e50;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.action-buttons a,
.action-buttons button {
    flex: 1;
    min-width: 200px;
}
</style>
@endsection

@section('content')

<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Payment Successful!</h1>
        
        <p class="success-message">
            Thank you for your payment. Your booking has been confirmed and the sitter will be notified.
        </p>

        <div class="payment-details">
            <div class="detail-row">
                <span class="detail-label">Booking Code</span>
                <span class="detail-value">{{ $booking->booking_code }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Code</span>
                <span class="detail-value">{{ $booking->payment->payment_code }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Service</span>
                <span class="detail-value">{{ $booking->service->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pet Sitter</span>
                <span class="detail-value">{{ $booking->sitter->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid</span>
                <span class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">{{ strtoupper(str_replace('_', ' ', $booking->payment->payment_method)) }}</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('my-request.show', $booking->id) }}" class="btn-primary">
                <i class="fas fa-file-alt"></i>
                View Booking Details
            </a>
            <a href="{{ route('my-request.index') }}" class="btn-secondary">
                <i class="fas fa-list"></i>
                My Bookings
            </a>
        </div>
    </div>
</div>

@endsection
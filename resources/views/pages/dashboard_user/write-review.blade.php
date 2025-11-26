@extends('layout.main')

@section('title', 'Write a Review - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/write-review.css') }}">
@endsection

@section('content')

<div class="review-container">
    <!-- Back Button -->
    <a href="{{ route('my-request.index') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to My Request
    </a>

    <div class="review-wrapper">
        
        <!-- Page Header -->
        <div class="review-header">
            <h1>Write a Review</h1>
            <p>Share your experience to help other cat owners</p>
        </div>

        <!-- Booking Info Card -->
        <div class="booking-info-card">
            <div class="booking-info-content">
                <img src="{{ $booking['sitter_avatar'] }}" alt="{{ $booking['sitter_name'] }}" class="sitter-avatar">
                <div class="booking-details">
                    <h3 class="sitter-name">{{ $booking['sitter_name'] }}</h3>
                    <div class="booking-meta">
                        <span class="service-type">
                            <i class="fas fa-paw"></i>
                            {{ $booking['service_name'] }}
                        </span>
                        <span class="booking-dates">
                            <i class="fas fa-calendar"></i>
                            {{ $booking['dates'] }}
                        </span>
                    </div>
                    <div class="booking-code">
                        <i class="fas fa-ticket-alt"></i>
                        Booking Code: <strong>{{ $booking['booking_code'] }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <form id="reviewForm" method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking['id'] }}">
            <input type="hidden" name="sitter_id" value="{{ $booking['sitter_id'] }}">
            <input type="hidden" name="rating" id="ratingInput" value="">

            <!-- Star Rating Section -->
            <div class="form-section">
                <label class="form-label">
                    Rate Your Experience 
                    <span class="required">*</span>
                </label>
                <p class="form-hint">Click on the stars to rate</p>
                
                <div class="star-rating-wrapper">
                    <div class="star-rating" id="starRating">
                        <i class="star far fa-star" data-rating="1"></i>
                        <i class="star far fa-star" data-rating="2"></i>
                        <i class="star far fa-star" data-rating="3"></i>
                        <i class="star far fa-star" data-rating="4"></i>
                        <i class="star far fa-star" data-rating="5"></i>
                    </div>
                    <span class="rating-text" id="ratingText">Select rating</span>
                </div>
                
                <div class="error-message" id="ratingError" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    Please select a rating
                </div>
            </div>

            <!-- Review Text Section -->
            <div class="form-section">
                <label class="form-label" for="reviewText">
                    Tell us about your experience
                    <span class="required">*</span>
                </label>
                <p class="form-hint">Share details about the service, care quality, and communication</p>
                
                <textarea 
                    id="reviewText" 
                    name="review_text" 
                    class="form-textarea" 
                    rows="6"
                    placeholder="What did you like? How was the communication? Would you recommend this sitter?"
                    minlength="20"
                    maxlength="500"
                ></textarea>
                
                <div class="textarea-footer">
                    <span class="char-counter">
                        <span id="charCount">0</span>/500 characters
                        <span class="char-min">(minimum 20)</span>
                    </span>
                </div>
                
                <div class="error-message" id="textError" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="textErrorMessage">Please write at least 20 characters</span>
                </div>
            </div>

            <!-- Photo Upload Section -->
            <div class="form-section">
                <label class="form-label">
                    Add Photos
                    <span class="optional">(Optional)</span>
                </label>
                <p class="form-hint">Share photos of your cat during the service (Max 3 photos, 2MB each)</p>
                
                <div class="photo-upload-wrapper">
                    <!-- Drag & Drop Zone -->
                    <div class="drag-drop-zone" id="dragDropZone">
                        <div class="drag-drop-content">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="drag-drop-text">Drag photos here or click to upload</p>
                            <p class="drag-drop-hint">JPG, PNG or WEBP (max 2MB each)</p>
                        </div>
                        <input 
                            type="file" 
                            id="photoInput" 
                            name="photos[]" 
                            accept="image/jpeg,image/png,image/webp" 
                            multiple 
                            style="display: none;"
                        >
                    </div>
                    
                    <!-- Photo Previews -->
                    <div class="photo-previews" id="photoPreviews" style="display: none;">
                        <!-- Dynamic previews will be inserted here -->
                    </div>
                    
                    <div class="photo-info">
                        <i class="fas fa-info-circle"></i>
                        <span id="photoCount">0/3 photos uploaded</span>
                    </div>
                </div>
                
                <div class="error-message" id="photoError" style="display: none;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="photoErrorMessage"></span>
                </div>
            </div>

            <!-- Recommendation Section -->
            <div class="form-section">
                <label class="form-label">
                    Would you recommend this sitter?
                    <span class="optional">(Optional)</span>
                </label>
                
                <div class="recommendation-options">
                    <label class="radio-option">
                        <input type="radio" name="recommendation" value="yes_definitely">
                        <span class="radio-custom"></span>
                        <div class="radio-content">
                            <span class="radio-icon">😊</span>
                            <span class="radio-label">Yes, definitely!</span>
                        </div>
                    </label>
                    
                    <label class="radio-option">
                        <input type="radio" name="recommendation" value="yes_with_reservations">
                        <span class="radio-custom"></span>
                        <div class="radio-content">
                            <span class="radio-icon">🤔</span>
                            <span class="radio-label">Yes, with reservations</span>
                        </div>
                    </label>
                    
                    <label class="radio-option">
                        <input type="radio" name="recommendation" value="not_sure">
                        <span class="radio-custom"></span>
                        <div class="radio-content">
                            <span class="radio-icon">😐</span>
                            <span class="radio-label">Not sure</span>
                        </div>
                    </label>
                    
                    <label class="radio-option">
                        <input type="radio" name="recommendation" value="no">
                        <span class="radio-custom"></span>
                        <div class="radio-content">
                            <span class="radio-icon">😞</span>
                            <span class="radio-label">No</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Guidelines Section -->
            <div class="guidelines-box">
                <h4>
                    <i class="fas fa-clipboard-list"></i>
                    Review Guidelines
                </h4>
                <ul>
                    <li>Be honest and constructive in your feedback</li>
                    <li>Focus on your personal experience with the service</li>
                    <li>Avoid offensive language or personal attacks</li>
                    <li>Don't include personal contact information</li>
                </ul>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('my-request.index') }}" class="btn-cancel">
                    Cancel
                </a>
                <button type="submit" class="btn-submit" id="submitButton">
                    <i class="fas fa-paper-plane"></i>
                    Submit Review
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/write-review.js') }}"></script>
@endsection
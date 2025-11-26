@extends('layout.main')

@section('title', 'Book ' . $sitter['name'] . ' - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/booking-form.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="booking-container">
    <div class="booking-wrapper">
        
        {{-- Sitter Summary Card --}}
        <div class="sitter-summary-card">
            <div class="summary-content">
                <img src="{{ $sitter['avatar'] }}" alt="{{ $sitter['name'] }}" class="summary-avatar">
                <div class="summary-info">
                    <div class="summary-header">
                        <h2 class="summary-name">{{ $sitter['name'] }}</h2>
                        @if($sitter['verified'])
                        <span class="verified-badge-small">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        @endif
                    </div>
                    <p class="summary-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $sitter['location'] }}
                    </p>
                    <div class="summary-rating">
                        <i class="fas fa-star"></i>
                        <span>{{ $sitter['rating'] }}</span>
                        <span class="reviews-count">({{ $sitter['reviews_count'] }} reviews)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="booking-content-grid">
            
            {{-- Left: Booking Form --}}
            <div class="booking-form-section">
                
                {{-- Error/Success Messages --}}
                <div id="formMessages"></div>

                @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <p><strong>Please fix the following errors:</strong></p>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sitter_id" value="{{ $sitter['id'] }}">

                    {{-- Step 1: Select Service --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">1</span>
                            <h3 class="section-title">Select Service</h3>
                        </div>

                        <div class="services-selection">
                            @foreach($sitter['services'] as $index => $service)
                            <label class="service-option">
                                <input type="radio" 
                                       name="service_type" 
                                       value="{{ $service['type'] }}" 
                                       data-price="{{ $service['price'] }}"
                                       data-name="{{ $service['name'] }}"
                                       data-single-day="{{ $service['is_single_day'] ? 'true' : 'false' }}"
                                       data-is-home-visit="{{ $service['type'] === 'home-visit' ? 'true' : 'false' }}"
                                       {{ $index === 0 ? 'checked' : '' }}
                                       required>
                                <div class="service-option-card">
                                    <div class="service-option-header">
                                        <div class="service-option-icon">
                                            <i class="fas {{ $service['icon'] }}"></i>
                                        </div>
                                        <div class="service-option-info">
                                            <h4 class="service-option-name">{{ $service['name'] }}</h4>
                                            <p class="service-option-price">Rp {{ number_format($service['price'], 0, ',', '.') }} <span>/day</span></p>
                                        </div>
                                    </div>
                                    <p class="service-option-description">{{ $service['description'] }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Step 2: Select Your Cat --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">2</span>
                            <h3 class="section-title">Select Your Cat</h3>
                        </div>

                        {{-- Cat Type Toggle --}}
                        <div class="cat-type-toggle">
                            <label class="toggle-option active" data-target="registered">
                                <input type="radio" name="cat_type" value="registered" checked>
                                <span class="toggle-label">
                                    <i class="fas fa-list"></i>
                                    Use Registered Cat
                                </span>
                            </label>
                            <label class="toggle-option" data-target="new">
                                <input type="radio" name="cat_type" value="new">
                                <span class="toggle-label">
                                    <i class="fas fa-plus-circle"></i>
                                    Add New Cat
                                </span>
                            </label>
                        </div>

                        {{-- Registered Cats Dropdown --}}
                        <div class="cat-selection-wrapper" id="registeredCatSection">
                            <select name="registered_cat_id" id="registeredCatSelect" class="form-select">
                                <option value="">Choose your cat...</option>
                                @foreach($registeredCats as $cat)
                                <option value="{{ $cat['id'] }}" data-photo="{{ $cat['photo'] }}">
                                    {{ $cat['name'] }} ({{ $cat['breed'] }}, {{ $cat['age'] }})
                                </option>
                                @endforeach
                            </select>

                            {{-- Selected Cat Preview --}}
                            <div class="selected-cat-preview" id="catPreview" style="display: none;">
                                <img src="" alt="Cat photo" id="catPreviewImg">
                                <div class="cat-preview-info">
                                    <h4 id="catPreviewName"></h4>
                                    <p id="catPreviewDetails"></p>
                                </div>
                            </div>
                        </div>

                        {{-- New Cat Input --}}
                        <div class="cat-selection-wrapper" id="newCatSection" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-cat"></i>
                                    Cat Name *
                                </label>
                                <input type="text" 
                                       name="new_cat_name" 
                                       class="form-input" 
                                       placeholder="e.g., Luna">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-paw"></i>
                                        Breed (Optional)
                                    </label>
                                    <input type="text" 
                                           name="new_cat_breed" 
                                           class="form-input" 
                                           placeholder="e.g., Persian">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-birthday-cake"></i>
                                        Age (Optional)
                                    </label>
                                    <input type="text" 
                                           name="new_cat_age" 
                                           class="form-input" 
                                           placeholder="e.g., 2 years">
                                </div>
                            </div>

                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <p>You can add more details about your cat in "My Cats" section after booking.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3: Select Dates --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">3</span>
                            <h3 class="section-title">Select Dates</h3>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar-day"></i>
                                    <span id="startDateLabel">Start Date *</span>
                                </label>
                                <input type="date" 
                                       name="start_date" 
                                       id="startDate"
                                       class="form-input" 
                                       required
                                       min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group" id="endDateWrapper">
                                <label class="form-label">
                                    <i class="fas fa-calendar-check"></i>
                                    End Date *
                                </label>
                                <input type="date" 
                                       name="end_date" 
                                       id="endDate"
                                       class="form-input" 
                                       required
                                       min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="duration-display">
                            <i class="fas fa-clock"></i>
                            <span id="durationText">Please select dates</span>
                        </div>
                    </div>

                    {{-- Step 4: Delivery Method (NEW!) --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">4</span>
                            <h3 class="section-title">Delivery Method</h3>
                        </div>

                        <div class="delivery-selection">
                            {{-- Drop-off Option --}}
                            <label class="delivery-option" id="dropoffOption">
                                <input type="radio" 
                                       name="delivery_method" 
                                       value="dropoff" 
                                       checked
                                       required>
                                <div class="delivery-option-card">
                                    <div class="delivery-option-header">
                                        <div class="delivery-option-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="delivery-option-info">
                                            <h4 class="delivery-option-name">Drop-off</h4>
                                            <p class="delivery-option-price">Included</p>
                                        </div>
                                    </div>
                                    <p class="delivery-option-description">I'll bring my cat to sitter's place</p>
                                    
                                    {{-- Sitter Address (shown when drop-off selected) --}}
                                    <div class="sitter-address-box" id="sitterAddressBox">
                                        <div class="address-header">
                                            <i class="fas fa-home"></i>
                                            <span>Sitter's Address:</span>
                                        </div>
                                        <p class="address-text">{{ $sitter['address'] ?? 'Jl. Sudirman No. 45, ' . $sitter['location'] }}</p>
                                        <a href="#" class="view-map-link">
                                            <i class="fas fa-map"></i>
                                            View on Map
                                        </a>
                                    </div>
                                </div>
                            </label>

                            {{-- Pick-up Option --}}
                            <label class="delivery-option" id="pickupOption">
                                <input type="radio" 
                                       name="delivery_method" 
                                       value="pickup"
                                       required>
                                <div class="delivery-option-card">
                                    <div class="delivery-option-header">
                                        <div class="delivery-option-icon">
                                            <i class="fas fa-car"></i>
                                        </div>
                                        <div class="delivery-option-info">
                                            <h4 class="delivery-option-name">Pick-up Service</h4>
                                            <p class="delivery-option-price">+ Rp 50,000</p>
                                        </div>
                                    </div>
                                    <p class="delivery-option-description">Sitter will come to my place</p>
                                    
                                    {{-- User Address Selection (shown when pick-up selected) --}}
                                    <div class="user-address-selection" id="userAddressSelection" style="display: none;">
                                        <label class="form-label">
                                            <i class="fas fa-home"></i>
                                            Select Your Address *
                                        </label>
                                        <select name="user_address_id" id="userAddressSelect" class="form-select">
                                            <option value="">Choose your address...</option>
                                            @foreach($userAddresses as $address)
                                            <option value="{{ $address['id'] }}">
                                                {{ $address['label'] }} - {{ $address['full_address'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                        
                                        <a href="{{ route('profile.address') }}" class="add-address-link" target="_blank">
                                            <i class="fas fa-plus-circle"></i>
                                            Add New Address
                                        </a>
                                        
                                        {{-- Selected Address Preview --}}
                                        <div class="selected-address-preview" id="addressPreview" style="display: none;">
                                            <div class="address-preview-header">
                                                <i class="fas fa-map-pin"></i>
                                                <span id="addressPreviewLabel"></span>
                                            </div>
                                            <p id="addressPreviewText"></p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Home Visit Info Box --}}
                        <div class="info-box home-visit-info" id="homeVisitInfo" style="display: none;">
                            <i class="fas fa-info-circle"></i>
                            <p><strong>Home Visit Service:</strong> Sitter will come to your place. Pick-up fee (Rp 50,000) is included in the service.</p>
                        </div>
                    </div>

                    {{-- Step 5: Special Notes --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">5</span>
                            <h3 class="section-title">Special Notes (Optional)</h3>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-comment-dots"></i>
                                Any special requests or information about your cat?
                            </label>
                            <textarea name="special_notes" 
                                      class="form-textarea" 
                                      rows="4"
                                      maxlength="500"
                                      placeholder="e.g., My cat is shy and needs extra patience. She prefers wet food in the morning..."></textarea>
                            <span class="char-count">0/500 characters</span>
                        </div>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="form-section">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="terms_accepted" required>
                            <span class="checkbox-label">
                                I agree to the <a href="#" class="link-orange">Terms of Service</a> and <a href="#" class="link-orange">Cancellation Policy</a>
                            </span>
                        </label>
                    </div>

                </form>
            </div>

            {{-- Right: Price Summary (Sticky) --}}
            <div class="price-summary-section">
                <div class="price-summary-card">
                    <h3 class="summary-card-title">Booking Summary</h3>

                    <div class="summary-item">
                        <span class="summary-label">Service</span>
                        <span class="summary-value" id="summaryService">-</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Price per day</span>
                        <span class="summary-value" id="summaryPricePerDay">Rp 0</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Duration</span>
                        <span class="summary-value" id="summaryDuration">0 days</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item subtotal">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="summarySubtotal">Rp 0</span>
                    </div>

                    {{-- Delivery Fee (NEW!) --}}
                    <div class="summary-item" id="summaryDeliveryItem" style="display: none;">
                        <span class="summary-label">Pick-up Service</span>
                        <span class="summary-value" id="summaryDeliveryFee">Rp 50,000</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Platform Fee (5%)</span>
                        <span class="summary-value" id="summaryPlatformFee">Rp 0</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="summaryTotal">Rp 0</span>
                    </div>

                    <button type="submit" form="bookingForm" class="btn-confirm-booking">
                        <i class="fas fa-check-circle"></i>
                        Confirm Booking
                    </button>

                    <div class="summary-info">
                        <i class="fas fa-info-circle"></i>
                        <p>You won't be charged until the service is completed</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Back Button --}}
        <div class="back-button-wrapper">
            <a href="{{ route('sitter.profile', $sitter['id']) }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Sitter Profile</span>
            </a>
        </div>

    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/booking-form.js') }}"></script>
@endsection
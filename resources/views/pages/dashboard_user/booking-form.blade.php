@extends('layout.main')

@section('title', 'Book ' . $sitter['name'] . ' - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/booking-form.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Additional styles for multiple cats selection */
    .cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .cat-card {
        position: relative;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    
    .cat-card:hover {
        border-color: #FF6B35;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.2);
    }
    
    .cat-card.selected {
        border-color: #FF6B35;
        background: #fff5f2;
    }
    
    .cat-card input[type="checkbox"] {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: #FF6B35;
    }
    
    .cat-photo {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    
    .cat-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .cat-info p {
        font-size: 13px;
        color: #7f8c8d;
        margin: 0;
    }
    
    /* Selected Cats Preview */
    .selected-cats-preview {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
    
    .selected-cats-preview h4 {
        font-size: 14px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .selected-cats-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .selected-cat-tag {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .selected-cat-tag i {
        color: #28a745;
        font-size: 12px;
    }
    
    /* New Cats Container */
    .new-cats-container {
        margin-top: 20px;
    }
    
    .new-cat-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        position: relative;
    }
    
    .new-cat-item h4 {
        font-size: 16px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 15px;
    }
    
    .remove-cat-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }
    
    .remove-cat-btn:hover {
        background: #c82333;
    }
    
    .add-cat-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        margin-top: 15px;
        transition: background 0.3s;
    }
    
    .add-cat-btn:hover {
        background: #218838;
    }
    
    /* Cats count badge */
    .cats-count-badge {
        background: #FF6B35;
        color: white;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }
</style>
@endsection

@section('content')

<div class="booking-container">
    <div class="booking-wrapper">
        
        {{-- Sitter Summary Card --}}
        <div class="sitter-summary-card">
            <div class="summary-content">
                <img src="{{ $sitter->avatar_url }}" alt="{{ $sitter->name }}" class="summary-avatar">
                <div class="summary-info">
                    <div class="summary-header">
                        <h2 class="summary-name">{{ $sitter->name }}</h2>
                        @if($sitter->sitterProfile->is_verified)
                        <span class="verified-badge-small">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        @endif
                    </div>
                    <p class="summary-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $sitter->addresses->first()->city ?? 'Location not available' }}
                    </p>
                    <div class="summary-rating">
                        <i class="fas fa-star"></i>
                        <span>{{ number_format($sitter->sitterProfile->rating_average, 1) }}</span>
                        <span class="reviews-count">({{ $sitter->sitterProfile->total_reviews }} reviews)</span>
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
                    <input type="hidden" name="sitter_id" value="{{ $sitter->id }}">

                    {{-- Step 1: Select Service --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">1</span>
                            <h3 class="section-title">Select Service</h3>
                        </div>

                        <div class="services-selection">
                            @php
                                $services = $sitter->sitterProfile->services_with_pricing;
                            @endphp
                            
                            @foreach($sitter->sitterProfile->services_with_pricing as $index => $service)
                            <label class="service-option">
                                <input type="radio" 
                                    name="service_type" 
                                    value="{{ $service['type'] }}" 
                                    data-price="{{ $service['price'] }}"
                                    data-name="{{ $service['name'] }}"
                                    data-is-single-day="{{ in_array($service['type'], ['grooming', 'home-visit']) ? 'true' : 'false' }}"
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
                                            <p class="service-option-price">
                                                Rp {{ number_format($service['price'], 0, ',', '.') }} 
                                                <span>/{{ in_array($service['type'], ['grooming', 'home-visit']) ? 'session' : 'day' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="service-option-description">
                                        @if($service['type'] === 'cat-sitting')
                                            Multi-day care at sitter's home
                                        @elseif($service['type'] === 'grooming')
                                            Single session professional grooming
                                        @else
                                            Single visit to your home
                                        @endif
                                    </p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Step 2: Select Your Cats (UPDATED FOR MULTIPLE SELECTION) --}}
                    <div class="form-section">
                        <div class="section-header">
                            <span class="step-number">2</span>
                            <h3 class="section-title">Select Your Cats</h3>
                        </div>

                        {{-- Cat Type Toggle --}}
                        <div class="cat-type-toggle">
                            <label class="toggle-option active" data-target="registered">
                                <input type="radio" name="cat_type" value="registered" checked onchange="toggleCatType()">
                                <span class="toggle-label">
                                    <i class="fas fa-list"></i>
                                    Use Registered Cats
                                </span>
                            </label>
                            <label class="toggle-option" data-target="new">
                                <input type="radio" name="cat_type" value="new" onchange="toggleCatType()">
                                <span class="toggle-label">
                                    <i class="fas fa-plus-circle"></i>
                                    Add New Cats
                                </span>
                            </label>
                        </div>

                        {{-- Registered Cats Grid (Multiple Selection) --}}
                        <div class="cat-selection-wrapper" id="registeredCatSection">
                            @if($registeredCats->count() > 0)
                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <p>Select one or more cats for this booking. The price will be calculated per cat.</p>
                            </div>

                            <div class="cats-grid" id="catsGrid">
                                @foreach($registeredCats as $cat)
                                <label class="cat-card" onclick="toggleCatSelection(this)">
                                    <input type="checkbox" 
                                           name="registered_cat_ids[]" 
                                           value="{{ $cat->id }}"
                                           data-name="{{ $cat->name }}"
                                           data-breed="{{ $cat->breed ?? 'Mixed Breed' }}"
                                           data-age="{{ $cat->age ?? 'Unknown' }}"
                                           onchange="updateCatsSelection()"
                                           {{ in_array($cat->id, old('registered_cat_ids', [])) ? 'checked' : '' }}>
                                    <img src="{{ $cat->photo_url }}" alt="{{ $cat->name }}" class="cat-photo">
                                    <div class="cat-info">
                                        <h4>{{ $cat->name }}</h4>
                                        <p>{{ $cat->breed ?? 'Mixed Breed' }}, {{ $cat->age ?? 'Age unknown' }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>

                            {{-- Selected Cats Preview --}}
                            <div class="selected-cats-preview" id="selectedCatsPreview" style="display: none;">
                                <h4>
                                    <i class="fas fa-check-circle"></i>
                                    Selected Cats (<span id="selectedCatsCount">0</span>)
                                </h4>
                                <div class="selected-cats-list" id="selectedCatsList"></div>
                            </div>
                            @else
                            <div class="info-box warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>You don't have any registered cats yet. Please add a new cat below or <a href="{{ route('my-cats.create') }}" target="_blank">register your cat first</a>.</p>
                            </div>
                            @endif
                        </div>

                        {{-- New Cats Section (Multiple) --}}
                        <div class="cat-selection-wrapper" id="newCatSection" style="display: none;">
                            <div class="info-box">
                                <i class="fas fa-info-circle"></i>
                                <p>Add one or more cats that are not yet registered. You can register them properly after booking.</p>
                            </div>

                            <div class="new-cats-container" id="newCatsContainer">
                                {{-- Initial new cat form --}}
                                <div class="new-cat-item" data-index="0">
                                    <h4>Cat #1</h4>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-cat"></i>
                                            Cat Name *
                                        </label>
                                        <input type="text" 
                                               name="new_cats[0][name]" 
                                               class="form-input @error('new_cats.0.name') is-invalid @enderror" 
                                               placeholder="e.g., Luna"
                                               value="{{ old('new_cats.0.name') }}">
                                        @error('new_cats.0.name')
                                        <span class="invalid-feedback" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-paw"></i>
                                                Breed (Optional)
                                            </label>
                                            <input type="text" 
                                                   name="new_cats[0][breed]" 
                                                   class="form-input @error('new_cats.0.breed') is-invalid @enderror" 
                                                   placeholder="e.g., Persian"
                                                   value="{{ old('new_cats.0.breed') }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-birthday-cake"></i>
                                                Age (Optional)
                                            </label>
                                            <input type="text" 
                                                   name="new_cats[0][age]" 
                                                   class="form-input @error('new_cats.0.age') is-invalid @enderror" 
                                                   placeholder="e.g., 2 years"
                                                   value="{{ old('new_cats.0.age') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="add-cat-btn" onclick="addNewCatForm()">
                                <i class="fas fa-plus"></i>
                                Add Another Cat
                            </button>
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
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('start_date') }}">
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
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('end_date') }}">
                            </div>
                        </div>

                        <div class="duration-display">
                            <i class="fas fa-clock"></i>
                            <span id="durationText">Please select dates</span>
                        </div>
                    </div>

                    {{-- Step 4: Delivery Method --}}
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
                                       {{ old('delivery_method', 'dropoff') === 'dropoff' ? 'checked' : '' }}
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
                                    <p class="delivery-option-description">I'll bring my cat(s) to sitter's place</p>
                                    
                                    {{-- Sitter Address --}}
                                    <div class="sitter-address-box" id="sitterAddressBox">
                                        <div class="address-header">
                                            <i class="fas fa-home"></i>
                                            <span>Sitter's Address:</span>
                                        </div>
                                        <p class="address-text">{{ $sitter->addresses->first()->formatted_address ?? 'Address not available' }}</p>
                                    </div>
                                </div>
                            </label>

                            {{-- Pick-up Option --}}
                            <label class="delivery-option" id="pickupOption">
                                <input type="radio" 
                                       name="delivery_method" 
                                       value="pickup"
                                       {{ old('delivery_method') === 'pickup' ? 'checked' : '' }}
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
                                    
                                    {{-- User Address Selection --}}
                                    <div class="user-address-selection" id="userAddressSelection" style="{{ old('delivery_method') === 'pickup' ? '' : 'display: none;' }}">
                                        @if($userAddresses->count() > 0)
                                        <label class="form-label">
                                            <i class="fas fa-home"></i>
                                            Select Your Address *
                                        </label>
                                        <select name="user_address_id" id="userAddressSelect" class="form-select">
                                            <option value="">Choose your address...</option>
                                            @foreach($userAddresses as $address)
                                            <option value="{{ $address->id }}"
                                                    data-label="{{ $address->label }}"
                                                    data-address="{{ $address->formatted_address }}"
                                                    {{ old('user_address_id') == $address->id ? 'selected' : '' }}>
                                                {{ $address->label }} - {{ $address->full_address }}
                                            </option>
                                            @endforeach
                                        </select>
                                        
                                        {{-- Selected Address Preview --}}
                                        <div class="selected-address-preview" id="addressPreview" style="display: none;">
                                            <div class="address-preview-header">
                                                <i class="fas fa-map-pin"></i>
                                                <span id="addressPreviewLabel"></span>
                                            </div>
                                            <p id="addressPreviewText"></p>
                                        </div>
                                        @else
                                        <div class="info-box warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <p>You don't have any saved addresses. Please <a href="{{ route('profile.address') }}" target="_blank">add your address</a> first to use pick-up service.</p>
                                        </div>
                                        @endif
                                        
                                        <a href="{{ route('profile.address') }}" class="add-address-link" target="_blank">
                                            <i class="fas fa-plus-circle"></i>
                                            Add New Address
                                        </a>
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
                                Any special requests or information about your cat(s)?
                            </label>
                            <textarea name="special_notes" 
                                      id="specialNotes"
                                      class="form-textarea" 
                                      rows="4"
                                      maxlength="500"
                                      placeholder="e.g., Luna is shy and needs extra patience. Max prefers wet food in the morning...">{{ old('special_notes') }}</textarea>
                            <span class="char-count"><span id="notesCount">0</span>/500 characters</span>
                        </div>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="form-section">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" name="terms_accepted" required {{ old('terms_accepted') ? 'checked' : '' }}>
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
                        <span class="summary-value" id="summaryService">{{ $services[0]['name'] ?? '-' }}</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Price per cat/day</span>
                        <span class="summary-value" id="summaryPricePerDay">Rp {{ number_format($services[0]['price'] ?? 0, 0, ',', '.') }}</span>
                    </div>

                    {{-- NEW: Number of cats --}}
                    <div class="summary-item">
                        <span class="summary-label">Number of cats</span>
                        <span class="summary-value">
                            <span id="summaryTotalCats">0</span>
                            <span class="cats-count-badge" id="catsCountBadge" style="display: none;">0 cats</span>
                        </span>
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

                    {{-- Delivery Fee --}}
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
            <a href="{{ url()->previous() }}" class="back-link">
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
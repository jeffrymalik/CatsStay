@extends('layout.main')

@section('title', 'Find Sitter - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/find-sitter.css')}}">
@endsection

@section('content')
<div class="find-sitter-container">
    {{-- Header Section (Centered) --}}
    <div class="header-section">
        <h1 class="page-title">Find Your Perfect Cat Sitter</h1>
        <p class="page-subtitle">Browse through our trusted and verified cat sitters in your area</p>
    </div>

    {{-- Service Filter Badge (Conditional - Only show when filtered) --}}
    @if($selectedService && $serviceName)
    <div class="active-filter-banner">
        <div class="filter-badge-content">
            <span class="filter-service-icon">
                @if($selectedService == 'cat-sitting')
                    🏠
                @elseif($selectedService == 'grooming')
                    ✂️
                @elseif($selectedService == 'home-visit')
                    🏡
                @endif
            </span>
            <span class="filter-service-name">{{ $serviceName }}</span>
            <span class="filter-divider">•</span>
            <span class="filter-count">{{ count($sitters) }} result{{ count($sitters) != 1 ? 's' : '' }}</span>
            <a href="{{ url('/find-sitter') }}" class="btn-clear-filter">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                Clear Filter
            </a>
        </div>
    </div>
    @endif

    {{-- Search & Filter Section --}}
    <div class="search-filter-wrapper">
        <div class="search-bar-large">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="8" stroke="#999" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#999" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Search by name, location, or experience..." class="search-input-large">
        </div>

        <button class="filter-btn-orange" id="filterBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="4" y1="6" x2="20" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="4" y1="18" x2="20" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="8" cy="6" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
                <circle cx="16" cy="12" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
                <circle cx="12" cy="18" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
            </svg>
            Filters
            <span class="filter-badge-count" id="filterBadge" style="display: none;">0</span>
        </button>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-panel" id="filterPanel">
        <div class="filter-panel-header">
            <h3 class="filter-title">Filter Sitters</h3>
            <button class="close-filter-btn" id="closeFilterBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <div class="filter-content">
            {{-- Service Type Filter --}}
            <div class="filter-group">
                <label class="filter-label">Service Type</label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" value="cat-sitting" class="service-checkbox" {{ $selectedService == 'cat-sitting' ? 'checked' : '' }}>
                        <span>🏠 Cat Sitting</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="grooming" class="service-checkbox" {{ $selectedService == 'grooming' ? 'checked' : '' }}>
                        <span>✂️ Grooming</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="home-visit" class="service-checkbox" {{ $selectedService == 'home-visit' ? 'checked' : '' }}>
                        <span>🏡 Home Visit</span>
                    </label>
                </div>
            </div>

            {{-- Location Filter --}}
            <div class="filter-group">
                <label class="filter-label">Location</label>
                <select class="filter-select" id="locationFilter">
                    <option value="">All Locations</option>
                    <option value="jakarta-selatan">Jakarta Selatan</option>
                    <option value="jakarta-pusat">Jakarta Pusat</option>
                    <option value="jakarta-utara">Jakarta Utara</option>
                    <option value="jakarta-barat">Jakarta Barat</option>
                    <option value="jakarta-timur">Jakarta Timur</option>
                    <option value="tangerang">Tangerang</option>
                    <option value="bekasi">Bekasi</option>
                    <option value="depok">Depok</option>
                    <option value="bogor">Bogor</option>
                </select>
            </div>

            {{-- Price Range Filter --}}
            <div class="filter-group">
                <label class="filter-label">Price Range (per day)</label>
                <div class="price-inputs">
                    <input type="number" class="filter-input" id="minPrice" placeholder="Min" min="0">
                    <span class="price-separator">-</span>
                    <input type="number" class="filter-input" id="maxPrice" placeholder="Max" min="0">
                </div>
            </div>

            {{-- Rating Filter --}}
            <div class="filter-group">
                <label class="filter-label">Minimum Rating</label>
                <div class="rating-filter">
                    <div class="rating-option">
                        <input type="radio" name="rating" id="rating5" value="5">
                        <label for="rating5">
                            <div class="stars">⭐⭐⭐⭐⭐</div>
                            <span>5.0</span>
                        </label>
                    </div>
                    <div class="rating-option">
                        <input type="radio" name="rating" id="rating4" value="4">
                        <label for="rating4">
                            <div class="stars">⭐⭐⭐⭐</div>
                            <span>4.0+</span>
                        </label>
                    </div>
                    <div class="rating-option">
                        <input type="radio" name="rating" id="rating3" value="3">
                        <label for="rating3">
                            <div class="stars">⭐⭐⭐</div>
                            <span>3.0+</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Experience Filter --}}
            <div class="filter-group">
                <label class="filter-label">Experience</label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" value="5" class="experience-checkbox">
                        <span>5+ years</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="3" class="experience-checkbox">
                        <span>3+ years</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="1" class="experience-checkbox">
                        <span>1+ year</span>
                    </label>
                </div>
            </div>

            {{-- Verified Filter --}}
            <div class="filter-group">
                <label class="checkbox-label checkbox-label-single">
                    <input type="checkbox" id="verifiedOnly" class="verified-checkbox">
                    <span>Verified Sitters Only</span>
                </label>
            </div>

            {{-- Filter Actions --}}
            <div class="filter-actions">
                <button class="btn-reset-filter" id="resetFilterBtn">Reset All</button>
                <button class="btn-apply-filter" id="applyFilterBtn">Apply Filters</button>
            </div>
        </div>
    </div>

    {{-- Results Header --}}
    <div class="results-header">
        <p class="results-count" id="resultsCount">Showing <strong>{{ count($sitters) }}</strong> sitters</p>
        <div class="sort-container">
            <label for="sortSelect" class="sort-label">Sort by:</label>
            <select id="sortSelect" class="sort-select">
                <option value="recommended">Recommended</option>
                <option value="rating-high">Highest Rated</option>
                <option value="rating-low">Lowest Rated</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="experience">Most Experienced</option>
            </select>
        </div>
    </div>

    {{-- Sitters Grid --}}
    <div class="sitters-grid" id="sittersGrid">
        @forelse($sitters as $sitter)
        {{-- Sitter Card --}}
        <div class="sitter-card" 
             data-location="{{ $sitter['location_slug'] }}" 
             data-price="{{ $sitter['price_per_day'] }}" 
             data-rating="{{ $sitter['rating'] }}" 
             data-experience="{{ $sitter['experience_years'] }}" 
             data-verified="{{ $sitter['verified'] ? 'true' : 'false' }}"
             data-services="{{ implode(',', $sitter['services']) }}">
            
            <div class="sitter-card-header">
                <img src="{{ $sitter['avatar'] }}" alt="{{ $sitter['name'] }}" class="sitter-card-avatar">
                
                @if($sitter['verified'])
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                @endif
                
                <button class="favorite-btn" data-sitter-id="{{ $sitter['id'] }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">{{ $sitter['name'] }}</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    {{ $sitter['location'] }}
                </p>
                
                {{-- Services Tags --}}
                <div class="sitter-services-tags">
                    @foreach($sitter['services'] as $service)
                        @php
                            $serviceLabels = [
                                'cat-sitting' => '🏠 Cat Sitting',
                                'grooming' => '✂️ Grooming',
                                'home-visit' => '🏡 Home Visit'
                            ];
                        @endphp
                        <span class="service-tag {{ $selectedService == $service ? 'active' : '' }}">
                            {{ $serviceLabels[$service] }}
                        </span>
                    @endforeach
                </div>
                
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($sitter['rating']))
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/>
                                </svg>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-text">{{ number_format($sitter['rating'], 1) }} ({{ $sitter['reviews_count'] }})</span>
                </div>
                
                <p class="sitter-bio">{{ $sitter['bio'] }}</p>
                
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>{{ $sitter['bookings_count'] }} bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>{{ $sitter['experience_years'] }}+ years</span>
                    </div>
                </div>
                
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp {{ number_format($sitter['price_per_day'], 0, ',', '.') }}<span>/day</span></h4>
                </div>
            </div>
            
            <div class="sitter-card-footer">
                <a href="{{ url('/sitter/' . $sitter['id']) }}" class="btn-view-profile">View Profile</a>
                <a href="{{ url('/booking/create/' . $sitter['id']) }}" class="btn-book-now">Book Now</a>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="8" stroke="#E0E0E0" stroke-width="2"/>
                    <path d="M21 21l-4.35-4.35" stroke="#E0E0E0" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h3 class="empty-title">No sitters found</h3>
            <p class="empty-desc">Try adjusting your filters or <a href="{{ url('/find-sitter') }}" class="empty-link">browse all sitters</a></p>
        </div>
        @endforelse
    </div>

</div>
@endsection

@section('js')
<script src="{{asset('js/nav.js')}}"></script>
<script src="{{asset('js/find-sitter.js')}}"></script>
@endsection
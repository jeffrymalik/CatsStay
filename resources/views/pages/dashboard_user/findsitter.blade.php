@extends('layout.main')

@section('title', 'Find Sitter - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/find-sitter.css')}}">
@endsection

@section('content')
<div class="find-sitter-container">
    {{-- Header Section --}}
    <div class="header-section">
        <div class="header-content">
            <h1 class="page-title">Find Your Perfect Cat Sitter</h1>
            <p class="page-subtitle">Browse through our trusted and verified cat sitters in your area</p>
        </div>
    </div>

    {{-- Search & Filter Section --}}
    <div class="search-filter-section">
        <div class="search-bar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="8" stroke="#999" stroke-width="2"/>
                <path d="M21 21l-4.35-4.35" stroke="#999" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Search by name, location, or experience..." class="search-input">
        </div>

        <button class="filter-btn" id="filterBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="4" y1="6" x2="20" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <line x1="4" y1="18" x2="20" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <circle cx="8" cy="6" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
                <circle cx="16" cy="12" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
                <circle cx="12" cy="18" r="2" fill="white" stroke="currentColor" stroke-width="2"/>
            </svg>
            Filters
            <span class="filter-badge" id="filterBadge" style="display: none;">0</span>
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
                        <input type="checkbox" value="cat-sitting" class="service-checkbox">
                        <span>🏠 Cat Sitting</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="grooming" class="service-checkbox">
                        <span>✂️ Grooming</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="home-visit" class="service-checkbox">
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
                            <div class="stars">
                                ⭐⭐⭐⭐⭐
                            </div>
                            <span>5.0</span>
                        </label>
                    </div>
                    <div class="rating-option">
                        <input type="radio" name="rating" id="rating4" value="4">
                        <label for="rating4">
                            <div class="stars">
                                ⭐⭐⭐⭐
                            </div>
                            <span>4.0+</span>
                        </label>
                    </div>
                    <div class="rating-option">
                        <input type="radio" name="rating" id="rating3" value="3">
                        <label for="rating3">
                            <div class="stars">
                                ⭐⭐⭐
                            </div>
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
                        <input type="checkbox" value="1" class="experience-checkbox">
                        <span>1+ years</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="2" class="experience-checkbox">
                        <span>2+ years</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="3" class="experience-checkbox">
                        <span>3+ years</span>
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" value="5" class="experience-checkbox">
                        <span>5+ years</span>
                    </label>
                </div>
            </div>

            {{-- Verified Only --}}
            <div class="filter-group">
                <label class="checkbox-label verified-only-label">
                    <input type="checkbox" id="verifiedOnly">
                    <span>Verified Sitters Only</span>
                </label>
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn-clear-filter" id="clearFilterBtn">Clear All</button>
            <button class="btn-apply-filter" id="applyFilterBtn">Apply Filters</button>
        </div>
    </div>

    {{-- Results Info --}}
    <div class="results-info">
        <p class="results-count">
            Showing <span id="resultCount">12</span> sitters
        </p>
        <div class="sort-dropdown">
            <label for="sortBy">Sort by:</label>
            <select id="sortBy" class="sort-select">
                <option value="recommended">Recommended</option>
                <option value="rating">Highest Rating</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="experience">Most Experience</option>
                <option value="reviews">Most Reviews</option>
            </select>
        </div>
    </div>

    {{-- Sitters Grid --}}
    <div class="sitters-grid" id="sittersGrid">
        
        {{-- Sitter Card 1 --}}
        <div class="sitter-card" data-location="jakarta-selatan" data-price="75000" data-rating="4.9" data-experience="5" data-verified="true" data-services="cat-sitting,grooming,home-visit">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&size=200&background=FFA726&color=fff" alt="Sarah Johnson" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Sarah Johnson</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Selatan
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.9 (45)</span>
                </div>

                {{-- Services Offered --}}
                <div class="sitter-services">
                    <span class="service-tag cat-sitting">🏠 Cat Sitting</span>
                    <span class="service-tag grooming">✂️ Grooming</span>
                    <span class="service-tag home-visit">🏡 Home Visit</span>
                </div>

                <p class="sitter-bio">Experienced cat lover with 5 years of professional pet sitting. I treat every cat like my own.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>87 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>5+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 75.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 2 --}}
        <div class="sitter-card" data-location="jakarta-pusat" data-price="95000" data-rating="5.0" data-experience="7" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Michael+Chen&size=200&background=4CAF50&color=fff" alt="Michael Chen" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Michael Chen</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Pusat
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">5.0 (68)</span>
                </div>
                <p class="sitter-bio">Certified animal care specialist. Your cats will be in safe hands with daily updates and photos.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>120 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>7+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 95.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 3 --}}
        <div class="sitter-card" data-location="tangerang" data-price="60000" data-rating="4.7" data-experience="3" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Amanda+Putri&size=200&background=9C27B0&color=fff" alt="Amanda Putri" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="3">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Amanda Putri</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Tangerang
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.7 (28)</span>
                </div>
                <p class="sitter-bio">Passionate about cats since childhood. I provide a loving home environment for your furry friends.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>42 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>3+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 60.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 4 --}}
        <div class="sitter-card" data-location="bekasi" data-price="80000" data-rating="4.8" data-experience="4" data-verified="false">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=David+Tan&size=200&background=2196F3&color=fff" alt="David Tan" class="sitter-card-avatar">
                <button class="favorite-btn" data-sitter-id="4">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">David Tan</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Bekasi
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.8 (35)</span>
                </div>
                <p class="sitter-bio">Reliable and trustworthy cat sitter. I have experience with all cat breeds and special needs.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>65 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>4+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 80.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 5 --}}
        <div class="sitter-card" data-location="depok" data-price="100000" data-rating="4.9" data-experience="6" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Jessica+Wong&size=200&background=FF5722&color=fff" alt="Jessica Wong" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="5">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Jessica Wong</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Depok
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.9 (52)</span>
                </div>
                <p class="sitter-bio">Former veterinary assistant with deep understanding of cat behavior and health needs.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>95 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>6+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 100.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 6 --}}
        <div class="sitter-card" data-location="jakarta-selatan" data-price="70000" data-rating="4.6" data-experience="2" data-verified="false">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Ryan+Pratama&size=200&background=00BCD4&color=fff" alt="Ryan Pratama" class="sitter-card-avatar">
                <button class="favorite-btn" data-sitter-id="6">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Ryan Pratama</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Selatan
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.6 (18)</span>
                </div>
                <p class="sitter-bio">Cat enthusiast who provides 24/7 care and attention. Your cats will never feel lonely!</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>30 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>2+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 70.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 7 --}}
        <div class="sitter-card" data-location="jakarta-barat" data-price="85000" data-rating="4.8" data-experience="5" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Lisa+Anderson&size=200&background=E91E63&color=fff" alt="Lisa Anderson" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="7">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Lisa Anderson</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Barat
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.8 (41)</span>
                </div>
                <p class="sitter-bio">Professional pet sitter specializing in cats. I offer grooming services as well.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>78 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>5+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 85.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 8 --}}
        <div class="sitter-card" data-location="bogor" data-price="65000" data-rating="4.7" data-experience="3" data-verified="false">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Tommy+Wijaya&size=200&background=3F51B5&color=fff" alt="Tommy Wijaya" class="sitter-card-avatar">
                <button class="favorite-btn" data-sitter-id="8">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Tommy Wijaya</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Bogor
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.7 (25)</span>
                </div>
                <p class="sitter-bio">Gentle and patient with all cats. I have a spacious home with safe outdoor area.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>48 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>3+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 65.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 9 --}}
        <div class="sitter-card" data-location="jakarta-timur" data-price="90000" data-rating="5.0" data-experience="8" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Emma+Rodriguez&size=200&background=FF9800&color=fff" alt="Emma Rodriguez" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="9">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Emma Rodriguez</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Timur
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">5.0 (62)</span>
                </div>
                <p class="sitter-bio">Experienced with senior cats and those with medical needs. Daily health monitoring included.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>110 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>8+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 90.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 10 --}}
        <div class="sitter-card" data-location="jakarta-utara" data-price="72000" data-rating="4.8" data-experience="4" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Daniel+Kim&size=200&background=8BC34A&color=fff" alt="Daniel Kim" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="10">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Daniel Kim</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Jakarta Utara
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.8 (32)</span>
                </div>
                <p class="sitter-bio">Friendly and responsible cat lover. I send daily photos and videos to keep you updated.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>58 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>4+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 72.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 11 --}}
        <div class="sitter-card" data-location="tangerang" data-price="88000" data-rating="4.9" data-experience="6" data-verified="true">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Sophia+Martinez&size=200&background=FFEB3B&color=333" alt="Sophia Martinez" class="sitter-card-avatar">
                <div class="verified-badge-top">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Verified
                </div>
                <button class="favorite-btn" data-sitter-id="11">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Sophia Martinez</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Tangerang
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.9 (48)</span>
                </div>
                <p class="sitter-bio">Cat behavior specialist who understands feline psychology. Perfect for anxious cats.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>92 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>6+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 88.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

        {{-- Sitter Card 12 --}}
        <div class="sitter-card" data-location="bekasi" data-price="68000" data-rating="4.6" data-experience="2" data-verified="false">
            <div class="sitter-card-header">
                <img src="https://ui-avatars.com/api/?name=Kevin+Susanto&size=200&background=795548&color=fff" alt="Kevin Susanto" class="sitter-card-avatar">
                <button class="favorite-btn" data-sitter-id="12">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="sitter-card-body">
                <h3 class="sitter-card-name">Kevin Susanto</h3>
                <p class="sitter-card-location">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                        <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                    </svg>
                    Bekasi
                </p>
                <div class="sitter-card-rating">
                    <div class="rating-stars">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFA726" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="#E0E0E0" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L22 9L17 14L18 21L12 18L6 21L7 14L2 9L9 8L12 2Z"/></svg>
                    </div>
                    <span class="rating-text">4.6 (20)</span>
                </div>
                <p class="sitter-bio">Reliable and punctual cat sitter. I follow your instructions carefully and maintain routines.</p>
                <div class="sitter-card-stats">
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                        </svg>
                        <span>35 bookings</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>2+ years</span>
                    </div>
                </div>
                <div class="sitter-card-price">
                    <span class="price-label">Starting from</span>
                    <h4 class="price-amount">Rp 68.000<span>/day</span></h4>
                </div>
            </div>
            <div class="sitter-card-footer">
                <a href="#" class="btn-view-profile">View Profile</a>
                <a href="#" class="btn-book-now">Book Now</a>
            </div>
        </div>

    </div>

</div>
@endsection

@section('js')
<script src="{{asset('js/nav.js')}}"></script>
<script src="{{asset('js/find-sitter.js')}}"></script>
@endsection
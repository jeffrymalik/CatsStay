@extends('layout.main')

@section('title', $sitter['name'] . ' - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sitter-profile.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="profile-hero">
        <div class="container">
            <div class="hero-content">
                <!-- Left: Avatar & Basic Info -->
                <div class="hero-left">
                    <div class="avatar-wrapper">
                        <img src="{{ $sitter['avatar'] }}" alt="{{ $sitter['name'] }}" class="sitter-avatar">
                        @if($sitter['verified'])
                        <div class="verified-badge">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        @endif
                    </div>
                    
                    <div class="sitter-basic-info">
                        <h1 class="sitter-name">{{ $sitter['name'] }}</h1>
                        
                        <div class="location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $sitter['location'] }}</span>
                        </div>

                        <div class="rating-wrapper">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($sitter['rating']))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $sitter['rating'])
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text">{{ $sitter['rating'] }} ({{ $sitter['reviews_count'] }} reviews)</span>
                        </div>

                        <div class="stats-grid">
                            <div class="stat-item">
                                <i class="fas fa-calendar-check"></i>
                                <div>
                                    <span class="stat-value">{{ $sitter['bookings_count'] }}</span>
                                    <span class="stat-label">Bookings</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <div>
                                    <span class="stat-value">{{ $sitter['experience_years'] }} years</span>
                                    <span class="stat-label">Experience</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-reply"></i>
                                <div>
                                    <span class="stat-value">{{ $sitter['response_time'] }}</span>
                                    <span class="stat-label">Response time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: CTA Actions -->
                <div class="hero-right">
                    <div class="cta-card">
                        <h3>Book {{ $sitter['name'] }}</h3>
                        <p class="price-range">Starting from <span class="price">Rp {{ number_format(collect($sitter['services'])->min('price'), 0, ',', '.') }}</span></p>
                        
                        <a href="{{ route('booking.create', $sitter['id']) }}" class="btn-book-now">
                            <i class="fas fa-calendar-check"></i>
                            Book Now
                        </a>
                        
                        <button class="btn-message">
                            <i class="fas fa-comment-dots"></i>
                            Send Message
                        </button>

                        <div class="contact-info">
                            <p><i class="fas fa-shield-alt"></i> Payment protection included</p>
                            <p><i class="fas fa-undo"></i> Free cancellation available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services & Pricing Section -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title">
                <i class="fas fa-th-large"></i>
                Services & Pricing
            </h2>
            
            <div class="services-grid">
                @foreach($sitter['services'] as $service)
                <div class="service-card">
                    <div class="service-icon">
                        @if($service['type'] == 'cat-sitting')
                            <i class="fas fa-home"></i>
                        @elseif($service['type'] == 'grooming')
                            <i class="fas fa-cut"></i>
                        @elseif($service['type'] == 'home-visit')
                            <i class="fas fa-walking"></i>
                        @endif
                    </div>
                    
                    <div class="service-content">
                        <h3 class="service-name">{{ $service['name'] }}</h3>
                        <p class="service-description">{{ $service['description'] }}</p>
                        <p class="service-price">Rp {{ number_format($service['price'], 0, ',', '.') }} <span>/day</span></p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <h2 class="section-title">
                <i class="fas fa-user"></i>
                About {{ $sitter['name'] }}
            </h2>
            
            <div class="about-content">
                <p class="bio-text">{{ $sitter['bio'] }}</p>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="section-title">
                <i class="fas fa-images"></i>
                Photo Gallery
            </h2>
            
            <div class="gallery-grid">
                @foreach($sitter['gallery'] as $index => $photo)
                <div class="gallery-item" onclick="openLightbox({{ $index }})">
                    <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo {{ $index + 1 }}">
                    <div class="gallery-overlay">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section">
        <div class="container">
            <h2 class="section-title">
                <i class="fas fa-star"></i>
                Reviews ({{ $sitter['reviews_count'] }})
            </h2>

            <div class="reviews-summary">
                <div class="summary-rating">
                    <span class="big-rating">{{ $sitter['rating'] }}</span>
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($sitter['rating']))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $sitter['rating'])
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="total-reviews">Based on {{ $sitter['reviews_count'] }} reviews</p>
                </div>
            </div>

            <div class="reviews-list">
                @foreach($sitter['reviews'] as $review)
                <div class="review-card">
                    <div class="review-header">
                        <img src="{{ $review['avatar'] }}" alt="{{ $review['user'] }}" class="reviewer-avatar">
                        <div class="reviewer-info">
                            <h4 class="reviewer-name">{{ $review['user'] }}</h4>
                            <div class="review-meta">
                                <div class="stars small">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review['rating'])
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="review-date">{{ $review['date'] }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="review-comment">{{ $review['comment'] }}</p>
                </div>
                @endforeach
            </div>

            <button class="btn-load-more">
                Load More Reviews
            </button>
        </div>
    </section>

    <!-- Back to Find Sitter -->
    <div class="back-to-findsitter">
        <div class="container">
            <a href="{{ url('/find-sitter') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Find Sitter</span>
            </a>
        </div>
    </div>

    <!-- Lightbox for Gallery (Simple overlay) -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Gallery image">
        <div class="lightbox-nav">
            <button class="lightbox-prev" onclick="event.stopPropagation(); changeLightboxImage(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-next" onclick="event.stopPropagation(); changeLightboxImage(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

@endsection

@section('js')
<script src="{{ asset('js/sitter-profile.js') }}"></script>
@endsection
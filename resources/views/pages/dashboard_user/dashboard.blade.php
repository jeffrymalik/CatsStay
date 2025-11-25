@extends('layout.main')

@section('title', 'Dashboard - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection

@section('content')
<div class="dashboard-container">
    {{-- Welcome Section --}}
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="welcome-subtitle">Here's what's happening with your bookings today.</p>
        </div>
        <div class="welcome-date">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                <line x1="3" y1="10" x2="21" y2="10" stroke="#FFA726" stroke-width="2"/>
            </svg>
            <span>{{ date('l, F j, Y') }}</span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        {{-- Total Bookings --}}
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="white" stroke-width="2"/>
                    <line x1="16" y1="2" x2="16" y2="6" stroke="white" stroke-width="2"/>
                    <line x1="8" y1="2" x2="8" y2="6" stroke="white" stroke-width="2"/>
                    <line x1="3" y1="10" x2="21" y2="10" stroke="white" stroke-width="2"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Total Bookings</p>
                <h3 class="stat-value">{{ $totalBookings ?? 0 }}</h3>
                <span class="stat-trend up">+12% from last month</span>
            </div>
        </div>

        {{-- Active Bookings --}}
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/>
                    <path d="M12 6v6l4 2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Active Bookings</p>
                <h3 class="stat-value">{{ $activeBookings ?? 0 }}</h3>
                <span class="stat-trend">Currently ongoing</span>
            </div>
        </div>

        {{-- Completed Bookings --}}
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Completed Bookings</p>
                <h3 class="stat-value">{{ $completedBookings ?? 0 }}</h3>
                <span class="stat-trend">Successfully completed</span>
            </div>
        </div>

        {{-- My Cats --}}
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2c-1.5 0-2.7 1.2-2.7 2.7 0 .8.3 1.5.8 2-.8.3-1.5.9-1.9 1.7-.5-.3-1-.4-1.6-.4C5.1 8 4 9.1 4 10.6c0 1 .5 1.8 1.3 2.3v3.4c0 2.2 1.8 4 4 4h5.3c2.2 0 4-1.8 4-4v-3.4c.8-.5 1.3-1.3 1.3-2.3 0-1.5-1.1-2.6-2.6-2.6-.6 0-1.1.1-1.6.4-.4-.8-1.1-1.4-1.9-1.7.5-.5.8-1.2.8-2C14.7 3.2 13.5 2 12 2z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="10" cy="12" r="0.5" fill="white"/>
                    <circle cx="14" cy="12" r="0.5" fill="white"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">My Cats</p>
                <h3 class="stat-value">{{ $myCats ?? 0 }}</h3>
                <span class="stat-trend">Registered cats</span>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="quick-actions-section">
        <h2 class="section-title">Quick Actions</h2>
        <div class="quick-actions-grid">
            <a href="{{ url('/find-sitter') }}" class="action-card">
                <div class="action-icon orange">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                        <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="action-title">Find Sitter</h3>
                <p class="action-desc">Browse trusted cat sitters</p>
            </a>

            {{-- UPDATED: New Booking now redirects to Select Service --}}
            <a href="{{ url('/select-service') }}" class="action-card">
                <div class="action-icon green">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke="white" stroke-width="2"/>
                        <line x1="16" y1="2" x2="16" y2="6" stroke="white" stroke-width="2"/>
                        <line x1="8" y1="2" x2="8" y2="6" stroke="white" stroke-width="2"/>
                        <line x1="3" y1="10" x2="21" y2="10" stroke="white" stroke-width="2"/>
                        <line x1="12" y1="14" x2="12" y2="18" stroke="white" stroke-width="2"/>
                        <line x1="10" y1="16" x2="14" y2="16" stroke="white" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="action-title">New Booking</h3>
                <p class="action-desc">Create a new request</p>
            </a>

            <a href="{{ url('/my-cats') }}" class="action-card">
                <div class="action-icon purple">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2c-1.5 0-2.7 1.2-2.7 2.7 0 .8.3 1.5.8 2-.8.3-1.5.9-1.9 1.7-.5-.3-1-.4-1.6-.4C5.1 8 4 9.1 4 10.6c0 1 .5 1.8 1.3 2.3v3.4c0 2.2 1.8 4 4 4h5.3c2.2 0 4-1.8 4-4v-3.4c.8-.5 1.3-1.3 1.3-2.3 0-1.5-1.1-2.6-2.6-2.6-.6 0-1.1.1-1.6.4-.4-.8-1.1-1.4-1.9-1.7.5-.5.8-1.2.8-2C14.7 3.2 13.5 2 12 2z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="12" r="0.5" fill="white"/>
                        <circle cx="14" cy="12" r="0.5" fill="white"/>
                    </svg>
                </div>
                <h3 class="action-title">Manage My Cats</h3>
                <p class="action-desc">View and edit cat profiles</p>
            </a>

            <a href="{{ url('/my-request') }}" class="action-card">
                <div class="action-icon blue">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="white" stroke-width="2"/>
                        <polyline points="14 2 14 8 20 8" stroke="white" stroke-width="2"/>
                        <line x1="16" y1="13" x2="8" y2="13" stroke="white" stroke-width="2"/>
                        <line x1="16" y1="17" x2="8" y2="17" stroke="white" stroke-width="2"/>
                        <line x1="10" y1="9" x2="8" y2="9" stroke="white" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="action-title">View All Bookings</h3>
                <p class="action-desc">See all your bookings</p>
            </a>
        </div>
    </div>

    {{-- Upcoming Requests --}}
    <div class="upcoming-section">
        <div class="section-header">
            <h2 class="section-title">Upcoming Requests</h2>
            <a href="{{ url('/my-request') }}" class="view-all-link">View All →</a>
        </div>

        @if(isset($upcomingBookings) && count($upcomingBookings) > 0)
            {{-- If there are bookings --}}
            <div class="bookings-list">
                @foreach($upcomingBookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-date">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                                <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                                <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                                <line x1="3" y1="10" x2="21" y2="10" stroke="#FFA726" stroke-width="2"/>
                            </svg>
                            <span>{{ $booking->start_date }} - {{ $booking->end_date }}</span>
                        </div>
                        <span class="booking-status {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    </div>
                    <div class="booking-content">
                        <div class="sitter-info">
                            <img src="{{ $booking->sitter_photo }}" alt="{{ $booking->sitter_name }}" class="sitter-avatar">
                            <div>
                                <h4 class="sitter-name">{{ $booking->sitter_name }}</h4>
                                <p class="sitter-location">📍 {{ $booking->location }}</p>
                            </div>
                        </div>
                        <div class="booking-price">
                            <span class="price-label">Total Price</span>
                            <h4 class="price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="booking-actions">
                        <a href="{{ url('/my-request/' . $booking->id) }}" class="btn-view">View Details</a>
                        <a href="{{ url('/messages?sitter=' . $booking->sitter_id) }}" class="btn-message">Message Sitter</a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke="#E0E0E0" stroke-width="2"/>
                        <line x1="16" y1="2" x2="16" y2="6" stroke="#E0E0E0" stroke-width="2"/>
                        <line x1="8" y1="2" x2="8" y2="6" stroke="#E0E0E0" stroke-width="2"/>
                        <line x1="3" y1="10" x2="21" y2="10" stroke="#E0E0E0" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="empty-title">No booking requests yet</h3>
                <p class="empty-desc">Start by finding a trusted cat sitter for your furry friend!</p>
                <a href="{{ url('/find-sitter') }}" class="btn-primary-large">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                        <path d="M21 21l-4.35-4.35" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Find a Sitter Now
                </a>
            </div>
        @endif
    </div>

    {{-- Recommended Sitters Section --}}
    <div class="recommended-section">
        <div class="section-header">
            <h2 class="section-title">Recommended Sitters</h2>
            <a href="{{ url('/find-sitter') }}" class="view-all-link">View All →</a>
        </div>

        @if(isset($recommendedSitters) && count($recommendedSitters) > 0)
            <div class="sitters-grid">
                @foreach($recommendedSitters as $sitter)
                <div class="sitter-card">
                    <div class="sitter-card-header">
                        <img src="{{ $sitter->photo ?? asset('images/default-avatar.png') }}" alt="{{ $sitter->name }}" class="sitter-card-avatar">
                        <div class="sitter-badge-top">
                            @if($sitter->is_verified)
                            <span class="verified-badge">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Verified
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="sitter-card-body">
                        <h3 class="sitter-card-name">{{ $sitter->name }}</h3>
                        <p class="sitter-card-location">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#666" stroke-width="2"/>
                                <circle cx="12" cy="10" r="3" stroke="#666" stroke-width="2"/>
                            </svg>
                            {{ $sitter->location }}
                        </p>
                        <div class="sitter-card-rating">
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($sitter->rating))
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
                            <span class="rating-text">{{ number_format($sitter->rating, 1) }} ({{ $sitter->reviews_count }} reviews)</span>
                        </div>
                        <div class="sitter-card-stats">
                            <div class="stat-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="#FFA726" stroke-width="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6" stroke="#FFA726" stroke-width="2"/>
                                    <line x1="8" y1="2" x2="8" y2="6" stroke="#FFA726" stroke-width="2"/>
                                </svg>
                                <span>{{ $sitter->completed_bookings }} bookings</span>
                            </div>
                            <div class="stat-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="#4CAF50" stroke-width="2"/>
                                    <path d="M12 6v6l4 2" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                <span>{{ $sitter->experience_years }}+ years exp</span>
                            </div>
                        </div>
                        <div class="sitter-card-price">
                            <span class="price-label">Starting from</span>
                            <h4 class="price-amount">Rp {{ number_format($sitter->price_per_day, 0, ',', '.') }}<span>/day</span></h4>
                        </div>
                    </div>
                    <div class="sitter-card-footer">
                        <a href="{{ url('/sitter/' . $sitter->id) }}" class="btn-view-profile">View Profile</a>
                        <a href="{{ url('/select-service?sitter=' . $sitter->id) }}" class="btn-book-now">Book Now</a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{-- Empty State for Recommended Sitters --}}
            <div class="empty-state-small">
                <div class="empty-icon-small">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11" cy="11" r="8" stroke="#E0E0E0" stroke-width="2"/>
                        <path d="M21 21l-4.35-4.35" stroke="#E0E0E0" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="empty-title-small">No recommendations yet</h3>
                <p class="empty-desc-small">Browse our sitters to find the perfect match for your cat!</p>
                <a href="{{ url('/find-sitter') }}" class="btn-secondary">Browse All Sitters</a>
            </div>
        @endif
    </div>
</div>
@endsection
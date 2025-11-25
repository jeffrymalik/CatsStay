@extends('layout.main')

@section('title', 'My Reviews - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <!-- Back Button -->
    <a href="{{ url('/dashboard') }}" class="back-button">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Dashboard
    </a>

    <div class="profile-wrapper">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <a href="{{ route('profile.index') }}" class="sidebar-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>My Profile</span>
            </a>
            <a href="{{ route('profile.address') }}" class="sidebar-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Address</span>
            </a>
            <a href="{{ route('profile.reviews') }}" class="sidebar-item active">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>My Reviews</span>
            </a>
            <a href="{{ route('profile.notifications') }}" class="sidebar-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Notifications</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="profile-content">
            <!-- Page Header -->
            <div class="profile-header">
                <h1>My Reviews</h1>
                <p>Reviews you've given to sitters from completed bookings</p>
            </div>

            @if(count($reviews) > 0)
                <!-- Reviews List -->
                @foreach($reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="sitter-info">
                            <div class="sitter-avatar">
                                {{ strtoupper(substr($review['sitter_name'], 0, 1)) }}
                            </div>
                            <div>
                                <h3>{{ $review['sitter_name'] }}</h3>
                                <p class="service-type">{{ $review['service_type'] }} • {{ $review['booking_code'] }}</p>
                            </div>
                        </div>
                        @if($review['can_edit'])
                        <button class="btn-edit-small">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Edit
                        </button>
                        @endif
                    </div>

                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review['rating'])
                                <svg class="star filled" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @else
                                <svg class="star empty" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            @endif
                        @endfor
                    </div>

                    <div class="review-text">
                        <p>{{ $review['review'] }}</p>
                    </div>

                    <div class="review-footer">
                        <span class="review-date">{{ $review['time_ago'] }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>No Reviews Yet</h3>
                    <p>You haven't left any reviews for sitters yet.</p>
                    <p>Complete a booking to leave your first review!</p>
                    <a href="{{ url('/find-sitter') }}" class="btn-primary">Find a Sitter</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
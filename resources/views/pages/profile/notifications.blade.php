@extends('layout.main')

@section('title', 'Notifications - Cats Stay')

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
            <a href="{{ route('profile.reviews') }}" class="sidebar-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>My Reviews</span>
            </a>
            <a href="{{ route('profile.notifications') }}" class="sidebar-item active">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Notifications</span>
                @if($unreadCount > 0)
                <span class="notif-count-badge">{{ $unreadCount }}</span>
                @endif
            </a>
        </div>

        <!-- Main Content -->
        <div class="profile-content">
            <!-- Page Header -->
            <div class="profile-header">
                <div>
                    <h1>Notifications</h1>
                    <p>Stay updated with your booking activities</p>
                </div>
                @if($unreadCount > 0)
                <button class="btn-mark-all-read">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Mark all as read
                </button>
                @endif
            </div>

            @if(count($notifications) > 0)
                <!-- Notifications List -->
                @foreach($notifications as $notification)
                <div class="notification-card {{ $notification['is_read'] ? 'read' : 'unread' }}">
                    <div class="notification-icon {{ $notification['type'] }}">
                        <i class="fas {{ $notification['icon'] }}"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h3>{{ $notification['title'] }}</h3>
                            <span class="notification-time">{{ $notification['time'] }}</span>
                        </div>
                        <p>{{ $notification['message'] }}</p>
                        @if($notification['link'])
                        <a href="{{ $notification['link'] }}" class="notification-action">View Details →</a>
                        @endif
                    </div>
                    @if(!$notification['is_read'])
                    <div class="unread-indicator"></div>
                    @endif
                </div>
                @endforeach

                <!-- Load More (if needed) -->
                <div class="load-more-section">
                    <button class="btn-load-more">Load More Notifications</button>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>No Notifications</h3>
                    <p>You're all caught up! No new notifications at the moment.</p>
                    <p>We'll notify you when there's something new.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/profile.js') }}"></script>
<script>
    // Mark notification as read
    document.querySelectorAll('.notification-card.unread').forEach(card => {
        card.addEventListener('click', function() {
            this.classList.remove('unread');
            this.classList.add('read');
            const indicator = this.querySelector('.unread-indicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
            // TODO: Send AJAX request to mark as read
        });
    });

    // Mark all as read
    const markAllBtn = document.querySelector('.btn-mark-all-read');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function() {
            document.querySelectorAll('.notification-card.unread').forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                const indicator = card.querySelector('.unread-indicator');
                if (indicator) {
                    indicator.style.display = 'none';
                }
            });
            this.style.display = 'none';
            // TODO: Send AJAX request to mark all as read
        });
    }
</script>
@endsection
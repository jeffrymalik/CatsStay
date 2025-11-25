@extends('layout.main')

@section('title', 'Address - Cats Stay')

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
            <a href="{{ route('profile.address') }}" class="sidebar-item active">
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
                <h1>Address</h1>
                <p>Manage your location details</p>
            </div>

            <!-- Address Card -->
            <div class="profile-card">
                <div class="card-header">
                    <h3>Address Information</h3>
                    <button class="btn-edit-small">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Edit
                    </button>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Country</label>
                        <p>{{ $address['country'] }}</p>
                    </div>
                    <div class="info-item">
                        <label>City/State</label>
                        <p>{{ $address['city'] }}</p>
                    </div>
                    <div class="info-item">
                        <label>Postal Code</label>
                        <p>{{ $address['postal_code'] }}</p>
                    </div>
                    <div class="info-item">
                        <label>Province</label>
                        <p>{{ $address['province'] }}</p>
                    </div>
                    <div class="info-item full-width">
                        <label>Full Address</label>
                        <p>{{ $address['full_address'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Map Preview Card (Optional - Placeholder) -->
            <div class="profile-card">
                <div class="card-header">
                    <h3>Location Preview</h3>
                </div>
                <div class="map-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p>Map integration coming soon</p>
                    <small>{{ $address['city'] }}, {{ $address['province'] }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection
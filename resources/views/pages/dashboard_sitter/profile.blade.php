@extends('layout.main')
@section('title', 'My Profile - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/profile.css')}}">
@endsection

@section('content')
<div class="profile-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-user-circle"></i> My Profile</h1>
            <p>Manage your profile information and portfolio</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button class="close-alert" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button class="close-alert" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Profile Content -->
    <div class="profile-content">
        
        <!-- Left Column: Avatar & Gallery -->
        <div class="left-column">
            
            <!-- Avatar Section -->
            <div class="avatar-section">
                <h3><i class="fas fa-camera"></i> Profile Photo</h3>
                <div class="avatar-upload">
                    <div class="avatar-preview">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                        @if($profile->is_verified)
                        <div class="verified-badge">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        @endif
                    </div>
                    <form id="avatarForm" method="POST" action="{{ route('pet-sitter.profile.upload-avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="previewAvatar(this)" style="display: none;">
                        <button type="button" class="btn-upload" onclick="document.getElementById('avatarInput').click()">
                            <i class="fas fa-upload"></i> Change Photo
                        </button>
                    </form>
                    <small>JPG, PNG. Max 2MB</small>
                </div>
            </div>

            <!-- Photo Gallery Section -->
            <div class="gallery-section">
                <div class="gallery-header">
                    <h3><i class="fas fa-images"></i> Photo Gallery</h3>
                    <button class="btn-add-photos" onclick="document.getElementById('galleryInput').click()">
                        <i class="fas fa-plus"></i> Add Photos
                    </button>
                </div>
                
                <form id="galleryForm" method="POST" action="{{ route('pet-sitter.profile.upload-gallery') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photos[]" id="galleryInput" accept="image/*" multiple style="display: none;" onchange="uploadGalleryPhotos(this)">
                </form>

                <div class="gallery-grid">
                    @if($profile->home_photos && count($profile->home_photos) > 0)
                        @foreach($profile->home_photos as $index => $photo)
                        <div class="gallery-item">
                            <img src="{{ asset('storage/' . $photo) }}" alt="Gallery photo">
                            <button class="btn-delete-photo" onclick="deletePhoto(this, {{ $index }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                        <div class="gallery-empty">
                            <i class="fas fa-images"></i>
                            <p>No photos yet</p>
                            <small>Add photos to showcase your workspace</small>
                        </div>
                    @endif
                </div>
                <small class="gallery-hint">Upload photos of your workspace, past clients' cats, or yourself with cats</small>
            </div>

        </div>

        <!-- Right Column: Profile Form -->
        <div class="right-column">
            
            <form id="profileForm" method="POST" action="{{ route('pet-sitter.profile.update') }}">
                @csrf
                
                <!-- Basic Information -->
                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Basic Information</h3>
                    
                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" value="{{ $user->email }}" disabled>   
                            <small>Email cannot be changed</small>
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h3><i class="fas fa-map-marker-alt"></i> Location</h3>
                        <button type="button" class="btn-manage-addresses" onclick="window.location.href='{{ route('profile.address') }}'">
                            <i class="fas fa-cog"></i> Manage Addresses
                        </button>
                    </div>
                    
                    @if($addresses->count() > 0)
                        <div class="address-display">
                            @php
                                $primaryAddress = $addresses->where('is_primary', true)->first() ?? $addresses->first();
                            @endphp
                            <div class="current-address">
                                <div class="address-icon">
                                    <i class="fas {{ $primaryAddress->label === 'Home' ? 'fa-home' : ($primaryAddress->label === 'Office' ? 'fa-building' : 'fa-map-marker-alt') }}"></i>
                                </div>
                                <div class="address-details">
                                    <strong>{{ $primaryAddress->label }}</strong>
                                    @if($primaryAddress->is_primary)
                                        <span class="primary-badge">Primary</span>
                                    @endif
                                    <p>{{ $primaryAddress->full_address }}</p>
                                    <small>{{ $primaryAddress->city }}, {{ $primaryAddress->province }} {{ $primaryAddress->postal_code }}</small>
                                </div>
                            </div>
                            @if($addresses->count() > 1)
                                <small class="address-note">
                                    <i class="fas fa-info-circle"></i> 
                                    You have {{ $addresses->count() }} saved addresses. Primary address will be shown to clients.
                                </small>
                            @endif
                        </div>
                    @else
                        <div class="address-empty">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>No address added yet</p>
                            <button type="button" class="btn-add-address" onclick="window.location.href='{{ route('profile.address') }}'">
                                <i class="fas fa-plus"></i> Add Your Address
                            </button>
                        </div>
                    @endif
                </div>

                <!-- About Me -->
                <div class="form-section">
                    <h3><i class="fas fa-align-left"></i> About Me</h3>
                    
                    <div class="form-group">
                        <label>Bio / Description <span class="required">*</span></label>
                        <textarea name="bio" maxlength="1000" required>{{ old('bio', $user->bio) }}</textarea>
                        <small>Tell clients about yourself, your experience, and why you love cats (max 1000 characters)</small>
                    </div>
                </div>

                <!-- Experience & Availability -->
                <div class="form-section">
                    <h3><i class="fas fa-briefcase"></i> Experience & Availability</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Years of Experience <span class="required">*</span></label>
                            <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $profile->years_of_experience) }}" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Response Time <span class="required">*</span></label>
                            <select name="response_time" required>
                                <option value="< 1 hour" {{ old('response_time', $profile->response_time) == '< 1 hour' ? 'selected' : '' }}>Less than 1 hour</option>
                                <option value="< 2 hours" {{ old('response_time', $profile->response_time) == '< 2 hours' ? 'selected' : '' }}>Less than 2 hours</option>
                                <option value="< 6 hours" {{ old('response_time', $profile->response_time) == '< 6 hours' ? 'selected' : '' }}>Less than 6 hours</option>
                                <option value="< 24 hours" {{ old('response_time', $profile->response_time) == '< 24 hours' ? 'selected' : '' }}>Within 24 hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Max Cats Accepted <span class="required">*</span></label>
                            <input type="number" name="max_cats_accepted" value="{{ old('max_cats_accepted', $profile->max_cats_accepted) }}" min="1" required>
                            <small>Maximum number of cats you can care for at once</small>
                        </div>
                        <div class="form-group">
                            <label>Availability Status <span class="required">*</span></label>
                            <select name="is_available" required>
                                <option value="1" {{ old('is_available', $profile->is_available) == 1 ? 'selected' : '' }}>
                                    🟢 Active - Available for bookings
                                </option>
                                <option value="0" {{ old('is_available', $profile->is_available) == 0 ? 'selected' : '' }}>
                                    🔴 Inactive - Not accepting bookings
                                </option>
                            </select>
                            <small>Set to inactive when you're temporarily unavailable</small>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="form-section">
                    <h3><i class="fas fa-info-circle"></i> Additional Information</h3>
                    
                    <div class="form-group">
                        <label>Home Description</label>
                        <textarea name="home_description" maxlength="1000" placeholder="Describe your home environment...">{{ old('home_description', $profile->home_description) }}</textarea>
                        <small>Tell clients about your home setup for cat care (max 1000 characters)</small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn-save-profile">
                        <i class="fas fa-save"></i> Save Profile
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection

@section('js')
<script src="{{asset('js/sitter/profile.js')}}"></script>
@endsection
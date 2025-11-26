@extends('layout.main')

@section('title', 'My Addresses - Cats Stay')

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
                <span>My Addresses</span>
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
                <div>
                    <h1>My Addresses</h1>
                    <p>Manage your saved addresses for booking services</p>
                </div>
                <button class="btn-add-address" id="btnAddAddress">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Add New Address
                </button>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if(count($addresses) > 0)
                <!-- Addresses List -->
                @foreach($addresses as $address)
                <div class="address-card" data-address-id="{{ $address['id'] }}">
                    <div class="address-card-header">
                        <div class="address-label-section">
                            <div class="address-icon">
                                <i class="fas {{ $address['icon'] }}"></i>
                            </div>
                            <div>
                                <h3 class="address-label">{{ $address['label'] }}</h3>
                                @if($address['is_primary'])
                                <span class="primary-badge">Primary</span>
                                @endif
                            </div>
                        </div>
                        <div class="address-actions">
                            @if(!$address['is_primary'])
                            <button class="btn-set-primary" data-address-id="{{ $address['id'] }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Set as Primary
                            </button>
                            @endif
                            <button class="btn-edit-address" data-address-id="{{ $address['id'] }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Edit
                            </button>
                            @if(!$address['is_primary'])
                            <button class="btn-delete-address" data-address-id="{{ $address['id'] }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Delete
                            </button>
                            @endif
                        </div>
                    </div>

                    <div class="address-details">
                        <div class="address-info-row">
                            <div class="address-info-item">
                                <span class="address-info-label">Full Address:</span>
                                <p class="address-info-value">{{ $address['full_address'] }}</p>
                            </div>
                        </div>

                        <div class="address-info-grid">
                            <div class="address-info-item">
                                <span class="address-info-label">City:</span>
                                <p class="address-info-value">{{ $address['city'] }}</p>
                            </div>
                            <div class="address-info-item">
                                <span class="address-info-label">Province:</span>
                                <p class="address-info-value">{{ $address['province'] }}</p>
                            </div>
                            <div class="address-info-item">
                                <span class="address-info-label">Postal Code:</span>
                                <p class="address-info-value">{{ $address['postal_code'] }}</p>
                            </div>
                            <div class="address-info-item">
                                <span class="address-info-label">Country:</span>
                                <p class="address-info-value">{{ $address['country'] }}</p>
                            </div>
                        </div>

                        <div class="address-map-link">
                            <a href="#" class="view-map-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                View on Map
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Info Box -->
                <div class="info-box">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <line x1="12" y1="16" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="8" r="0.5" fill="currentColor" stroke="currentColor"/>
                    </svg>
                    <div>
                        <p><strong>Primary Address</strong> will be used as default for booking services with pick-up.</p>
                        <p>You can set any address as primary by clicking "Set as Primary" button.</p>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>No Addresses Yet</h3>
                    <p>You haven't added any addresses yet.</p>
                    <p>Add your first address to use pick-up service when booking.</p>
                    <button class="btn-primary" onclick="document.getElementById('btnAddAddress').click()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Add Your First Address
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Add/Edit Address Modal -->
<div class="modal-overlay" id="addressModal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Add New Address</h2>
            <button class="btn-close-modal" id="btnCloseModal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <form id="addressForm">
            <input type="hidden" id="addressId" name="address_id">

            <div class="form-group">
                <label class="form-label">Address Label *</label>
                <select id="addressLabel" name="label" class="form-input" required>
                    <option value="">Choose label...</option>
                    <option value="Home">🏠 Home</option>
                    <option value="Office">🏢 Office</option>
                    <option value="Other">📍 Other</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Full Address *</label>
                <textarea id="fullAddress" name="full_address" class="form-input" rows="3" placeholder="Street address, building, apartment number..." required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">City *</label>
                    <input type="text" id="city" name="city" class="form-input" placeholder="e.g., Jakarta Barat" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Province *</label>
                    <input type="text" id="province" name="province" class="form-input" placeholder="e.g., DKI Jakarta" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Postal Code *</label>
                    <input type="text" id="postalCode" name="postal_code" class="form-input" placeholder="e.g., 11530" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Country *</label>
                    <input type="text" id="country" name="country" class="form-input" value="Indonesia" required>
                </div>
            </div>

            <div class="checkbox-wrapper">
                <input type="checkbox" id="setPrimary" name="set_primary">
                <span class="checkbox-label">Set as primary address</span>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnCancelModal">Cancel</button>
                <button type="submit" class="btn-save">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Save Address
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/profile.js') }}"></script>
<script src="{{ asset('js/profile-addresses.js') }}"></script>
@endsection
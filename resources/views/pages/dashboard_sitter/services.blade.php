@extends('layout.main')
@section('title', 'Service Management - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/services.css')}}">
@endsection

@section('content')
<div class="services-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-concierge-bell"></i> Service Management</h1>
            <p>Manage your services and pricing</p>
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

    <!-- Services List -->
    <div class="services-list">
        @foreach($services as $service)
        <div class="service-card {{ $service['is_enabled'] ? 'active' : 'disabled' }}">
            
            <!-- Card Header -->
            <div class="card-header">
                <div class="header-left">
                    <div class="service-icon {{ $service['slug'] }}">
                        <i class="{{ $service['icon'] }}"></i>
                    </div>
                    <div class="service-info">
                        <h3 class="service-name">{{ $service['name'] }}</h3>
                        <p class="service-short-desc">{{ $service['short_description'] }}</p>
                    </div>
                </div>
                
                <!-- Enable/Disable Toggle -->
                <div class="service-toggle">
                    <input type="checkbox" 
                           id="toggle-{{ $service['id'] }}" 
                           class="toggle-switch" 
                           {{ $service['is_enabled'] ? 'checked' : '' }}
                           onchange="toggleService({{ $service['id'] }}, this.checked)">
                    <label for="toggle-{{ $service['id'] }}" class="toggle-label">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-text">{{ $service['is_enabled'] ? 'Active' : 'Inactive' }}</span>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="stats-row">
                <div class="stat-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>{{ $service['total_bookings'] }} bookings</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <span>{{ $service['rating'] }} rating</span>
                </div>
            </div>

            <!-- Description Section -->
            <div class="description-section">
                <h4>Description</h4>
                <p class="description-text">{{ $service['description'] }}</p>
            </div>

            <!-- Edit Button -->
            <button class="btn-edit" onclick="editService(
    {{ $service['id'] }}, 
    '{{ $service['name'] }}', 
    '{{ $service['slug'] }}',
    `{{ $service['description'] }}`, 
    {{ $service['pricing']['base_price'] }}
)">>
                Edit Description
            </button>

            <!-- Pricing Section -->
            <div class="pricing-section">
                <h4>Pricing</h4>
                <div class="pricing-info">
                    <div class="price-item">
                        <span class="label">Base Price:</span>
                        <span class="value">Rp {{ number_format($service['pricing']['base_price'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>

<!-- Edit Service Modal -->
<div id="editServiceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit <span id="service-name-modal">Service</span></h3>
            <button class="close-modal" onclick="closeModal('editServiceModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editServiceForm" method="POST" action="{{ route('pet-sitter.services.update') }}">
            @csrf
            <input type="hidden" name="service_id" id="edit_service_id">
            <input type="hidden" name="action" value="update_service">
            
            <div class="modal-body">
                <!-- Description -->
                <div class="form-group">
                    <label>Service Description</label>
                    <textarea name="description" id="edit_description" rows="5" required></textarea>
                    <small>Describe what's included in your service</small>
                </div>

                <!-- Pricing -->
                <div class="form-row">
                    <div class="form-group">
                        <label>Base Price (Rp)</label>
                        <input type="number" name="base_price" id="edit_base_price" min="0" step="1000" required>
                    </div>

                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editServiceModal')">Cancel</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('js/sitter/services.js')}}"></script>
@endsection
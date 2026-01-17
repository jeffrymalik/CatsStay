@extends('layout.main')

@section('title', $cat->name . ' - My Cats')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my-cats.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="cat-detail-container">
    <div class="cat-detail-wrapper">
        
        {{-- Header with Actions --}}
        <div class="detail-header">
            <h1 class="detail-title">
                <i class="fas fa-paw"></i>
                Cat Profile
            </h1>
            <div class="detail-actions">
                <a href="{{ route('my-cats.edit', $cat->id) }}" class="btn-action-header btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
                <button onclick="confirmDelete({{ $cat->id }}, '{{ $cat->name }}')" class="btn-action-header btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    Delete
                </button>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="detail-content">
            
            {{-- Left: Photo & Basic Info --}}
            <div class="detail-left">
                <div class="detail-photo-card">
                    <img src="{{ $cat->photo_url }}" alt="{{ $cat->name }}" class="detail-photo">
                    <div class="detail-basic-info">
                        <h2 class="detail-name">{{ $cat->name }}</h2>
                        <p class="detail-breed">{{ $cat->breed ?? 'Mixed Breed' }}</p>
                        @if($cat->gender)
                        <div class="detail-gender-badge {{ strtolower($cat->gender) }}">
                            <i class="fas fa-{{ $cat->gender === 'male' ? 'mars' : 'venus' }}"></i>
                            {{ ucfirst($cat->gender) }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="quick-stats-card">
                    <h3 class="stats-title">Quick Stats</h3>
                    
                    @if($cat->age)
                    <div class="stat-item-detail">
                        <i class="fas fa-birthday-cake"></i>
                        <div>
                            <span class="stat-label">Age</span>
                            <span class="stat-value">{{ $cat->age }}</span>
                        </div>
                    </div>
                    @endif

                    @if($cat->weight)
                    <div class="stat-item-detail">
                        <i class="fas fa-weight"></i>
                        <div>
                            <span class="stat-label">Weight</span>
                            <span class="stat-value">{{ $cat->weight }} kg</span>
                        </div>
                    </div>
                    @endif

                    @if($cat->color)
                    <div class="stat-item-detail">
                        <i class="fas fa-palette"></i>
                        <div>
                            <span class="stat-label">Color</span>
                            <span class="stat-value">{{ $cat->color }}</span>
                        </div>
                    </div>
                    @endif

                    @if($cat->date_of_birth)
                    <div class="stat-item-detail">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <span class="stat-label">Birth Date</span>
                            <span class="stat-value">{{ $cat->date_of_birth->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right: Detailed Information --}}
            <div class="detail-right">
                
                {{-- Medical Information --}}
                @if($cat->medical_notes)
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-notes-medical"></i>
                        <h3>Medical Information</h3>
                    </div>
                    <div class="info-card-body">
                        <p>{{ $cat->medical_notes }}</p>
                    </div>
                </div>
                @endif

                {{-- Personality --}}
                @if($cat->personality_traits)
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-smile"></i>
                        <h3>Personality & Behavior</h3>
                    </div>
                    <div class="info-card-body">
                        <p>{{ $cat->personality_traits }}</p>
                    </div>
                </div>
                @endif

                {{-- Special Instructions --}}
                @if($cat->care_instructions)
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>Special Care Instructions</h3>
                    </div>
                    <div class="info-card-body">
                        <p>{{ $cat->care_instructions }}</p>
                    </div>
                </div>
                @endif

                {{-- Empty State if no additional info --}}
                @if(!$cat->medical_notes && !$cat->personality_traits && !$cat->care_instructions)
                <div class="info-card empty-info">
                    <div class="info-card-body text-center">
                        <i class="fas fa-info-circle" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
                        <p style="color: #999;">No additional information available.</p>
                        <a href="{{ route('my-cats.edit', $cat->id) }}" class="btn-edit" style="margin-top: 1rem; display: inline-block;">
                            <i class="fas fa-edit"></i> Add More Details
                        </a>
                    </div>
                </div>
                @endif

            </div>

        </div>

        {{-- Back Button --}}
        <div class="back-button-wrapper">
            <a href="{{ route('my-cats.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to My Cats</span>
            </a>
        </div>

    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Delete Cat Profile?</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong id="catNameToDelete"></strong>?</p>
            <p class="modal-warning">This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button onclick="closeDeleteModal()" class="btn-modal btn-cancel">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal btn-confirm-delete">
                    <i class="fas fa-trash-alt"></i>
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/my-cats.js') }}"></script>
@endsection
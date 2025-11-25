@extends('layout.main')

@section('title', 'My Cats - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my-cats.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="my-cats-container">
    <div class="my-cats-wrapper">
        
        {{-- Header --}}
        <div class="page-header">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-paw"></i>
                    My Cats
                </h1>
                <p class="page-subtitle">Manage your cat profiles for easier booking</p>
            </div>
            <div class="header-right">
                <a href="{{ route('my-cats.create') }}" class="btn-add-cat">
                    <i class="fas fa-plus-circle"></i>
                    Add New Cat
                </a>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        {{-- Cats Grid --}}
        @if(count($cats) > 0)
        <div class="cats-grid">
            @foreach($cats as $cat)
            <div class="cat-card">
                {{-- Cat Photo --}}
                <div class="cat-photo-wrapper">
                    <img src="{{ $cat['photo'] }}" alt="{{ $cat['name'] }}" class="cat-photo">
                    <div class="cat-photo-overlay">
                        <button class="btn-view" onclick="window.location.href='{{ route('my-cats.show', $cat['id']) }}'">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                    </div>
                </div>

                {{-- Cat Info --}}
                <div class="cat-info">
                    <div class="cat-header">
                        <h3 class="cat-name">{{ $cat['name'] }}</h3>
                        <span class="cat-gender {{ strtolower($cat['gender']) }}">
                            <i class="fas fa-{{ $cat['gender'] === 'Male' ? 'mars' : 'venus' }}"></i>
                        </span>
                    </div>

                    <div class="cat-details">
                        <p class="cat-breed">
                            <i class="fas fa-cat"></i>
                            {{ $cat['breed'] ?? 'Mixed Breed' }}
                        </p>
                        <p class="cat-age">
                            <i class="fas fa-birthday-cake"></i>
                            {{ $cat['age'] }}
                        </p>
                        @if(isset($cat['weight']))
                        <p class="cat-weight">
                            <i class="fas fa-weight"></i>
                            {{ $cat['weight'] }}
                        </p>
                        @endif
                    </div>

                    {{-- Quick Info Tags --}}
                    <div class="cat-tags">
                        @if(isset($cat['medical_notes']) && !empty($cat['medical_notes']))
                        <span class="tag tag-medical">
                            <i class="fas fa-notes-medical"></i>
                            Medical Notes
                        </span>
                        @endif
                        @if(isset($cat['special_instructions']) && !empty($cat['special_instructions']))
                        <span class="tag tag-special">
                            <i class="fas fa-star"></i>
                            Special Care
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="cat-actions">
                        <a href="{{ route('my-cats.edit', $cat['id']) }}" class="btn-action btn-edit">
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                        <button onclick="confirmDelete({{ $cat['id'] }}, '{{ $cat['name'] }}')" class="btn-action btn-delete">
                            <i class="fas fa-trash-alt"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Add Cat Card (Empty Slot) --}}
            @if(count($cats) < 10)
            <div class="cat-card add-cat-card">
                <a href="{{ route('my-cats.create') }}" class="add-cat-link">
                    <div class="add-cat-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="add-cat-text">Add Another Cat</h3>
                    <p class="add-cat-subtitle">You can add up to {{ 10 - count($cats) }} more cat(s)</p>
                </a>
            </div>
            @endif
        </div>

        @else
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-cat"></i>
            </div>
            <h2 class="empty-title">No Cats Yet</h2>
            <p class="empty-description">
                Add your first cat profile to make booking faster and easier!<br>
                Sitters will know exactly how to care for your beloved pet.
            </p>
            <a href="{{ route('my-cats.create') }}" class="btn-add-first-cat">
                <i class="fas fa-plus-circle"></i>
                Add Your First Cat
            </a>
        </div>
        @endif

        {{-- Info Box --}}
        <div class="info-box-cats">
            <i class="fas fa-info-circle"></i>
            <div class="info-content">
                <h4>Why add your cats?</h4>
                <p>Having cat profiles saved makes booking faster! When you book a sitter, you can quickly select from your registered cats instead of entering details every time.</p>
            </div>
        </div>

        {{-- Back to Dashboard --}}
        <div class="back-button-wrapper">
            <a href="{{ route('user.dashboard') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
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
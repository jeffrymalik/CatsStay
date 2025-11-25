@extends('layout.main')

@section('title', ($isEdit ? 'Edit' : 'Add') . ' Cat - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my-cats.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')

<div class="my-cats-form-container">
    <div class="form-wrapper">
        
        {{-- Header --}}
        <div class="form-header">
            <h1 class="form-title">
                <i class="fas fa-{{ $isEdit ? 'edit' : 'plus-circle' }}"></i>
                {{ $isEdit ? 'Edit' : 'Add New' }} Cat
            </h1>
            <p class="form-subtitle">{{ $isEdit ? 'Update your cat\'s information' : 'Tell us about your cat' }}</p>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <p><strong>Please fix the following errors:</strong></p>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ $isEdit ? route('my-cats.update', $cat['id']) : route('my-cats.store') }}" 
              method="POST" 
              id="catForm"
              enctype="multipart/form-data">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-content">
                
                {{-- Left Column: Photo & Basic Info --}}
                <div class="form-left">
                    
                    {{-- Photo Upload --}}
                    <div class="photo-upload-section">
                        <label class="section-label">Cat Photo</label>
                        <div class="photo-upload-wrapper">
                            <div class="photo-preview" id="photoPreview">
                                @if($isEdit && isset($cat['photo']))
                                <img src="{{ $cat['photo'] }}" alt="Cat photo" id="previewImage">
                                @else
                                <div class="photo-placeholder">
                                    <i class="fas fa-camera"></i>
                                    <p>No photo yet</p>
                                </div>
                                @endif
                            </div>
                            <div class="photo-upload-actions">
                                <label for="photoInput" class="btn-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Choose Photo
                                </label>
                                <input type="file" 
                                       id="photoInput" 
                                       name="photo" 
                                       accept="image/*"
                                       style="display: none;">
                                <button type="button" class="btn-remove-photo" id="removePhotoBtn" style="display: none;">
                                    <i class="fas fa-times"></i>
                                    Remove
                                </button>
                            </div>
                            <p class="photo-hint">Recommended: Square image, max 2MB</p>
                        </div>
                    </div>

                    {{-- Basic Information --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Basic Information
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-cat"></i>
                                Cat Name *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-input"
                                   placeholder="e.g., Luna"
                                   value="{{ old('name', $cat['name'] ?? '') }}"
                                   required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-paw"></i>
                                    Breed
                                </label>
                                <input type="text" 
                                       name="breed" 
                                       class="form-input"
                                       placeholder="e.g., Persian"
                                       value="{{ old('breed', $cat['breed'] ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Gender *
                                </label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select...</option>
                                    <option value="Male" {{ old('gender', $cat['gender'] ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $cat['gender'] ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar"></i>
                                    Birth Date *
                                </label>
                                <input type="date" 
                                       name="birth_date" 
                                       class="form-input"
                                       max="{{ date('Y-m-d') }}"
                                       value="{{ old('birth_date', $cat['birth_date'] ?? '') }}"
                                       required>
                                <span class="calculated-age" id="calculatedAge"></span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-weight"></i>
                                    Weight
                                </label>
                                <input type="text" 
                                       name="weight" 
                                       class="form-input"
                                       placeholder="e.g., 4.5 kg"
                                       value="{{ old('weight', $cat['weight'] ?? '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-palette"></i>
                                Color / Markings
                            </label>
                            <input type="text" 
                                   name="color" 
                                   class="form-input"
                                   placeholder="e.g., White with gray patches"
                                   value="{{ old('color', $cat['color'] ?? '') }}">
                        </div>
                    </div>
                </div>

                {{-- Right Column: Additional Info --}}
                <div class="form-right">
                    
                    {{-- Medical Information --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-notes-medical"></i>
                            Medical Information
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heartbeat"></i>
                                Medical Notes
                            </label>
                            <textarea name="medical_notes" 
                                      class="form-textarea"
                                      rows="4"
                                      maxlength="1000"
                                      placeholder="Vaccinations, allergies, medications, health conditions...">{{ old('medical_notes', $cat['medical_notes'] ?? '') }}</textarea>
                            <span class="char-count">
                                <span id="medicalCount">0</span>/1000 characters
                            </span>
                        </div>
                    </div>

                    {{-- Personality & Behavior --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-smile"></i>
                            Personality & Behavior
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heart"></i>
                                Personality Traits
                            </label>
                            <textarea name="personality" 
                                      class="form-textarea"
                                      rows="3"
                                      maxlength="500"
                                      placeholder="Is your cat shy, playful, energetic, calm...?">{{ old('personality', $cat['personality'] ?? '') }}</textarea>
                            <span class="char-count">
                                <span id="personalityCount">0</span>/500 characters
                            </span>
                        </div>
                    </div>

                    {{-- Special Instructions --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-clipboard-list"></i>
                            Special Instructions
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-star"></i>
                                Care Instructions
                            </label>
                            <textarea name="special_instructions" 
                                      class="form-textarea"
                                      rows="3"
                                      maxlength="500"
                                      placeholder="Feeding schedule, favorite toys, things to avoid...">{{ old('special_instructions', $cat['special_instructions'] ?? '') }}</textarea>
                            <span class="char-count">
                                <span id="instructionsCount">0</span>/500 characters
                            </span>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('my-cats.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-{{ $isEdit ? 'save' : 'plus' }}"></i>
                    {{ $isEdit ? 'Save Changes' : 'Add Cat' }}
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/my-cats.js') }}"></script>
@endsection
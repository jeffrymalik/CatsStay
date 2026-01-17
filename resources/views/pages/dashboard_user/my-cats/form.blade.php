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
        <form action="{{ $isEdit ? route('my-cats.update', $cat->id) : route('my-cats.store') }}" 
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
                                @if($isEdit && $cat->photo)
                                <img src="{{ asset('storage/' . $cat->photo) }}" alt="Cat photo" id="previewImage">
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
                                <button type="button" class="btn-remove-photo" id="removePhotoBtn" style="{{ ($isEdit && $cat->photo) ? '' : 'display: none;' }}">
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
                                   value="{{ old('name', $isEdit ? $cat->name : '') }}"
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
                                       value="{{ old('breed', $isEdit ? $cat->breed : '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Gender *
                                </label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select...</option>
                                    <option value="male" {{ old('gender', $isEdit ? $cat->gender : '') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $isEdit ? $cat->gender : '') === 'female' ? 'selected' : '' }}>Female</option>
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
                                       name="date_of_birth" 
                                       class="form-input"
                                       max="{{ date('Y-m-d') }}"
                                       value="{{ old('date_of_birth', $isEdit && $cat->date_of_birth ? $cat->date_of_birth->format('Y-m-d') : '') }}"
                                       required>
                                <span class="calculated-age" id="calculatedAge"></span>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-weight"></i>
                                    Weight (kg)
                                </label>
                                <input type="number" 
                                       name="weight" 
                                       class="form-input"
                                       placeholder="e.g., 4.5"
                                       step="0.1"
                                       min="0"
                                       max="50"
                                       value="{{ old('weight', $isEdit ? $cat->weight : '') }}">
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
                                   value="{{ old('color', $isEdit ? $cat->color : '') }}">
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
                                      placeholder="Vaccinations, allergies, medications, health conditions...">{{ old('medical_notes', $isEdit ? $cat->medical_notes : '') }}</textarea>
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
                            <textarea name="personality_traits" 
                                      class="form-textarea"
                                      rows="3"
                                      maxlength="500"
                                      placeholder="Is your cat shy, playful, energetic, calm...?">{{ old('personality_traits', $isEdit ? $cat->personality_traits : '') }}</textarea>
                            <span class="char-count">
                                <span id="personalityCount">0</span>/500 characters
                            </span>
                        </div>
                    </div>

                    {{-- Special Instructions --}}
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-clipboard-list"></i>
                            Care Instructions
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-star"></i>
                                Special Care Instructions
                            </label>
                            <textarea name="care_instructions" 
                                      class="form-textarea"
                                      rows="3"
                                      maxlength="500"
                                      placeholder="Feeding schedule, favorite toys, things to avoid...">{{ old('care_instructions', $isEdit ? $cat->care_instructions : '') }}</textarea>
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
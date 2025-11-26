// ===================================
// WRITE REVIEW - JavaScript
// Star rating, drag-drop upload, validation
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Write Review loaded');
    
    initializeStarRating();
    initializeTextArea();
    initializePhotoUpload();
    initializeFormValidation();
});

// ===================================
// STAR RATING (OUTLINED)
// ===================================

let selectedRating = 0;

function initializeStarRating() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');
    const ratingError = document.getElementById('ratingError');
    
    if (!stars.length) return;
    
    // Hover effect
    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', function() {
            highlightStars(index + 1);
        });
    });
    
    // Mouse leave - reset to selected or clear
    const starRating = document.getElementById('starRating');
    starRating.addEventListener('mouseleave', function() {
        if (selectedRating > 0) {
            highlightStars(selectedRating);
        } else {
            clearStars();
        }
    });
    
    // Click to select
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            selectedRating = index + 1;
            ratingInput.value = selectedRating;
            highlightStars(selectedRating);
            updateRatingText(selectedRating);
            
            // Hide error if shown
            ratingError.style.display = 'none';
            starRating.classList.remove('error');
        });
    });
}

function highlightStars(count) {
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        if (index < count) {
            star.classList.remove('far');
            star.classList.add('fas', 'hover');
        } else {
            star.classList.remove('fas', 'hover');
            star.classList.add('far');
        }
    });
}

function clearStars() {
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        star.classList.remove('fas', 'hover', 'selected');
        star.classList.add('far');
    });
}

function updateRatingText(rating) {
    const ratingText = document.getElementById('ratingText');
    const texts = {
        1: 'Poor',
        2: 'Fair',
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };
    
    ratingText.textContent = texts[rating] || 'Select rating';
    ratingText.classList.add('has-rating');
}

// ===================================
// TEXT AREA CHARACTER COUNT
// ===================================

function initializeTextArea() {
    const textarea = document.getElementById('reviewText');
    const charCount = document.getElementById('charCount');
    const charCounter = document.querySelector('.char-counter');
    const textError = document.getElementById('textError');
    
    if (!textarea) return;
    
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
        
        // Update counter style
        charCounter.classList.remove('warning', 'error');
        if (length > 500) {
            charCounter.classList.add('error');
        } else if (length > 450) {
            charCounter.classList.add('warning');
        }
        
        // Hide error if minimum met
        if (length >= 20) {
            textError.style.display = 'none';
            textarea.classList.remove('error');
        }
    });
}

// ===================================
// PHOTO UPLOAD (DRAG & DROP)
// ===================================

let uploadedPhotos = [];
const MAX_PHOTOS = 3;
const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

function initializePhotoUpload() {
    const dragDropZone = document.getElementById('dragDropZone');
    const photoInput = document.getElementById('photoInput');
    const photoPreviews = document.getElementById('photoPreviews');
    const photoCount = document.getElementById('photoCount');
    const photoError = document.getElementById('photoError');
    
    if (!dragDropZone) return;
    
    // Click to upload
    dragDropZone.addEventListener('click', function() {
        if (uploadedPhotos.length < MAX_PHOTOS) {
            photoInput.click();
        }
    });
    
    // File input change
    photoInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
        // Reset input so same file can be selected again
        this.value = '';
    });
    
    // Drag & Drop events
    dragDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('drag-over');
    });
    
    dragDropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('drag-over');
    });
    
    dragDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        handleFiles(files);
    });
}

function handleFiles(files) {
    const photoError = document.getElementById('photoError');
    const photoErrorMessage = document.getElementById('photoErrorMessage');
    
    // Hide previous errors
    photoError.style.display = 'none';
    
    // Check if adding these files would exceed max
    if (uploadedPhotos.length + files.length > MAX_PHOTOS) {
        showPhotoError(`You can only upload ${MAX_PHOTOS} photos maximum`);
        return;
    }
    
    // Process each file
    Array.from(files).forEach(file => {
        // Validate file type
        if (!file.type.match('image/jpeg|image/png|image/webp')) {
            showPhotoError('Only JPG, PNG, and WEBP images are allowed');
            return;
        }
        
        // Validate file size
        if (file.size > MAX_FILE_SIZE) {
            showPhotoError(`${file.name} is too large. Maximum size is 2MB`);
            return;
        }
        
        // Add to uploaded photos
        addPhotoPreview(file);
    });
    
    updatePhotoCount();
}

function addPhotoPreview(file) {
    const photoPreviews = document.getElementById('photoPreviews');
    const dragDropZone = document.getElementById('dragDropZone');
    
    // Create file reader
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const photoId = Date.now() + Math.random();
        
        // Store photo data
        uploadedPhotos.push({
            id: photoId,
            file: file,
            dataUrl: e.target.result
        });
        
        // Create preview element
        const previewDiv = document.createElement('div');
        previewDiv.className = 'photo-preview';
        previewDiv.dataset.photoId = photoId;
        
        previewDiv.innerHTML = `
            <img src="${e.target.result}" alt="Preview">
            <button type="button" class="photo-preview-remove" onclick="removePhoto(${photoId})">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        photoPreviews.appendChild(previewDiv);
        photoPreviews.style.display = 'grid';
        
        // Hide drag zone if max reached
        if (uploadedPhotos.length >= MAX_PHOTOS) {
            dragDropZone.style.display = 'none';
        }
        
        updatePhotoCount();
    };
    
    reader.readAsDataURL(file);
}

function removePhoto(photoId) {
    const photoPreviews = document.getElementById('photoPreviews');
    const dragDropZone = document.getElementById('dragDropZone');
    
    // Remove from array
    uploadedPhotos = uploadedPhotos.filter(photo => photo.id !== photoId);
    
    // Remove preview element
    const previewElement = document.querySelector(`[data-photo-id="${photoId}"]`);
    if (previewElement) {
        previewElement.remove();
    }
    
    // Show drag zone if below max
    if (uploadedPhotos.length < MAX_PHOTOS) {
        dragDropZone.style.display = 'block';
    }
    
    // Hide previews container if empty
    if (uploadedPhotos.length === 0) {
        photoPreviews.style.display = 'none';
    }
    
    updatePhotoCount();
}

// Make removePhoto globally accessible
window.removePhoto = removePhoto;

function updatePhotoCount() {
    const photoCount = document.getElementById('photoCount');
    photoCount.textContent = `${uploadedPhotos.length}/${MAX_PHOTOS} photos uploaded`;
}

function showPhotoError(message) {
    const photoError = document.getElementById('photoError');
    const photoErrorMessage = document.getElementById('photoErrorMessage');
    
    photoErrorMessage.textContent = message;
    photoError.style.display = 'flex';
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        photoError.style.display = 'none';
    }, 5000);
}

// ===================================
// FORM VALIDATION
// ===================================

function initializeFormValidation() {
    const form = document.getElementById('reviewForm');
    const submitButton = document.getElementById('submitButton');
    
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            // Disable submit button
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            
            // Create FormData
            const formData = new FormData(form);
            
            // Remove default file input (empty)
            formData.delete('photos[]');
            
            // Add uploaded photos
            uploadedPhotos.forEach((photo, index) => {
                formData.append('photos[]', photo.file);
            });
            
            // Submit form
            submitFormData(formData);
        }
    });
}

function validateForm() {
    let isValid = true;
    
    // Validate star rating
    const ratingInput = document.getElementById('ratingInput');
    const ratingError = document.getElementById('ratingError');
    const starRating = document.getElementById('starRating');
    
    if (!ratingInput.value || ratingInput.value === '0') {
        ratingError.style.display = 'flex';
        starRating.classList.add('error');
        isValid = false;
        
        // Scroll to error
        starRating.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        ratingError.style.display = 'none';
        starRating.classList.remove('error');
    }
    
    // Validate review text
    const reviewText = document.getElementById('reviewText');
    const textError = document.getElementById('textError');
    const textErrorMessage = document.getElementById('textErrorMessage');
    
    if (reviewText.value.trim().length < 20) {
        textError.style.display = 'flex';
        reviewText.classList.add('error');
        
        if (reviewText.value.trim().length === 0) {
            textErrorMessage.textContent = 'Please write a review';
        } else {
            textErrorMessage.textContent = `Please write at least ${20 - reviewText.value.trim().length} more characters`;
        }
        
        isValid = false;
        
        if (isValid) { // Only scroll if rating is valid
            reviewText.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else if (reviewText.value.length > 500) {
        textError.style.display = 'flex';
        reviewText.classList.add('error');
        textErrorMessage.textContent = 'Review is too long. Maximum 500 characters';
        isValid = false;
    } else {
        textError.style.display = 'none';
        reviewText.classList.remove('error');
    }
    
    return isValid;
}

function submitFormData(formData) {
    // In production, this would be an AJAX call
    // For now, we'll simulate and use regular form submission
    
    // Get form action URL
    const form = document.getElementById('reviewForm');
    const actionUrl = form.action;
    
    // Submit via fetch (AJAX)
    fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to My Request with success message
            window.location.href = data.redirect_url || '/my-request';
        } else {
            // Show error
            alert(data.message || 'An error occurred. Please try again.');
            
            // Re-enable submit button
            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Review';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Fallback to regular form submission
        form.submit();
    });
}

// ===================================
// PREVENT ACCIDENTAL NAVIGATION
// ===================================

let formModified = false;

document.querySelectorAll('#reviewForm input, #reviewForm textarea').forEach(element => {
    element.addEventListener('input', function() {
        formModified = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (formModified && !document.getElementById('submitButton').disabled) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
});

console.log('✅ Write Review JavaScript loaded successfully');
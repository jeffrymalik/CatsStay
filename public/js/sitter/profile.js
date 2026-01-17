/* ========================================
   PROFILE SETUP PAGE JAVASCRIPT
   ======================================== */

// ===== PREVIEW AVATAR =====
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
        
        // Auto submit form
        setTimeout(() => {
            document.getElementById('avatarForm').submit();
        }, 500);
    }
}

// ===== UPLOAD GALLERY PHOTOS =====
function uploadGalleryPhotos(input) {
    if (input.files && input.files.length > 0) {
        if (input.files.length > 10) {
            showToast('Maximum 10 photos at once', 'error');
            input.value = '';
            return;
        }
        
        // Auto submit form
        document.getElementById('galleryForm').submit();
    }
}

// ===== DELETE PHOTO =====
// ===== DELETE PHOTO =====
function deletePhoto(button, index) {
    if (!confirm('Are you sure you want to delete this photo?')) return;

    fetch(`/pet-sitter/profile/delete-gallery/${index}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed to delete photo');
        return res.json();
    })
    .then(data => {
        showToast(data.message, 'success');
        button.closest('.gallery-item').remove();
    })
    .catch(err => {
        console.error(err);
        showToast('Failed to delete photo', 'error');
    });
}


// ===== ADD LANGUAGE =====
function addLanguage() {
    const input = document.getElementById('newLanguage');
    const language = input.value.trim();
    
    if (language === '') {
        showToast('Please enter a language', 'error');
        return;
    }
    
    // Check if already exists
    const existingLanguages = Array.from(document.querySelectorAll('.language-tag input'))
        .map(inp => inp.value.toLowerCase());
    
    if (existingLanguages.includes(language.toLowerCase())) {
        showToast('Language already added', 'error');
        input.value = '';
        return;
    }
    
    // Create new language tag
    const languagesList = document.querySelector('.languages-list');
    const newTag = document.createElement('div');
    newTag.className = 'language-tag';
    newTag.innerHTML = `
        ${language}
        <button type="button" class="remove-tag" onclick="removeLanguage(this)">
            <i class="fas fa-times"></i>
        </button>
        <input type="hidden" name="languages[]" value="${language}">
    `;
    
    languagesList.appendChild(newTag);
    input.value = '';
    
    showToast('Language added!', 'success');
}

// ===== REMOVE LANGUAGE =====
function removeLanguage(button) {
    button.closest('.language-tag').remove();
    showToast('Language removed', 'success');
}

// ===== ADD CERTIFICATION =====
function addCertification() {
    const input = document.getElementById('newCertification');
    const certification = input.value.trim();
    
    if (certification === '') {
        showToast('Please enter a certification', 'error');
        return;
    }
    
    // Check if already exists
    const existingCerts = Array.from(document.querySelectorAll('.cert-item input'))
        .map(inp => inp.value.toLowerCase());
    
    if (existingCerts.includes(certification.toLowerCase())) {
        showToast('Certification already added', 'error');
        input.value = '';
        return;
    }
    
    // Create new certification item
    const certsList = document.querySelector('.certifications-list');
    const newCert = document.createElement('div');
    newCert.className = 'cert-item';
    newCert.innerHTML = `
        <i class="fas fa-award"></i>
        <span>${certification}</span>
        <button type="button" class="remove-cert" onclick="removeCertification(this)">
            <i class="fas fa-times"></i>
        </button>
        <input type="hidden" name="certifications[]" value="${certification}">
    `;
    
    certsList.appendChild(newCert);
    input.value = '';
    
    showToast('Certification added!', 'success');
}

// ===== REMOVE CERTIFICATION =====
function removeCertification(button) {
    button.closest('.cert-item').remove();
    showToast('Certification removed', 'success');
}

// ===== ENTER KEY HANDLERS =====
document.addEventListener('DOMContentLoaded', function() {
    // Add language on Enter
    document.getElementById('newLanguage')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addLanguage();
        }
    });
    
    // Add certification on Enter
    document.getElementById('newCertification')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addCertification();
        }
    });
});

// ===== FORM VALIDATION =====
document.getElementById('profileForm')?.addEventListener('submit', function(e) {
    const bio = document.querySelector('textarea[name="bio"]').value;
    
    if (bio.length > 1000) {
        e.preventDefault();
        showToast('Bio exceeds 1000 characters', 'error');
        return false;
    }
    
    showToast('Saving profile...', 'info');
});

// ===== UTILITY: SHOW TOAST =====
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-circle' : 
                     'info-circle';
    
    toast.innerHTML = `
        <i class="fas fa-${iconClass}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// ===== TOAST STYLES =====
const toastStyles = document.createElement('style');
toastStyles.textContent = `
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10001;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast i {
        font-size: 20px;
    }

    .toast-success {
        border-left: 4px solid #4CAF50;
    }

    .toast-success i {
        color: #4CAF50;
    }

    .toast-error {
        border-left: 4px solid #F44336;
    }

    .toast-error i {
        color: #F44336;
    }

    .toast-info {
        border-left: 4px solid #2196F3;
    }

    .toast-info i {
        color: #2196F3;
    }

    .toast span {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }
`;
document.head.appendChild(toastStyles);

console.log('%c👤 Profile Setup Page Loaded', 'color: #FF9800; font-size: 14px; font-weight: bold;');
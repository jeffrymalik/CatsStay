// ===================================
// MY CATS - JavaScript
// Photo Upload, Age Calculator, Character Counters, Delete Modal
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('My Cats JavaScript loaded');
    
    // Initialize all features
    initializePhotoUpload();
    initializeAgeCalculator();
    initializeCharacterCounters();
});

// ===================================
// PHOTO UPLOAD & PREVIEW
// ===================================
function initializePhotoUpload() {
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    
    if (!photoInput) return;
    
    // Handle photo selection
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file');
                photoInput.value = '';
                return;
            }
            
            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                photoInput.value = '';
                return;
            }
            
            // Read and display image
            const reader = new FileReader();
            reader.onload = function(e) {
                displayPhotoPreview(e.target.result);
            };
            reader.readAsDataURL(file);
            
            // Show remove button
            if (removePhotoBtn) {
                removePhotoBtn.style.display = 'flex';
            }
        }
    });
    
    // Handle photo removal
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            photoInput.value = '';
            resetPhotoPreview();
            this.style.display = 'none';
        });
    }
}

function displayPhotoPreview(imageSrc) {
    const photoPreview = document.getElementById('photoPreview');
    
    // Remove placeholder or existing image
    photoPreview.innerHTML = '';
    
    // Add new image
    const img = document.createElement('img');
    img.src = imageSrc;
    img.alt = 'Cat photo preview';
    img.id = 'previewImage';
    photoPreview.appendChild(img);
}

function resetPhotoPreview() {
    const photoPreview = document.getElementById('photoPreview');
    
    photoPreview.innerHTML = `
        <div class="photo-placeholder">
            <i class="fas fa-camera"></i>
            <p>No photo yet</p>
        </div>
    `;
}

// ===================================
// AGE CALCULATOR (from Birth Date)
// ===================================
function initializeAgeCalculator() {
    const birthDateInput = document.querySelector('input[name="birth_date"]');
    const calculatedAge = document.getElementById('calculatedAge');
    
    if (!birthDateInput || !calculatedAge) return;
    
    // Calculate age on load if birth date exists
    if (birthDateInput.value) {
        updateCalculatedAge(birthDateInput.value);
    }
    
    // Calculate age on change
    birthDateInput.addEventListener('change', function() {
        if (this.value) {
            updateCalculatedAge(this.value);
        } else {
            calculatedAge.textContent = '';
        }
    });
}

function updateCalculatedAge(birthDateStr) {
    const calculatedAge = document.getElementById('calculatedAge');
    if (!calculatedAge) return;
    
    const birthDate = new Date(birthDateStr);
    const today = new Date();
    
    let years = today.getFullYear() - birthDate.getFullYear();
    let months = today.getMonth() - birthDate.getMonth();
    
    if (months < 0) {
        years--;
        months += 12;
    }
    
    let ageText = '';
    
    if (years > 0) {
        ageText = years + (years === 1 ? ' year' : ' years');
        if (months > 0) {
            ageText += ' and ' + months + (months === 1 ? ' month' : ' months');
        }
    } else {
        ageText = months + (months === 1 ? ' month' : ' months');
    }
    
    ageText += ' old';
    
    calculatedAge.innerHTML = `<i class="fas fa-info-circle"></i> ${ageText}`;
}

// ===================================
// CHARACTER COUNTERS
// ===================================
function initializeCharacterCounters() {
    // Medical Notes
    const medicalTextarea = document.querySelector('textarea[name="medical_notes"]');
    const medicalCount = document.getElementById('medicalCount');
    
    if (medicalTextarea && medicalCount) {
        // Set initial count
        medicalCount.textContent = medicalTextarea.value.length;
        
        medicalTextarea.addEventListener('input', function() {
            medicalCount.textContent = this.value.length;
        });
    }
    
    // Personality
    const personalityTextarea = document.querySelector('textarea[name="personality"]');
    const personalityCount = document.getElementById('personalityCount');
    
    if (personalityTextarea && personalityCount) {
        personalityCount.textContent = personalityTextarea.value.length;
        
        personalityTextarea.addEventListener('input', function() {
            personalityCount.textContent = this.value.length;
        });
    }
    
    // Special Instructions
    const instructionsTextarea = document.querySelector('textarea[name="special_instructions"]');
    const instructionsCount = document.getElementById('instructionsCount');
    
    if (instructionsTextarea && instructionsCount) {
        instructionsCount.textContent = instructionsTextarea.value.length;
        
        instructionsTextarea.addEventListener('input', function() {
            instructionsCount.textContent = this.value.length;
        });
    }
}

// ===================================
// DELETE CONFIRMATION MODAL
// ===================================
function confirmDelete(catId, catName) {
    const modal = document.getElementById('deleteModal');
    const catNameElement = document.getElementById('catNameToDelete');
    const deleteForm = document.getElementById('deleteForm');
    
    if (modal && catNameElement && deleteForm) {
        // Set cat name in modal
        catNameElement.textContent = catName;
        
        // Set form action
        deleteForm.action = `/my-cats/${catId}`;
        
        // Show modal
        modal.classList.add('active');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    
    if (modal) {
        modal.classList.remove('active');
        
        // Restore body scroll
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('deleteModal');
    
    if (modal && e.target === modal) {
        closeDeleteModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// ===================================
// FORM VALIDATION
// ===================================
const catForm = document.getElementById('catForm');

if (catForm) {
    catForm.addEventListener('submit', function(e) {
        // Basic validation
        const name = document.querySelector('input[name="name"]').value.trim();
        const birthDate = document.querySelector('input[name="birth_date"]').value;
        const gender = document.querySelector('select[name="gender"]').value;
        
        let errors = [];
        
        if (!name) {
            errors.push('Please enter cat name');
        }
        
        if (!birthDate) {
            errors.push('Please select birth date');
        }
        
        if (!gender) {
            errors.push('Please select gender');
        }
        
        // Check if birth date is in the future
        if (birthDate) {
            const selectedDate = new Date(birthDate);
            const today = new Date();
            
            if (selectedDate > today) {
                errors.push('Birth date cannot be in the future');
            }
        }
        
        if (errors.length > 0) {
            e.preventDefault();
            alert('Please fix the following errors:\n\n' + errors.join('\n'));
            return false;
        }
        
        // Show loading state
        const submitBtn = catForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;
        }
        
        return true;
    });
}

// ===================================
// AUTO-HIDE SUCCESS MESSAGES
// ===================================
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.alert-success');
    
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.animation = 'slideUp 0.3s ease';
            
            setTimeout(function() {
                successAlert.style.display = 'none';
            }, 300);
        }, 5000); // Hide after 5 seconds
    }
});

// Slide up animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
`;
document.head.appendChild(style);

// ===================================
// PREVENT ACCIDENTAL FORM ABANDONMENT
// ===================================
let formModified = false;

if (catForm) {
    const formInputs = catForm.querySelectorAll('input, select, textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            formModified = true;
        });
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
    
    // Clear flag on successful form submission
    catForm.addEventListener('submit', function() {
        formModified = false;
    });
}

console.log('✅ My Cats JavaScript initialized successfully');
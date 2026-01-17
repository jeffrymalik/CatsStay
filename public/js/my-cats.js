/* ========================================
   MY CATS JAVASCRIPT
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== PHOTO UPLOAD PREVIEW =====
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                if (!file.type.match('image.*')) {
                    alert('Please select an image file');
                    photoInput.value = '';
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    alert('Image size should not exceed 2MB');
                    photoInput.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" alt="Cat photo" id="previewImage">`;
                    if (removePhotoBtn) {
                        removePhotoBtn.style.display = 'inline-block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            photoInput.value = '';
            photoPreview.innerHTML = `
                <div class="photo-placeholder">
                    <i class="fas fa-camera"></i>
                    <p>No photo yet</p>
                </div>
            `;
            removePhotoBtn.style.display = 'none';
        });
    }
    
    // ===== CHARACTER COUNT =====
    function updateCharCount(textarea, countElement) {
        const count = textarea.value.length;
        const maxLength = textarea.getAttribute('maxlength');
        countElement.textContent = count;
        
        if (count > maxLength * 0.9) {
            countElement.style.color = '#e74c3c';
        } else if (count > maxLength * 0.7) {
            countElement.style.color = '#f39c12';
        } else {
            countElement.style.color = '#95a5a6';
        }
    }
    
    const medicalNotes = document.querySelector('[name="medical_notes"]');
    const medicalCount = document.getElementById('medicalCount');
    if (medicalNotes && medicalCount) {
        updateCharCount(medicalNotes, medicalCount);
        medicalNotes.addEventListener('input', () => updateCharCount(medicalNotes, medicalCount));
    }
    
    const personalityTraits = document.querySelector('[name="personality_traits"]');
    const personalityCount = document.getElementById('personalityCount');
    if (personalityTraits && personalityCount) {
        updateCharCount(personalityTraits, personalityCount);
        personalityTraits.addEventListener('input', () => updateCharCount(personalityTraits, personalityCount));
    }
    
    const careInstructions = document.querySelector('[name="care_instructions"]');
    const instructionsCount = document.getElementById('instructionsCount');
    if (careInstructions && instructionsCount) {
        updateCharCount(careInstructions, instructionsCount);
        careInstructions.addEventListener('input', () => updateCharCount(careInstructions, instructionsCount));
    }
    
    // ===== CALCULATE AGE FROM BIRTH DATE =====
    const birthDateInput = document.querySelector('[name="date_of_birth"]');
    const calculatedAge = document.getElementById('calculatedAge');
    
    if (birthDateInput && calculatedAge) {
        function calculateAge() {
            const birthDate = new Date(birthDateInput.value);
            const today = new Date();
            
            if (!birthDateInput.value) {
                calculatedAge.textContent = '';
                return;
            }
            
            let years = today.getFullYear() - birthDate.getFullYear();
            let months = today.getMonth() - birthDate.getMonth();
            
            if (months < 0) {
                years--;
                months += 12;
            }
            
            if (years > 0) {
                calculatedAge.textContent = `Age: ${years} year${years > 1 ? 's' : ''}${months > 0 ? ` ${months} month${months > 1 ? 's' : ''}` : ''}`;
            } else {
                calculatedAge.textContent = `Age: ${months} month${months !== 1 ? 's' : ''}`;
            }
            calculatedAge.style.color = '#27ae60';
        }
        
        if (birthDateInput.value) {
            calculateAge();
        }
        
        birthDateInput.addEventListener('change', calculateAge);
    }
    
    // ===== FORM VALIDATION =====
    const catForm = document.getElementById('catForm');
    if (catForm) {
        catForm.addEventListener('submit', function(e) {
            const submitBtn = catForm.querySelector('.btn-primary');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
        });
    }
    
});

// ===== DELETE MODAL =====
function confirmDelete(catId, catName) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const catNameElement = document.getElementById('catNameToDelete');
    
    // Set cat name in modal
    catNameElement.textContent = catName;
    
    // Set form action
    deleteForm.action = `/my-cats/${catId}`;
    
    // Show modal
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeDeleteModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeleteModal();
    }
});

console.log('%c🐱 My Cats Loaded', 'color: #FF9800; font-weight: bold;');
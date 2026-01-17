// ============================================
// BOOKING FORM - FIXED VERSION
// ============================================

// Global variables
let selectedService = null;
let selectedPrice = 0;
let duration = 0;
let deliveryFee = 0;
let totalCats = 0;
let newCatIndex = 1;

// ============================================
// INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initializeServiceSelection();
    initializeDateSelection();
    initializeDeliveryMethod();
    initializeSpecialNotes();
    initializeCatSelection();
    initializeAddressPreview();
    initializeFormSubmit();
    
    // Initial calculation
    calculateTotalCats();
    calculatePricing();
});

// ============================================
// SERVICE SELECTION
// ============================================

function initializeServiceSelection() {
    const serviceInputs = document.querySelectorAll('input[name="service_type"]');
    
    serviceInputs.forEach(input => {
        input.addEventListener('change', function() {
            selectedService = this.dataset.name;
            selectedPrice = parseFloat(this.dataset.price);
            const isSingleDay = this.dataset.isSingleDay === 'true';
            const isHomeVisit = this.dataset.isHomeVisit === 'true';
            
            // Update summary
            document.getElementById('summaryService').textContent = selectedService;
            document.getElementById('summaryPricePerDay').textContent = formatRupiah(selectedPrice);
            
            // Handle date fields for single day services
            const endDateWrapper = document.getElementById('endDateWrapper');
            const endDateInput = document.getElementById('endDate');
            const startDateLabel = document.getElementById('startDateLabel');
            
            if (isSingleDay) {
                endDateWrapper.style.display = 'none';
                endDateInput.removeAttribute('required');
                startDateLabel.textContent = 'Service Date *';
                duration = 1;
            } else {
                endDateWrapper.style.display = 'block';
                endDateInput.setAttribute('required', 'required');
                startDateLabel.textContent = 'Start Date *';
            }
            
            // Handle home visit info
            const homeVisitInfo = document.getElementById('homeVisitInfo');
            const dropoffOption = document.getElementById('dropoffOption');
            const pickupOption = document.getElementById('pickupOption');
            
            if (isHomeVisit) {
                homeVisitInfo.style.display = 'block';
                dropoffOption.style.display = 'none';
                pickupOption.querySelector('input').checked = true;
                deliveryFee = 50000;
            } else {
                homeVisitInfo.style.display = 'none';
                dropoffOption.style.display = 'block';
            }
            
            calculatePricing();
        });
    });
    
    // Set initial service
    const checkedService = document.querySelector('input[name="service_type"]:checked');
    if (checkedService) {
        selectedService = checkedService.dataset.name;
        selectedPrice = parseFloat(checkedService.dataset.price);
    }
}

// ============================================
// DATE SELECTION
// ============================================

function initializeDateSelection() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        calculateDuration();
    });
    
    endDateInput.addEventListener('change', function() {
        calculateDuration();
    });
}

function calculateDuration() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const durationText = document.getElementById('durationText');
    const checkedService = document.querySelector('input[name="service_type"]:checked');
    const isSingleDay = checkedService ? checkedService.dataset.isSingleDay === 'true' : false;
    
    if (isSingleDay) {
        duration = 1;
        durationText.textContent = '1 day';
        document.getElementById('summaryDuration').textContent = '1 day';
    } else if (startDateInput.value && endDateInput.value) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const diffTime = Math.abs(endDate - startDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        duration = diffDays;
        durationText.textContent = `${diffDays} day${diffDays > 1 ? 's' : ''}`;
        document.getElementById('summaryDuration').textContent = `${diffDays} day${diffDays > 1 ? 's' : ''}`;
    } else if (startDateInput.value) {
        duration = 1;
        durationText.textContent = '1 day';
        document.getElementById('summaryDuration').textContent = '1 day';
    } else {
        duration = 0;
        durationText.textContent = 'Please select dates';
        document.getElementById('summaryDuration').textContent = '0 days';
    }
    
    calculatePricing();
}

// ============================================
// DELIVERY METHOD
// ============================================

function initializeDeliveryMethod() {
    const deliveryInputs = document.querySelectorAll('input[name="delivery_method"]');
    
    deliveryInputs.forEach(input => {
        input.addEventListener('change', function() {
            const userAddressSelection = document.getElementById('userAddressSelection');
            const summaryDeliveryItem = document.getElementById('summaryDeliveryItem');
            
            if (this.value === 'pickup') {
                deliveryFee = 50000;
                if (userAddressSelection) {
                    userAddressSelection.style.display = 'block';
                }
                summaryDeliveryItem.style.display = 'flex';
            } else {
                deliveryFee = 0;
                if (userAddressSelection) {
                    userAddressSelection.style.display = 'none';
                }
                summaryDeliveryItem.style.display = 'none';
            }
            
            calculatePricing();
        });
    });
    
    // Set initial delivery fee
    const checkedDelivery = document.querySelector('input[name="delivery_method"]:checked');
    if (checkedDelivery && checkedDelivery.value === 'pickup') {
        deliveryFee = 50000;
        document.getElementById('summaryDeliveryItem').style.display = 'flex';
    }
}

function initializeAddressPreview() {
    const userAddressSelect = document.getElementById('userAddressSelect');
    if (userAddressSelect) {
        userAddressSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const addressPreview = document.getElementById('addressPreview');
            
            if (this.value) {
                const label = selectedOption.dataset.label;
                const address = selectedOption.dataset.address;
                
                document.getElementById('addressPreviewLabel').textContent = label;
                document.getElementById('addressPreviewText').textContent = address;
                addressPreview.style.display = 'block';
            } else {
                addressPreview.style.display = 'none';
            }
        });
    }
}

// ============================================
// CAT SELECTION (MULTIPLE CATS)
// ============================================

function initializeCatSelection() {
    // Registered cats checkboxes
    const catCheckboxes = document.querySelectorAll('#catsGrid input[type="checkbox"]');
    catCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCatsSelection();
        });
    });
    
    // Cat type toggle
    const catTypeInputs = document.querySelectorAll('input[name="cat_type"]');
    catTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            toggleCatType();
        });
    });
    
    // Initialize cat cards selection state
    document.querySelectorAll('#catsGrid input[type="checkbox"]:checked').forEach(checkbox => {
        checkbox.closest('.cat-card').classList.add('selected');
    });
    
    // Initialize selected cats preview
    updateCatsSelection();
}

function toggleCatType() {
    const catType = document.querySelector('input[name="cat_type"]:checked').value;
    const registeredSection = document.getElementById('registeredCatSection');
    const newSection = document.getElementById('newCatSection');
    
    if (catType === 'registered') {
        registeredSection.style.display = 'block';
        newSection.style.display = 'none';
        
        // DISABLE new cat inputs to prevent validation
        const newCatInputs = newSection.querySelectorAll('input[name^="new_cats"]');
        newCatInputs.forEach(input => {
            input.removeAttribute('required');
            input.disabled = true;
        });
        
        // ENABLE registered cat checkboxes
        const registeredInputs = registeredSection.querySelectorAll('input[name="registered_cat_ids[]"]');
        registeredInputs.forEach(input => {
            input.disabled = false;
        });
        
        // Update toggle button styles
        document.querySelector('.toggle-option[data-target="registered"]').classList.add('active');
        document.querySelector('.toggle-option[data-target="new"]').classList.remove('active');
    } else {
        registeredSection.style.display = 'none';
        newSection.style.display = 'block';
        
        // DISABLE registered cat checkboxes
        const registeredInputs = registeredSection.querySelectorAll('input[name="registered_cat_ids[]"]');
        registeredInputs.forEach(input => {
            input.disabled = true;
            input.checked = false;
        });
        
        // ENABLE new cat inputs and add required to name fields
        const newCatInputs = newSection.querySelectorAll('input[name^="new_cats"]');
        newCatInputs.forEach(input => {
            input.disabled = false;
            // Add required only to name fields
            if (input.name.includes('[name]')) {
                input.setAttribute('required', 'required');
            }
        });
        
        // Update toggle button styles
        document.querySelector('.toggle-option[data-target="registered"]').classList.remove('active');
        document.querySelector('.toggle-option[data-target="new"]').classList.add('active');
    }
    
    calculateTotalCats();
}

function toggleCatSelection(card) {
    const checkbox = card.querySelector('input[type="checkbox"]');
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
}

function updateCatsSelection() {
    const checkboxes = document.querySelectorAll('#catsGrid input[type="checkbox"]:checked');
    const preview = document.getElementById('selectedCatsPreview');
    const list = document.getElementById('selectedCatsList');
    const count = document.getElementById('selectedCatsCount');
    
    if (checkboxes.length > 0) {
        preview.style.display = 'block';
        count.textContent = checkboxes.length;
        
        list.innerHTML = '';
        checkboxes.forEach(checkbox => {
            const name = checkbox.dataset.name;
            const tag = document.createElement('div');
            tag.className = 'selected-cat-tag';
            tag.innerHTML = `<i class="fas fa-check-circle"></i> ${name}`;
            list.appendChild(tag);
        });
    } else {
        preview.style.display = 'none';
    }
    
    calculateTotalCats();
}

function calculateTotalCats() {
    const catType = document.querySelector('input[name="cat_type"]:checked')?.value;
    
    if (catType === 'registered') {
        totalCats = document.querySelectorAll('#catsGrid input[type="checkbox"]:checked').length;
    } else if (catType === 'new') {
        totalCats = document.querySelectorAll('.new-cat-item').length;
    } else {
        totalCats = 0;
    }
    
    // Update summary
    updateCatsSummary();
    calculatePricing();
}

function updateCatsSummary() {
    const summaryTotalCats = document.getElementById('summaryTotalCats');
    const catsCountBadge = document.getElementById('catsCountBadge');
    
    summaryTotalCats.textContent = totalCats;
    
    if (totalCats > 0) {
        catsCountBadge.style.display = 'inline-block';
        catsCountBadge.textContent = `${totalCats} cat${totalCats > 1 ? 's' : ''}`;
    } else {
        catsCountBadge.style.display = 'none';
    }
}

// ============================================
// NEW CAT FORM MANAGEMENT
// ============================================

function addNewCatForm() {
    const container = document.getElementById('newCatsContainer');
    const newForm = document.createElement('div');
    newForm.className = 'new-cat-item';
    newForm.dataset.index = newCatIndex;
    
    // Check if new cat section is visible
    const catType = document.querySelector('input[name="cat_type"]:checked').value;
    const shouldBeDisabled = catType !== 'new';
    
    newForm.innerHTML = `
        <button type="button" class="remove-cat-btn" onclick="removeCatForm(this)">
            <i class="fas fa-times"></i>
        </button>
        <h4>Cat #${newCatIndex + 1}</h4>
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-cat"></i>
                Cat Name *
            </label>
            <input type="text" 
                   name="new_cats[${newCatIndex}][name]" 
                   class="form-input" 
                   placeholder="e.g., Luna"
                   ${shouldBeDisabled ? '' : 'required'}
                   ${shouldBeDisabled ? 'disabled' : ''}>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-paw"></i>
                    Breed (Optional)
                </label>
                <input type="text" 
                       name="new_cats[${newCatIndex}][breed]" 
                       class="form-input" 
                       placeholder="e.g., Persian"
                       ${shouldBeDisabled ? 'disabled' : ''}>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-birthday-cake"></i>
                    Age (Optional)
                </label>
                <input type="text" 
                       name="new_cats[${newCatIndex}][age]" 
                       class="form-input" 
                       placeholder="e.g., 2 years"
                       ${shouldBeDisabled ? 'disabled' : ''}>
            </div>
        </div>
    `;
    container.appendChild(newForm);
    newCatIndex++;
    calculateTotalCats();
}

function removeCatForm(btn) {
    const items = document.querySelectorAll('.new-cat-item');
    if (items.length > 1) {
        btn.closest('.new-cat-item').remove();
        calculateTotalCats();
        
        // Renumber cats
        const remainingItems = document.querySelectorAll('.new-cat-item');
        remainingItems.forEach((item, index) => {
            item.querySelector('h4').textContent = `Cat #${index + 1}`;
        });
    } else {
        showError('You must have at least one cat for the booking.');
    }
}

// ============================================
// SPECIAL NOTES
// ============================================

function initializeSpecialNotes() {
    const specialNotes = document.getElementById('specialNotes');
    const notesCount = document.getElementById('notesCount');
    
    if (specialNotes && notesCount) {
        specialNotes.addEventListener('input', function() {
            notesCount.textContent = this.value.length;
        });
        
        // Set initial count
        notesCount.textContent = specialNotes.value.length;
    }
}

// ============================================
// PRICE CALCULATION
// ============================================

function calculatePricing() {
    // Service price = price per day × duration × number of cats
    const servicePrice = selectedPrice * duration * totalCats;
    
    // Subtotal = service price + delivery fee
    const subtotal = servicePrice + deliveryFee;
    
    // Platform fee = 5% of subtotal
    const platformFee = subtotal * 0.05;
    
    // Total = subtotal + platform fee
    const total = subtotal + platformFee;
    
    // Update summary
    document.getElementById('summarySubtotal').textContent = formatRupiah(servicePrice);
    document.getElementById('summaryDeliveryFee').textContent = formatRupiah(deliveryFee);
    document.getElementById('summaryPlatformFee').textContent = formatRupiah(platformFee);
    document.getElementById('summaryTotal').textContent = formatRupiah(total);
}

// ============================================
// FORM SUBMISSION
// ============================================

function initializeFormSubmit() {
    const form = document.getElementById('bookingForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Clear any previous error messages
            const formMessages = document.getElementById('formMessages');
            if (formMessages) {
                formMessages.innerHTML = '';
            }
            
            // Additional validation (optional - browser will handle required fields)
            const catType = document.querySelector('input[name="cat_type"]:checked')?.value;
            
            if (catType === 'registered') {
                const selectedCats = document.querySelectorAll('#catsGrid input[type="checkbox"]:checked:not(:disabled)');
                if (selectedCats.length === 0) {
                    e.preventDefault();
                    showError('Please select at least one cat for this booking.');
                    scrollToSection('registeredCatSection');
                    return false;
                }
            }
            
            if (totalCats === 0) {
                e.preventDefault();
                showError('Please select or add at least one cat for this booking.');
                scrollToSection('registeredCatSection');
                return false;
            }
            
            // Form will submit naturally
        });
    }
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

function formatRupiah(number) {
    return 'Rp ' + number.toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function showError(message) {
    const formMessages = document.getElementById('formMessages');
    if (formMessages) {
        formMessages.innerHTML = `
            <div class="error-message" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: start; gap: 12px;">
                <i class="fas fa-exclamation-circle" style="color: #721c24; margin-top: 2px;"></i>
                <p style="margin: 0;">${message}</p>
            </div>
        `;
        
        // Auto remove after 8 seconds
        setTimeout(() => {
            const errorMsg = formMessages.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.style.transition = 'opacity 0.3s';
                errorMsg.style.opacity = '0';
                setTimeout(() => {
                    formMessages.innerHTML = '';
                }, 300);
            }
        }, 8000);
    }
}

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Real-time validation for new cat name inputs
document.addEventListener('input', function(e) {
    if (e.target.matches('input[name*="new_cats"][name*="[name]"]')) {
        if (e.target.value.trim()) {
            e.target.style.borderColor = '';
        }
    }
});

// Make functions globally accessible
window.toggleCatType = toggleCatType;
window.toggleCatSelection = toggleCatSelection;
window.updateCatsSelection = updateCatsSelection;
window.addNewCatForm = addNewCatForm;
window.removeCatForm = removeCatForm;
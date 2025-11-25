// ===================================
// BOOKING FORM - JavaScript
// Price Calculator, Date Validation, Form Interactions
// ===================================

// Global variables
let selectedServicePrice = 0;
let selectedServiceName = '';
let isSingleDayService = false;
let durationDays = 0;
const platformFeePercent = 5;

// ===================================
// INITIALIZE ON PAGE LOAD
// ===================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Booking Form loaded');
    
    initializeServiceSelection();
    initializeCatTypeToggle();
    initializeCatSelection();
    initializeDatePickers();
    initializeTextareaCounter();
    initializeFormValidation();
    
    // Set initial service (first one is checked by default)
    const firstService = document.querySelector('input[name="service_type"]:checked');
    if (firstService) {
        updateSelectedService(firstService);
    }
});

// ===================================
// SERVICE SELECTION
// ===================================
function initializeServiceSelection() {
    const serviceRadios = document.querySelectorAll('input[name="service_type"]');
    
    serviceRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateSelectedService(this);
            calculateTotal();
        });
    });
}

function updateSelectedService(radio) {
    selectedServicePrice = parseInt(radio.dataset.price);
    selectedServiceName = radio.dataset.name;
    isSingleDayService = radio.dataset.singleDay === 'true';
    
    // Update summary
    document.getElementById('summaryService').textContent = selectedServiceName;
    document.getElementById('summaryPricePerDay').textContent = formatCurrency(selectedServicePrice);
    
    // Handle single-day service (e.g., Grooming)
    const endDateWrapper = document.getElementById('endDateWrapper');
    const endDateInput = document.getElementById('endDate');
    const startDateLabel = document.getElementById('startDateLabel');
    const durationDisplay = document.querySelector('.duration-display');
    
    if (isSingleDayService) {
        // Hide end date field for single-day services
        endDateWrapper.style.display = 'none';
        endDateInput.removeAttribute('required');
        
        // Change start date label
        startDateLabel.textContent = 'Select Date *';
        
        // Set duration to 1 day
        durationDays = 1;
        document.getElementById('summaryDuration').textContent = '1 day';
        
        // Update duration display text
        const startDate = document.getElementById('startDate').value;
        if (startDate) {
            const date = new Date(startDate);
            durationDisplay.querySelector('span').innerHTML = `<strong>1 day</strong> (${formatDate(date)})`;
        } else {
            durationDisplay.querySelector('span').textContent = 'Please select date';
        }
        
        // Auto-set end date to match start date (for backend)
        const startDateValue = document.getElementById('startDate').value;
        if (startDateValue) {
            endDateInput.value = startDateValue;
        }
        
    } else {
        // Show end date field for multi-day services
        endDateWrapper.style.display = 'block';
        endDateInput.setAttribute('required', 'required');
        
        // Reset start date label
        startDateLabel.textContent = 'Start Date *';
        
        // Recalculate duration if dates are selected
        calculateDuration();
    }
    
    calculateTotal();
}

// ===================================
// CAT TYPE TOGGLE (Registered vs New)
// ===================================
function initializeCatTypeToggle() {
    const toggleOptions = document.querySelectorAll('.toggle-option');
    const registeredSection = document.getElementById('registeredCatSection');
    const newSection = document.getElementById('newCatSection');
    
    toggleOptions.forEach(option => {
        option.addEventListener('click', function() {
            const target = this.dataset.target;
            
            // Update active state
            toggleOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            // Toggle sections
            if (target === 'registered') {
                registeredSection.style.display = 'block';
                newSection.style.display = 'none';
                
                // Clear new cat inputs
                document.querySelector('input[name="new_cat_name"]').value = '';
                document.querySelector('input[name="new_cat_breed"]').value = '';
                document.querySelector('input[name="new_cat_age"]').value = '';
            } else {
                registeredSection.style.display = 'none';
                newSection.style.display = 'block';
                
                // Reset registered cat select
                document.getElementById('registeredCatSelect').value = '';
                document.getElementById('catPreview').style.display = 'none';
            }
        });
    });
}

// ===================================
// CAT SELECTION (Show Preview)
// ===================================
function initializeCatSelection() {
    const catSelect = document.getElementById('registeredCatSelect');
    
    if (catSelect) {
        catSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const catPreview = document.getElementById('catPreview');
            
            if (this.value) {
                // Get cat data from option
                const catPhoto = selectedOption.dataset.photo;
                const catText = selectedOption.textContent;
                
                // Parse cat name and details
                const catName = catText.split(' (')[0];
                const catDetails = catText.match(/\(([^)]+)\)/)[1];
                
                // Update preview
                document.getElementById('catPreviewImg').src = catPhoto;
                document.getElementById('catPreviewName').textContent = catName;
                document.getElementById('catPreviewDetails').textContent = catDetails;
                
                // Show preview
                catPreview.style.display = 'flex';
            } else {
                // Hide preview if no selection
                catPreview.style.display = 'none';
            }
        });
    }
}

// ===================================
// DATE PICKERS & DURATION CALCULATOR
// ===================================
function initializeDatePickers() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);
    
    // Listen to date changes
    startDateInput.addEventListener('change', function() {
        if (isSingleDayService) {
            // For single-day service, auto-set end date to match start date
            endDateInput.value = this.value;
            durationDays = 1;
            
            // Update duration display
            const date = new Date(this.value);
            document.getElementById('durationText').innerHTML = `<strong>1 day</strong> (${formatDate(date)})`;
            document.getElementById('summaryDuration').textContent = '1 day';
            
            calculateTotal();
        } else {
            // For multi-day service, update end date minimum to start date
            endDateInput.setAttribute('min', this.value);
            
            // If end date is before start date, reset it
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = '';
            }
            
            calculateDuration();
        }
    });
    
    endDateInput.addEventListener('change', function() {
        if (!isSingleDayService) {
            calculateDuration();
        }
    });
}

function calculateDuration() {
    // Skip calculation for single-day services
    if (isSingleDayService) {
        return;
    }
    
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const durationText = document.getElementById('durationText');
    const summaryDuration = document.getElementById('summaryDuration');
    
    if (startDate && endDate) {
        // Calculate difference in days
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        durationDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 to include both days
        
        // Update display
        const durationString = durationDays + (durationDays === 1 ? ' day' : ' days');
        durationText.innerHTML = `<strong>${durationString}</strong> (${formatDate(start)} - ${formatDate(end)})`;
        summaryDuration.textContent = durationString;
        
        // Recalculate total
        calculateTotal();
    } else {
        durationText.textContent = 'Please select dates';
        summaryDuration.textContent = '0 days';
        durationDays = 0;
        calculateTotal();
    }
}

// ===================================
// PRICE CALCULATOR
// ===================================
function calculateTotal() {
    const subtotal = selectedServicePrice * durationDays;
    const platformFee = Math.round(subtotal * (platformFeePercent / 100));
    const total = subtotal + platformFee;
    
    // Update summary display
    document.getElementById('summarySubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('summaryPlatformFee').textContent = formatCurrency(platformFee);
    document.getElementById('summaryTotal').textContent = formatCurrency(total);
}

// ===================================
// TEXTAREA CHARACTER COUNTER
// ===================================
function initializeTextareaCounter() {
    const textarea = document.querySelector('textarea[name="special_notes"]');
    const charCount = document.querySelector('.char-count');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            const maxLength = this.getAttribute('maxlength');
            charCount.textContent = `${currentLength}/${maxLength} characters`;
        });
    }
}

// ===================================
// FORM VALIDATION
// ===================================
function initializeFormValidation() {
    const form = document.getElementById('bookingForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Clear previous errors
            clearFormErrors();
            
            let errors = [];
            
            // Validate service selection
            const serviceSelected = document.querySelector('input[name="service_type"]:checked');
            if (!serviceSelected) {
                errors.push('Please select a service');
            }
            
            // Validate cat selection
            const catType = document.querySelector('input[name="cat_type"]:checked').value;
            
            if (catType === 'registered') {
                const registeredCatId = document.querySelector('select[name="registered_cat_id"]').value;
                if (!registeredCatId) {
                    errors.push('Please select a cat from your registered cats');
                    markFieldError('registeredCatSelect');
                }
            } else if (catType === 'new') {
                const newCatName = document.querySelector('input[name="new_cat_name"]').value.trim();
                if (!newCatName) {
                    errors.push('Please enter your cat\'s name');
                    markFieldError('input[name="new_cat_name"]');
                }
            }
            
            // Validate dates
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate) {
                errors.push('Please select a date');
                markFieldError('startDate');
            }
            
            // Only validate end date for multi-day services
            if (!isSingleDayService) {
                if (!endDate) {
                    errors.push('Please select an end date');
                    markFieldError('endDate');
                }
                
                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    errors.push('End date must be after start date');
                    markFieldError('endDate');
                }
            }
            
            // Validate terms
            const termsAccepted = document.querySelector('input[name="terms_accepted"]').checked;
            if (!termsAccepted) {
                errors.push('Please accept the Terms of Service and Cancellation Policy');
            }
            
            // If there are errors, prevent submission and show messages
            if (errors.length > 0) {
                e.preventDefault();
                showFormErrors(errors);
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-confirm-booking');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            // Form is valid, allow submission
            return true;
        });
    }
}

function showFormErrors(errors) {
    const messagesContainer = document.getElementById('formMessages');
    
    let errorHTML = `
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <p><strong>Please fix the following errors:</strong></p>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
    `;
    
    errors.forEach(error => {
        errorHTML += `<li>${error}</li>`;
    });
    
    errorHTML += `
                </ul>
            </div>
        </div>
    `;
    
    messagesContainer.innerHTML = errorHTML;
    
    // Scroll to error message
    messagesContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function clearFormErrors() {
    const messagesContainer = document.getElementById('formMessages');
    messagesContainer.innerHTML = '';
    
    // Remove field error classes
    document.querySelectorAll('.field-error').forEach(field => {
        field.classList.remove('field-error');
    });
    
    document.querySelectorAll('.field-error-text').forEach(text => {
        text.remove();
    });
}

function markFieldError(fieldIdentifier) {
    const field = typeof fieldIdentifier === 'string' 
        ? document.getElementById(fieldIdentifier) || document.querySelector(fieldIdentifier)
        : fieldIdentifier;
    
    if (field) {
        field.classList.add('field-error');
    }
}

// ===================================
// UTILITY FUNCTIONS
// ===================================

function formatCurrency(amount) {
    if (amount === 0) return 'Rp 0';
    return 'Rp ' + amount.toLocaleString('id-ID');
}

function formatDate(date) {
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

// ===================================
// SMOOTH SCROLL TO ERROR
// ===================================
function scrollToError(element) {
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.focus();
    }
}

// ===================================
// AUTO-SAVE DRAFT (Optional Enhancement)
// ===================================
function saveDraft() {
    const formData = {
        service_type: document.querySelector('input[name="service_type"]:checked')?.value,
        cat_type: document.querySelector('input[name="cat_type"]:checked')?.value,
        start_date: document.getElementById('startDate')?.value,
        end_date: document.getElementById('endDate')?.value,
        special_notes: document.querySelector('textarea[name="special_notes"]')?.value,
    };
    
    localStorage.setItem('booking_draft', JSON.stringify(formData));
    console.log('Draft saved');
}

function loadDraft() {
    const draft = localStorage.getItem('booking_draft');
    if (draft) {
        const formData = JSON.parse(draft);
        // Restore form values
        // (Implementation depends on requirements)
        console.log('Draft loaded:', formData);
    }
}

// ===================================
// PREVENT ACCIDENTAL PAGE LEAVE
// ===================================
let formModified = false;

document.addEventListener('DOMContentLoaded', function() {
    const formInputs = document.querySelectorAll('#bookingForm input, #bookingForm select, #bookingForm textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            formModified = true;
        });
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
document.getElementById('bookingForm')?.addEventListener('submit', function() {
    formModified = false;
});

console.log('✅ Booking Form JavaScript loaded successfully');
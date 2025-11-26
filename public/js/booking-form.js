// ===================================
// BOOKING FORM - Complete JavaScript
// Includes: Service, Cat, Date, Delivery Method, Address, Price Calculator
// ===================================

// Global variables
let selectedServicePrice = 0;
let selectedServiceName = '';
let isSingleDayService = false;
let isHomeVisitService = false;
let durationDays = 0;
const platformFeePercent = 5;
const deliveryFee = 50000; // Fixed Rp 50,000
let selectedDeliveryMethod = 'dropoff';

// ===================================
// INITIALIZE ON PAGE LOAD
// ===================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('Booking Form loaded');
    
    initializeServiceSelection();
    initializeCatTypeToggle();
    initializeCatSelection();
    initializeDatePickers();
    initializeDeliveryMethod();
    initializeAddressSelection();
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
            handleHomeVisitService();
            calculateTotal();
        });
    });
}

function updateSelectedService(radio) {
    selectedServicePrice = parseInt(radio.dataset.price);
    selectedServiceName = radio.dataset.name;
    isSingleDayService = radio.dataset.singleDay === 'true';
    isHomeVisitService = radio.dataset.isHomeVisit === 'true';
    
    // Update summary
    document.getElementById('summaryService').textContent = selectedServiceName;
    document.getElementById('summaryPricePerDay').textContent = formatCurrency(selectedServicePrice);
    
    // Handle single-day service (e.g., Grooming)
    const endDateWrapper = document.getElementById('endDateWrapper');
    const endDateInput = document.getElementById('endDate');
    const startDateLabel = document.getElementById('startDateLabel');
    const durationDisplay = document.querySelector('.duration-display');
    
    if (isSingleDayService) {
        endDateWrapper.style.display = 'none';
        endDateInput.removeAttribute('required');
        startDateLabel.textContent = 'Select Date *';
        durationDays = 1;
        document.getElementById('summaryDuration').textContent = '1 day';
        
        const startDate = document.getElementById('startDate').value;
        if (startDate) {
            const date = new Date(startDate);
            durationDisplay.querySelector('span').innerHTML = `<strong>1 day</strong> (${formatDate(date)})`;
        } else {
            durationDisplay.querySelector('span').textContent = 'Please select date';
        }
        
        const startDateValue = document.getElementById('startDate').value;
        if (startDateValue) {
            endDateInput.value = startDateValue;
        }
        
    } else {
        endDateWrapper.style.display = 'block';
        endDateInput.setAttribute('required', 'required');
        startDateLabel.textContent = 'Start Date *';
        calculateDuration();
    }
    
    calculateTotal();
}

// ===================================
// CAT TYPE TOGGLE
// ===================================
function initializeCatTypeToggle() {
    const toggleOptions = document.querySelectorAll('.toggle-option');
    const registeredSection = document.getElementById('registeredCatSection');
    const newSection = document.getElementById('newCatSection');
    
    toggleOptions.forEach(option => {
        option.addEventListener('click', function() {
            const target = this.dataset.target;
            
            toggleOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            if (target === 'registered') {
                registeredSection.style.display = 'block';
                newSection.style.display = 'none';
                
                document.querySelector('input[name="new_cat_name"]').value = '';
                document.querySelector('input[name="new_cat_breed"]').value = '';
                document.querySelector('input[name="new_cat_age"]').value = '';
            } else {
                registeredSection.style.display = 'none';
                newSection.style.display = 'block';
                
                document.getElementById('registeredCatSelect').value = '';
                document.getElementById('catPreview').style.display = 'none';
            }
        });
    });
}

// ===================================
// CAT SELECTION
// ===================================
function initializeCatSelection() {
    const catSelect = document.getElementById('registeredCatSelect');
    
    if (catSelect) {
        catSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const catPreview = document.getElementById('catPreview');
            
            if (this.value) {
                const catPhoto = selectedOption.dataset.photo;
                const catText = selectedOption.textContent;
                const catName = catText.split(' (')[0];
                const catDetails = catText.match(/\(([^)]+)\)/)[1];
                
                document.getElementById('catPreviewImg').src = catPhoto;
                document.getElementById('catPreviewName').textContent = catName;
                document.getElementById('catPreviewDetails').textContent = catDetails;
                
                catPreview.style.display = 'flex';
            } else {
                catPreview.style.display = 'none';
            }
        });
    }
}

// ===================================
// DATE PICKERS & DURATION
// ===================================
function initializeDatePickers() {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    
    const today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);
    
    startDateInput.addEventListener('change', function() {
        if (isSingleDayService) {
            endDateInput.value = this.value;
            durationDays = 1;
            
            const date = new Date(this.value);
            document.getElementById('durationText').innerHTML = `<strong>1 day</strong> (${formatDate(date)})`;
            document.getElementById('summaryDuration').textContent = '1 day';
            
            calculateTotal();
        } else {
            endDateInput.setAttribute('min', this.value);
            
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
    if (isSingleDayService) return;
    
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const durationText = document.getElementById('durationText');
    const summaryDuration = document.getElementById('summaryDuration');
    
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        durationDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        const durationString = durationDays + (durationDays === 1 ? ' day' : ' days');
        durationText.innerHTML = `<strong>${durationString}</strong> (${formatDate(start)} - ${formatDate(end)})`;
        summaryDuration.textContent = durationString;
        
        calculateTotal();
    } else {
        durationText.textContent = 'Please select dates';
        summaryDuration.textContent = '0 days';
        durationDays = 0;
        calculateTotal();
    }
}

// ===================================
// DELIVERY METHOD
// ===================================
function initializeDeliveryMethod() {
    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const sitterAddressBox = document.getElementById('sitterAddressBox');
    const userAddressSelection = document.getElementById('userAddressSelection');
    
    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedDeliveryMethod = this.value;
            
            if (this.value === 'dropoff') {
                if (sitterAddressBox) sitterAddressBox.style.display = 'block';
                if (userAddressSelection) userAddressSelection.style.display = 'none';
                
                const addressSelect = document.getElementById('userAddressSelect');
                if (addressSelect) addressSelect.removeAttribute('required');
                
            } else if (this.value === 'pickup') {
                if (sitterAddressBox) sitterAddressBox.style.display = 'none';
                if (userAddressSelection) userAddressSelection.style.display = 'block';
                
                const addressSelect = document.getElementById('userAddressSelect');
                if (addressSelect) addressSelect.setAttribute('required', 'required');
            }
            
            calculateTotal();
        });
    });
    
    // Check initial service for Home Visit
    const checkedService = document.querySelector('input[name="service_type"]:checked');
    if (checkedService) {
        isHomeVisitService = checkedService.dataset.isHomeVisit === 'true';
        handleHomeVisitService();
    }
}

function handleHomeVisitService() {
    const dropoffOption = document.getElementById('dropoffOption');
    const pickupOption = document.getElementById('pickupOption');
    const homeVisitInfo = document.getElementById('homeVisitInfo');
    const dropoffRadio = document.querySelector('input[name="delivery_method"][value="dropoff"]');
    const pickupRadio = document.querySelector('input[name="delivery_method"][value="pickup"]');
    
    if (isHomeVisitService) {
        // Home Visit: Only pickup available
        if (dropoffOption) {
            dropoffOption.style.display = 'none';
            if (dropoffRadio) dropoffRadio.disabled = true;
        }
        
        if (pickupRadio) {
            pickupRadio.checked = true;
            pickupRadio.disabled = false;
        }
        
        if (homeVisitInfo) homeVisitInfo.style.display = 'flex';
        
        const userAddressSelection = document.getElementById('userAddressSelection');
        if (userAddressSelection) userAddressSelection.style.display = 'block';
        
        const addressSelect = document.getElementById('userAddressSelect');
        if (addressSelect) addressSelect.setAttribute('required', 'required');
        
        selectedDeliveryMethod = 'pickup';
        
    } else {
        // Cat Sitting & Grooming: Both options available
        if (dropoffOption) {
            dropoffOption.style.display = 'block';
            if (dropoffRadio) dropoffRadio.disabled = false;
        }
        
        if (pickupRadio) pickupRadio.disabled = false;
        if (homeVisitInfo) homeVisitInfo.style.display = 'none';
        
        if (dropoffRadio && !pickupRadio.checked) {
            dropoffRadio.checked = true;
            selectedDeliveryMethod = 'dropoff';
            
            const userAddressSelection = document.getElementById('userAddressSelection');
            if (userAddressSelection) userAddressSelection.style.display = 'none';
            
            const addressSelect = document.getElementById('userAddressSelect');
            if (addressSelect) addressSelect.removeAttribute('required');
        }
    }
    
    calculateTotal();
}

// ===================================
// ADDRESS SELECTION
// ===================================
function initializeAddressSelection() {
    const addressSelect = document.getElementById('userAddressSelect');
    const addressPreview = document.getElementById('addressPreview');
    
    if (addressSelect) {
        addressSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                const optionText = selectedOption.textContent;
                const parts = optionText.split(' - ');
                const label = parts[0];
                const fullAddress = parts[1] || optionText;
                
                document.getElementById('addressPreviewLabel').textContent = label;
                document.getElementById('addressPreviewText').textContent = fullAddress;
                
                if (addressPreview) addressPreview.style.display = 'block';
            } else {
                if (addressPreview) addressPreview.style.display = 'none';
            }
        });
    }
}

// ===================================
// PRICE CALCULATOR (with Delivery Fee)
// ===================================
function calculateTotal() {
    const subtotal = selectedServicePrice * durationDays;
    
    let totalDeliveryFee = 0;
    if (selectedDeliveryMethod === 'pickup') {
        totalDeliveryFee = deliveryFee;
    }
    
    const subtotalWithDelivery = subtotal + totalDeliveryFee;
    const platformFee = Math.round(subtotalWithDelivery * (platformFeePercent / 100));
    const total = subtotalWithDelivery + platformFee;
    
    document.getElementById('summarySubtotal').textContent = formatCurrency(subtotal);
    
    const deliveryItem = document.getElementById('summaryDeliveryItem');
    if (totalDeliveryFee > 0) {
        deliveryItem.style.display = 'flex';
        document.getElementById('summaryDeliveryFee').textContent = formatCurrency(totalDeliveryFee);
    } else {
        deliveryItem.style.display = 'none';
    }
    
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
            clearFormErrors();
            
            let errors = [];
            
            // Validate service
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
            
            // Validate delivery method
            const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
            if (!deliveryMethod) {
                errors.push('Please select a delivery method');
            }
            
            // Validate address for pickup
            if (deliveryMethod && deliveryMethod.value === 'pickup') {
                const addressSelect = document.getElementById('userAddressSelect');
                if (addressSelect && !addressSelect.value) {
                    errors.push('Please select your address for pick-up service');
                    markFieldError('userAddressSelect');
                }
            }
            
            // Validate terms
            const termsAccepted = document.querySelector('input[name="terms_accepted"]').checked;
            if (!termsAccepted) {
                errors.push('Please accept the Terms of Service and Cancellation Policy');
            }
            
            // If errors, prevent submission
            if (errors.length > 0) {
                e.preventDefault();
                showFormErrors(errors);
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('.btn-confirm-booking');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
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
    messagesContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function clearFormErrors() {
    const messagesContainer = document.getElementById('formMessages');
    messagesContainer.innerHTML = '';
    
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

document.getElementById('bookingForm')?.addEventListener('submit', function() {
    formModified = false;
});

console.log('✅ Booking Form Complete JavaScript loaded successfully');
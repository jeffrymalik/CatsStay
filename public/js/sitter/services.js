/* ========================================
   SERVICE MANAGEMENT JAVASCRIPT - UPGRADED
   ======================================== */

// ===== TOGGLE SERVICE (AJAX) =====
function toggleService(serviceId, isEnabled) {
    const toggleSwitch = document.getElementById(`toggle-${serviceId}`);
    const originalState = toggleSwitch.checked;
    
    // Show loading toast
    const loadingToast = showToast('Updating service...', 'info', false);
    
    fetch('/pet-sitter/services/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            service_id: serviceId,
            action: 'toggle'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Remove loading toast
        if (loadingToast) loadingToast.remove();
        
        if (data.success) {
            const statusText = data.is_enabled ? 'activated' : 'deactivated';
            showToast(`Service ${statusText} successfully!`, 'success');
            
            // Update card UI
            const card = toggleSwitch.closest('.service-card');
            if (card) {
                if (data.is_enabled) {
                    card.classList.remove('disabled');
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                    card.classList.add('disabled');
                }
            }
            
            // Update toggle text
            const toggleText = toggleSwitch.parentElement.nextElementSibling;
            if (toggleText) {
                toggleText.textContent = data.is_enabled ? 'Active' : 'Inactive';
            }
        } else {
            // Revert toggle on failure
            toggleSwitch.checked = originalState;
            showToast(data.message || 'Failed to update service', 'error');
        }
    })
    .catch(error => {
        // Remove loading toast
        if (loadingToast) loadingToast.remove();
        
        console.error('Error:', error);
        // Revert toggle on error
        toggleSwitch.checked = originalState;
        showToast('Failed to update service. Please try again.', 'error');
    });
}

// ===== EDIT SERVICE =====
function editService(serviceId, serviceName, serviceSlug, description, basePrice) {
    const modal = document.getElementById('editServiceModal');
    
    // Set form values
    document.getElementById('edit_service_id').value = serviceId;
    document.getElementById('service-name-modal').textContent = serviceName;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_base_price').value = basePrice || 0;
    
    // Update character counter
    const charCount = document.getElementById('char-count');
    if (charCount) {
        const length = description ? description.length : 0;
        charCount.textContent = length;
        
        // Set color based on length
        if (length > 900) {
            charCount.style.color = '#f44336';
        } else if (length > 700) {
            charCount.style.color = '#FF9800';
        } else {
            charCount.style.color = '#4CAF50';
        }
    }
    
    // Show modal with animation
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
    
    // Focus on description
    setTimeout(() => {
        const descField = document.getElementById('edit_description');
        descField.focus();
        // Move cursor to end
        descField.setSelectionRange(descField.value.length, descField.value.length);
    }, 300);
}

// ===== CLOSE MODAL =====
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('show');
    
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// ===== MODAL EVENT LISTENERS =====
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });
    
    // Close with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });
    
    // Character counter for description
    const descriptionTextarea = document.getElementById('edit_description');
    const charCount = document.getElementById('char-count');
    
    if (descriptionTextarea && charCount) {
        descriptionTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            // Change color when approaching limit
            if (length > 900) {
                charCount.style.color = '#f44336';
            } else if (length > 700) {
                charCount.style.color = '#FF9800';
            } else {
                charCount.style.color = '#4CAF50';
            }
        });
    }
    
    // Form validation
    const editForm = document.getElementById('editServiceForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const description = document.getElementById('edit_description').value.trim();
            const basePrice = parseFloat(document.getElementById('edit_base_price').value);
            
            // Validate description
            if (!description) {
                e.preventDefault();
                showToast('Please enter a service description', 'error');
                document.getElementById('edit_description').focus();
                return false;
            }
            
            if (description.length < 20) {
                e.preventDefault();
                showToast('Description must be at least 20 characters', 'error');
                document.getElementById('edit_description').focus();
                return false;
            }
            
            // Validate price
            if (isNaN(basePrice) || basePrice < 0) {
                e.preventDefault();
                showToast('Please enter a valid price', 'error');
                document.getElementById('edit_base_price').focus();
                return false;
            }
            
            if (basePrice % 1000 !== 0) {
                e.preventDefault();
                showToast('Price must be in increments of Rp 1,000', 'error');
                document.getElementById('edit_base_price').focus();
                return false;
            }
            
            // Show loading state on submit button
            const submitBtn = editForm.querySelector('.btn-save');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }
            
            // Form will submit normally
            return true;
        });
    }
    
    // Auto-dismiss success/error messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentElement) {
                alert.style.animation = 'slideOutUp 0.3s ease';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }, 5000);
    });
});

// ===== TOAST NOTIFICATION =====
function showToast(message, type = 'success', autoHide = true) {
    // Remove existing toast
    const existingToast = document.querySelector('.toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const iconMap = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'info': 'info-circle',
        'warning': 'exclamation-triangle'
    };
    
    toast.innerHTML = `
        <i class="fas fa-${iconMap[type] || 'info-circle'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 10);
    
    // Auto hide
    if (autoHide) {
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    
    return toast;
}

// ===== FORMAT NUMBER INPUT =====
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('edit_base_price');
    
    if (priceInput) {
        // Format on blur
        priceInput.addEventListener('blur', function() {
            let value = parseInt(this.value);
            if (!isNaN(value)) {
                // Round to nearest 1000
                value = Math.round(value / 1000) * 1000;
                this.value = value;
            }
        });
        
        // Prevent negative values
        priceInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    }
});

// ===== CONFIRMATION BEFORE DISABLING SERVICE =====
const originalToggleService = window.toggleService;
window.toggleService = function(serviceId, isEnabled) {
    if (!isEnabled) {
        const confirmed = confirm('Are you sure you want to disable this service? Customers won\'t be able to book it.');
        if (!confirmed) {
            // Revert the toggle
            const toggleSwitch = document.getElementById(`toggle-${serviceId}`);
            toggleSwitch.checked = true;
            return;
        }
    }
    originalToggleService(serviceId, isEnabled);
};

// ===== INLINE STYLES =====
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
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border-left: 4px solid #4CAF50;
        min-width: 300px;
    }
    
    .toast.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast.toast-success {
        border-left-color: #4CAF50;
    }
    
    .toast.toast-success i {
        color: #4CAF50;
    }
    
    .toast.toast-error {
        border-left-color: #f44336;
    }
    
    .toast.toast-error i {
        color: #f44336;
    }
    
    .toast.toast-info {
        border-left-color: #2196F3;
    }
    
    .toast.toast-info i {
        color: #2196F3;
    }
    
    .toast.toast-warning {
        border-left-color: #FFA726;
    }
    
    .toast.toast-warning i {
        color: #FFA726;
    }
    
    .toast i {
        font-size: 20px;
    }
    
    .toast span {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        flex: 1;
    }
    
    /* Modal Animations */
    .modal {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .modal.show {
        opacity: 1;
    }
    
    .modal.show .modal-content {
        animation: slideDown 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-50px) scale(0.9);
            opacity: 0;
        }
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }
    
    @keyframes slideOutUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-20px);
            opacity: 0;
        }
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .toast {
            right: 10px;
            left: 10px;
            min-width: auto;
        }
    }
`;

// Only add styles once
if (!document.getElementById('toast-styles')) {
    toastStyles.id = 'toast-styles';
    document.head.appendChild(toastStyles);
}

console.log('%c🛠️ Service Management Loaded (Upgraded)', 'color: #FF9800; font-weight: bold; font-size: 14px;');
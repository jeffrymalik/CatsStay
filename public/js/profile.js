// ============================
// PROFILE - JAVASCRIPT
// ============================

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================
    // Edit Profile Modal (Placeholder)
    // ============================
    
    const editProfileBtn = document.querySelector('.btn-edit-profile');
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function() {
            alert('Edit Profile functionality will be implemented here.\n\nFeatures:\n• Upload photo\n• Edit name, email, phone\n• Update bio\n• Save changes');
            // TODO: Open modal or redirect to edit page
        });
    }

    // ============================
    // Edit Small Buttons (Inline or Modal)
    // ============================
    
    const editSmallBtns = document.querySelectorAll('.btn-edit-small');
    editSmallBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const section = this.closest('.profile-card, .review-card');
            const sectionTitle = section ? section.querySelector('h3')?.textContent : 'Section';
            
            alert(`Edit ${sectionTitle} functionality will be implemented here.\n\nThis will open an inline edit form or modal.`);
            // TODO: Implement inline editing or modal
        });
    });

    // ============================
    // Smooth Scroll for Sidebar (Mobile)
    // ============================
    
    const sidebar = document.querySelector('.profile-sidebar');
    if (sidebar && window.innerWidth <= 768) {
        const activeItem = sidebar.querySelector('.sidebar-item.active');
        if (activeItem) {
            // Scroll active item into view on mobile
            activeItem.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    // ============================
    // Notification Mark as Read
    // ============================
    
    const unreadNotifications = document.querySelectorAll('.notification-card.unread');
    unreadNotifications.forEach(notif => {
        notif.addEventListener('click', function() {
            // Mark as read visually
            this.classList.remove('unread');
            this.classList.add('read');
            
            const indicator = this.querySelector('.unread-indicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
            
            // Update badge count
            updateNotificationBadge();
            
            // TODO: Send AJAX request to server to mark as read
            console.log('Notification marked as read');
        });
    });

    // ============================
    // Mark All as Read
    // ============================
    
    const markAllBtn = document.querySelector('.btn-mark-all-read');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function() {
            const unreadCards = document.querySelectorAll('.notification-card.unread');
            
            unreadCards.forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                
                const indicator = card.querySelector('.unread-indicator');
                if (indicator) {
                    indicator.style.display = 'none';
                }
            });
            
            // Hide the button
            this.style.display = 'none';
            
            // Update badge
            updateNotificationBadge();
            
            // TODO: Send AJAX request to server
            console.log('All notifications marked as read');
        });
    }

    // ============================
    // Load More Notifications
    // ============================
    
    const loadMoreBtn = document.querySelector('.btn-load-more');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            this.disabled = true;
            this.textContent = 'Loading...';
            
            // Simulate loading (TODO: Replace with actual AJAX)
            setTimeout(() => {
                alert('Load more functionality will fetch older notifications from the server.');
                this.disabled = false;
                this.textContent = 'Load More Notifications';
                
                // TODO: Implement AJAX to load more notifications
            }, 1000);
        });
    }

    // ============================
    // Review Edit
    // ============================
    
    const reviewCards = document.querySelectorAll('.review-card');
    reviewCards.forEach(card => {
        const editBtn = card.querySelector('.btn-edit-small');
        if (editBtn) {
            editBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent card click
                
                const sitterName = card.querySelector('.sitter-info h3')?.textContent;
                const bookingCode = card.querySelector('.service-type')?.textContent.split('•')[1]?.trim();
                
                alert(`Edit Review\n\nSitter: ${sitterName}\nBooking: ${bookingCode}\n\nThis will open a modal to edit your review and rating.`);
                
                // TODO: Open modal with edit form
            });
        }
    });

    // ============================
    // Update Notification Badge in Sidebar
    // ============================
    
    function updateNotificationBadge() {
        const unreadCount = document.querySelectorAll('.notification-card.unread').length;
        const badge = document.querySelector('.notif-count-badge');
        
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }
        
        // Also update in navbar dropdown if exists
        const navbarBadge = document.querySelector('.dropdown-badge.message-badge-dropdown');
        if (navbarBadge && window.location.pathname.includes('notifications')) {
            // Update notification badge in navbar
            // This would need to be connected to actual notification count
        }
    }

    // ============================
    // Photo Upload Preview (Future)
    // ============================
    
    function handlePhotoUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const avatar = document.querySelector('.profile-avatar.large');
                if (avatar) {
                    // Replace avatar with uploaded image
                    avatar.style.backgroundImage = `url(${e.target.result})`;
                    avatar.style.backgroundSize = 'cover';
                    avatar.textContent = '';
                }
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ============================
    // Form Validation (Future)
    // ============================
    
    function validateProfileForm(formData) {
        const errors = [];
        
        // Validate email
        const email = formData.get('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errors.push('Please enter a valid email address');
        }
        
        // Validate phone
        const phone = formData.get('phone');
        if (phone && phone.length < 10) {
            errors.push('Please enter a valid phone number');
        }
        
        // Validate required fields
        const requiredFields = ['first_name', 'last_name'];
        requiredFields.forEach(field => {
            if (!formData.get(field) || formData.get(field).trim() === '') {
                errors.push(`${field.replace('_', ' ')} is required`);
            }
        });
        
        return errors;
    }

    // ============================
    // Show Success Message
    // ============================
    
    function showSuccessMessage(message) {
        // Create success notification
        const notification = document.createElement('div');
        notification.className = 'success-notification';
        notification.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Hide and remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ============================
    // Console Log for Development
    // ============================
    
    console.log('Profile page loaded');
    console.log('Current section:', window.location.pathname);
    
    // Log notifications count
    const notifCount = document.querySelectorAll('.notification-card').length;
    const unreadCount = document.querySelectorAll('.notification-card.unread').length;
    if (notifCount > 0) {
        console.log(`Notifications: ${notifCount} total, ${unreadCount} unread`);
    }
    
    // Log reviews count
    const reviewCount = document.querySelectorAll('.review-card').length;
    if (reviewCount > 0) {
        console.log(`Reviews: ${reviewCount} total`);
    }
});

// ============================
// Success Notification Styles (Inject)
// ============================

const style = document.createElement('style');
style.textContent = `
    .success-notification {
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(76, 175, 80, 0.3);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10000;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        font-weight: 600;
    }
    
    .success-notification svg {
        flex-shrink: 0;
    }
`;
document.head.appendChild(style);
// ============================
// CHANGE PASSWORD FUNCTIONALITY
// ============================

// Password Toggle Visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const eyeIcon = this.querySelector('.eye-icon');
        const eyeOffIcon = this.querySelector('.eye-off-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
        } else {
            input.type = 'password';
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        }
    });
});

// Password Strength Checker
const newPasswordInput = document.getElementById('new_password');
if (newPasswordInput) {
    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        const strengthIndicator = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar-fill');
        const strengthText = document.getElementById('strength-text');
        
        if (password.length > 0) {
            strengthIndicator.style.display = 'block';
            
            // Calculate strength
            let strength = 0;
            const checks = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };
            
            strength = Object.values(checks).filter(Boolean).length;
            
            // Update visual indicator
            strengthBar.className = 'strength-bar-fill';
            strengthText.className = 'strength-text';
            
            if (strength <= 2) {
                strengthBar.classList.add('weak');
                strengthText.classList.add('weak');
                strengthText.textContent = 'Weak';
            } else if (strength === 3) {
                strengthBar.classList.add('fair');
                strengthText.classList.add('fair');
                strengthText.textContent = 'Fair';
            } else if (strength === 4) {
                strengthBar.classList.add('good');
                strengthText.classList.add('good');
                strengthText.textContent = 'Good';
            } else {
                strengthBar.classList.add('strong');
                strengthText.classList.add('strong');
                strengthText.textContent = 'Strong';
            }
            
            // Update requirements list
            updateRequirements(checks);
        } else {
            strengthIndicator.style.display = 'none';
            resetRequirements();
        }
    });
}

// Update Requirements Visual Feedback
function updateRequirements(checks) {
    const requirements = {
        'req-length': checks.length,
        'req-uppercase': checks.uppercase,
        'req-lowercase': checks.lowercase,
        'req-number': checks.number
    };
    
    for (const [id, isValid] of Object.entries(requirements)) {
        const element = document.getElementById(id);
        if (element) {
            if (isValid) {
                element.classList.add('valid');
                // Change circle to checkmark
                const svg = element.querySelector('svg');
                if (svg) {
                    svg.innerHTML = '<polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                }
            } else {
                element.classList.remove('valid');
                // Reset to circle
                const svg = element.querySelector('svg');
                if (svg) {
                    svg.innerHTML = '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>';
                }
            }
        }
    }
}

// Reset Requirements
function resetRequirements() {
    const requirementIds = ['req-length', 'req-uppercase', 'req-lowercase', 'req-number'];
    requirementIds.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.classList.remove('valid');
            const svg = element.querySelector('svg');
            if (svg) {
                svg.innerHTML = '<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>';
            }
        }
    });
}

// Form Validation
const changePasswordForm = document.getElementById('change-password-form');
if (changePasswordForm) {
    changePasswordForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        // Check if passwords match
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('New password and confirmation password do not match!');
            return false;
        }
        
        // Check password requirements
        const checks = {
            length: newPassword.length >= 8,
            uppercase: /[A-Z]/.test(newPassword),
            lowercase: /[a-z]/.test(newPassword),
            number: /[0-9]/.test(newPassword)
        };
        
        const allValid = Object.values(checks).every(Boolean);
        
        if (!allValid) {
            e.preventDefault();
            alert('Please ensure your password meets all requirements!');
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('.btn-update-password');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round"/></svg> Updating...';
        }
    });
}

// Real-time Password Match Validation
const confirmPasswordInput = document.getElementById('new_password_confirmation');
if (confirmPasswordInput && newPasswordInput) {
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            if (this.value === newPasswordInput.value) {
                this.style.borderColor = '#4CAF50';
            } else {
                this.style.borderColor = '#F44336';
            }
        } else {
            this.style.borderColor = '#E0E0E0';
        }
    });
}

// Auto-hide alerts after 5 seconds
const alerts = document.querySelectorAll('.alert-success, .alert-error');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
});

// Add spin animation style
const spinStyle = document.createElement('style');
spinStyle.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
`;
document.head.appendChild(spinStyle);

console.log('Change Password functionality loaded');

// ===================================
// PROFILE ADDRESSES - JavaScript
// Handle Add, Edit, Delete, Set Primary
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile Addresses loaded');
    
    initializeAddressModal();
    initializeAddressActions();
});

// ===================================
// MODAL MANAGEMENT
// ===================================
function initializeAddressModal() {
    const modal = document.getElementById('addressModal');
    const btnAddAddress = document.getElementById('btnAddAddress');
    const btnCloseModal = document.getElementById('btnCloseModal');
    const btnCancelModal = document.getElementById('btnCancelModal');
    const addressForm = document.getElementById('addressForm');
    
    // Open modal for new address
    if (btnAddAddress) {
        btnAddAddress.addEventListener('click', function() {
            openAddressModal();
        });
    }
    
    // Close modal
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', closeAddressModal);
    }
    
    if (btnCancelModal) {
        btnCancelModal.addEventListener('click', closeAddressModal);
    }
    
    // Close on overlay click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeAddressModal();
            }
        });
    }
    
    // Handle form submission
    if (addressForm) {
        addressForm.addEventListener('submit', handleAddressSubmit);
    }
}

function openAddressModal(addressData = null) {
    const modal = document.getElementById('addressModal');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('addressForm');
    
    if (addressData) {
        // Edit mode
        modalTitle.textContent = 'Edit Address';
        document.getElementById('addressId').value = addressData.id;
        document.getElementById('addressLabel').value = addressData.label;
        document.getElementById('fullAddress').value = addressData.full_address;
        document.getElementById('city').value = addressData.city;
        document.getElementById('province').value = addressData.province;
        document.getElementById('postalCode').value = addressData.postal_code;
        document.getElementById('country').value = addressData.country;
        document.getElementById('setPrimary').checked = addressData.is_primary;
        
        // Disable "set primary" if already primary
        if (addressData.is_primary) {
            document.getElementById('setPrimary').disabled = true;
        }
    } else {
        // Add mode
        modalTitle.textContent = 'Add New Address';
        form.reset();
        document.getElementById('addressId').value = '';
        document.getElementById('country').value = 'Indonesia';
        document.getElementById('setPrimary').disabled = false;
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAddressModal() {
    const modal = document.getElementById('addressModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// ===================================
// ADDRESS ACTIONS
// ===================================
function initializeAddressActions() {
    // Edit buttons
    document.querySelectorAll('.btn-edit-address').forEach(btn => {
        btn.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            handleEditAddress(addressId);
        });
    });
    
    // Delete buttons
    document.querySelectorAll('.btn-delete-address').forEach(btn => {
        btn.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            handleDeleteAddress(addressId);
        });
    });
    
    // Set primary buttons
    document.querySelectorAll('.btn-set-primary').forEach(btn => {
        btn.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            handleSetPrimary(addressId);
        });
    });
}

function handleEditAddress(addressId) {
    // Get address data from card
    const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
    
    if (addressCard) {
        const addressData = {
            id: addressId,
            label: addressCard.querySelector('.address-label').textContent.trim(),
            full_address: addressCard.querySelector('.address-info-value').textContent.trim(),
            city: addressCard.querySelectorAll('.address-info-value')[1].textContent.trim(),
            province: addressCard.querySelectorAll('.address-info-value')[2].textContent.trim(),
            postal_code: addressCard.querySelectorAll('.address-info-value')[3].textContent.trim(),
            country: addressCard.querySelectorAll('.address-info-value')[4].textContent.trim(),
            is_primary: addressCard.querySelector('.primary-badge') !== null
        };
        
        openAddressModal(addressData);
    }
}

function handleDeleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address?')) {
        // TODO: Send AJAX request to delete address
        // For now, just show success message
        
        // Remove address card from DOM
        const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
        if (addressCard) {
            addressCard.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                addressCard.remove();
                showSuccessMessage('Address deleted successfully!');
                
                // Check if no addresses left
                if (document.querySelectorAll('.address-card').length === 0) {
                    location.reload(); // Show empty state
                }
            }, 300);
        }
        
        console.log('Delete address:', addressId);
    }
}

function handleSetPrimary(addressId) {
    if (confirm('Set this address as your primary address?')) {
        // TODO: Send AJAX request to set primary
        
        // Update UI - remove all primary badges
        document.querySelectorAll('.primary-badge').forEach(badge => {
            badge.remove();
        });
        
        document.querySelectorAll('.btn-set-primary').forEach(btn => {
            btn.style.display = 'inline-flex';
        });
        
        // Add primary badge to selected address
        const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
        if (addressCard) {
            const labelSection = addressCard.querySelector('.address-label-section > div');
            const badge = document.createElement('span');
            badge.className = 'primary-badge';
            badge.textContent = 'Primary';
            labelSection.appendChild(badge);
            
            // Hide "Set Primary" button for this address
            const setPrimaryBtn = addressCard.querySelector('.btn-set-primary');
            if (setPrimaryBtn) {
                setPrimaryBtn.style.display = 'none';
            }
            
            showSuccessMessage('Primary address updated successfully!');
        }
        
        console.log('Set primary address:', addressId);
    }
}

// ===================================
// FORM SUBMISSION
// ===================================
function handleAddressSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const addressId = formData.get('address_id');
    
    // TODO: Send AJAX request to save address
    // For now, just show success message and close modal
    
    if (addressId) {
        // Update existing address
        console.log('Update address:', addressId);
        showSuccessMessage('Address updated successfully!');
        
        // Update address card in DOM
        updateAddressCard(addressId, formData);
    } else {
        // Create new address
        console.log('Create new address');
        showSuccessMessage('Address added successfully!');
        
        // Reload page to show new address
        setTimeout(() => {
            location.reload();
        }, 1000);
    }
    
    closeAddressModal();
}

function updateAddressCard(addressId, formData) {
    const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
    
    if (addressCard) {
        // Update label
        const label = formData.get('label');
        addressCard.querySelector('.address-label').textContent = label;
        
        // Update icon based on label
        const icons = {
            'Home': 'fa-home',
            'Office': 'fa-building',
            'Other': 'fa-map-marker-alt'
        };
        const iconElement = addressCard.querySelector('.address-icon i');
        iconElement.className = `fas ${icons[label] || 'fa-map-marker-alt'}`;
        
        // Update address details
        const values = addressCard.querySelectorAll('.address-info-value');
        values[0].textContent = formData.get('full_address');
        values[1].textContent = formData.get('city');
        values[2].textContent = formData.get('province');
        values[3].textContent = formData.get('postal_code');
        values[4].textContent = formData.get('country');
        
        // Handle primary status
        if (formData.get('set_primary') === 'on') {
            // Remove all primary badges
            document.querySelectorAll('.primary-badge').forEach(badge => {
                badge.remove();
            });
            
            // Add primary badge to this address
            const labelSection = addressCard.querySelector('.address-label-section > div');
            const badge = document.createElement('span');
            badge.className = 'primary-badge';
            badge.textContent = 'Primary';
            labelSection.appendChild(badge);
            
            // Hide "Set Primary" button
            const setPrimaryBtn = addressCard.querySelector('.btn-set-primary');
            if (setPrimaryBtn) {
                setPrimaryBtn.style.display = 'none';
            }
            
            // Show "Set Primary" buttons on other addresses
            document.querySelectorAll('.btn-set-primary').forEach(btn => {
                if (btn.dataset.addressId !== addressId) {
                    btn.style.display = 'inline-flex';
                }
            });
        }
        
        // Highlight updated card
        addressCard.style.animation = 'pulse 0.5s ease';
        setTimeout(() => {
            addressCard.style.animation = '';
        }, 500);
    }
}

// ===================================
// UTILITY FUNCTIONS
// ===================================
function showSuccessMessage(message) {
    // Create or update existing success message
    let successDiv = document.querySelector('.alert-success');
    
    if (!successDiv) {
        successDiv = document.createElement('div');
        successDiv.className = 'alert-success';
        successDiv.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>${message}</span>
        `;
        
        const profileContent = document.querySelector('.profile-content');
        profileContent.insertBefore(successDiv, profileContent.children[1]);
    } else {
        successDiv.querySelector('span').textContent = message;
    }
    
    // Scroll to message
    successDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        successDiv.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => successDiv.remove(), 300);
    }, 5000);
}

// Add animations to styles
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }
    
    @keyframes slideUp {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
`;
document.head.appendChild(style);

console.log('✅ Profile Addresses JavaScript loaded successfully');
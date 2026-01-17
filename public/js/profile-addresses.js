/* ========================================
   PROFILE ADDRESSES MANAGEMENT
   ======================================== */

// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Modal Elements
const addressModal = document.getElementById('addressModal');
const btnAddAddress = document.getElementById('btnAddAddress');
const btnCloseModal = document.getElementById('btnCloseModal');
const btnCancelModal = document.getElementById('btnCancelModal');
const addressForm = document.getElementById('addressForm');
const modalTitle = document.getElementById('modalTitle');
const addressId = document.getElementById('addressId');
const formMethod = document.getElementById('formMethod');

// Open Add Address Modal
if (btnAddAddress) {
    btnAddAddress.addEventListener('click', () => {
        modalTitle.textContent = 'Add New Address';
        addressForm.reset();
        addressId.value = '';
        formMethod.value = '';
        addressForm.action = '/profile/address/store';
        addressModal.style.display = 'flex';
        
        setTimeout(() => {
            document.getElementById('addressLabel').focus();
        }, 100);
    });
}

// Close Modal
function closeModal() {
    addressModal.style.display = 'none';
    addressForm.reset();
}

if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

// Close on outside click
window.addEventListener('click', (e) => {
    if (e.target === addressModal) {
        closeModal();
    }
});

// Close on ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && addressModal.style.display === 'flex') {
        closeModal();
    }
});

// Edit Address
function editAddress(id) {
    fetch(`/profile/address/get/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const addr = data.address;
                
                modalTitle.textContent = 'Edit Address';
                addressId.value = addr.id;
                formMethod.value = 'POST';
                document.getElementById('addressLabel').value = addr.label;
                document.getElementById('fullAddress').value = addr.full_address;
                document.getElementById('city').value = addr.city;
                document.getElementById('province').value = addr.province;
                document.getElementById('postalCode').value = addr.postal_code;
                document.getElementById('setPrimary').checked = addr.is_primary;
                
                addressForm.action = `/profile/address/update/${addr.id}`;
                addressModal.style.display = 'flex';
                
                setTimeout(() => {
                    document.getElementById('addressLabel').focus();
                }, 100);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to load address data', 'error');
        });
}

// Submit Form
addressForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.btn-save');
    const originalHTML = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data && data.success) {
            showToast(data.message || 'Address saved successfully!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to save address', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHTML;
    });
});

// Set Primary Address
function setPrimary(id) {
    if (!confirm('Set this address as primary?')) return;
    
    fetch(`/profile/address/set-primary/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to update primary address', 'error');
    });
}

// Delete Address
function deleteAddress(id) {
    if (!confirm('Are you sure you want to delete this address?')) return;
    
    fetch(`/profile/address/delete/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to delete address', 'error');
    });
}

// Toast Notification
function showToast(message, type = 'success') {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) {
        existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    const iconMap = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    
    toast.innerHTML = `
        <i class="fas ${iconMap[type]}"></i>
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

// Toast styles
if (!document.getElementById('toast-styles')) {
    const toastStyles = document.createElement('style');
    toastStyles.id = 'toast-styles';
    toastStyles.textContent = `
        .toast-notification {
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
            border-left: 4px solid #4CAF50;
            min-width: 300px;
        }
        .toast-notification.show {
            transform: translateX(0);
            opacity: 1;
        }
        .toast-notification.toast-success {
            border-left-color: #4CAF50;
        }
        .toast-notification.toast-success i {
            color: #4CAF50;
        }
        .toast-notification.toast-error {
            border-left-color: #f44336;
        }
        .toast-notification.toast-error i {
            color: #f44336;
        }
        .toast-notification i {
            font-size: 20px;
        }
        .toast-notification span {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        @media (max-width: 768px) {
            .toast-notification {
                right: 10px;
                left: 10px;
                min-width: auto;
            }
        }
    `;
    document.head.appendChild(toastStyles);
}

console.log('%c📍 Profile Addresses Loaded', 'color: #FF9800; font-weight: bold;');
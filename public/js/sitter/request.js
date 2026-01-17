/* ========================================
   BOOKING REQUESTS PAGE JAVASCRIPT
   ======================================== */

// ===== DOM CONTENT LOADED =====
document.addEventListener('DOMContentLoaded', function() {
    initSearch();
    initSort();
});

// ===== SEARCH FUNCTIONALITY =====
function initSearch() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const requestCards = document.querySelectorAll('.request-card');

        requestCards.forEach(card => {
            const userName = card.querySelector('.user-details h3').textContent.toLowerCase();
            const bookingCode = card.querySelector('.booking-code').textContent.toLowerCase();
            const serviceType = card.querySelector('.info-item .value').textContent.toLowerCase();

            if (userName.includes(searchTerm) || bookingCode.includes(searchTerm) || serviceType.includes(searchTerm)) {
                card.style.display = 'block';
                // Add fade in animation
                card.style.animation = 'fadeIn 0.3s ease';
            } else {
                card.style.display = 'none';
            }
        });

        // Show empty state if no results
        checkEmptyState(searchTerm);
    });
}

function checkEmptyState(searchTerm) {
    const requestsList = document.getElementById('requestsList');
    const visibleCards = document.querySelectorAll('.request-card[style*="display: block"]');
    const existingEmptySearch = document.getElementById('emptySearchState');

    if (searchTerm && visibleCards.length === 0) {
        if (!existingEmptySearch) {
            const emptyState = document.createElement('div');
            emptyState.id = 'emptySearchState';
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <i class="fas fa-search"></i>
                <h3>No Results Found</h3>
                <p>No requests match your search for "<strong>${searchTerm}</strong>"</p>
            `;
            requestsList.appendChild(emptyState);
        }
    } else if (existingEmptySearch) {
        existingEmptySearch.remove();
    }
}

// ===== SORT FUNCTIONALITY =====
function initSort() {
    const sortSelect = document.getElementById('sortSelect');
    if (!sortSelect) return;

    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const requestsList = document.getElementById('requestsList');
        const requestCards = Array.from(document.querySelectorAll('.request-card'));

        // Sort cards
        requestCards.sort((a, b) => {
            switch(sortValue) {
                case 'newest':
                    return b.dataset.requestId - a.dataset.requestId;
                
                case 'oldest':
                    return a.dataset.requestId - b.dataset.requestId;
                
                case 'price-high':
                    const priceA = parseInt(a.querySelector('.pricing-row.total .pricing-value').textContent.replace(/\D/g, ''));
                    const priceB = parseInt(b.querySelector('.pricing-row.total .pricing-value').textContent.replace(/\D/g, ''));
                    return priceB - priceA;
                
                case 'price-low':
                    const priceA2 = parseInt(a.querySelector('.pricing-row.total .pricing-value').textContent.replace(/\D/g, ''));
                    const priceB2 = parseInt(b.querySelector('.pricing-row.total .pricing-value').textContent.replace(/\D/g, ''));
                    return priceA2 - priceB2;
                
                default:
                    return 0;
            }
        });

        // Remove and re-append in sorted order
        requestCards.forEach(card => {
            requestsList.appendChild(card);
            // Add animation
            card.style.animation = 'slideInUp 0.4s ease';
        });
    });
}

// ===== REJECT MODAL =====
let currentRejectRequestId = null;

function showRejectModal(requestId) {
    currentRejectRequestId = requestId;
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    // Set form action
    form.action = `/pet-sitter/requests/${requestId}/reject`;
    
    // Clear textarea
    document.getElementById('rejectReason').value = '';
    
    // Show modal
    modal.classList.add('show');
    
    // Focus on textarea
    setTimeout(() => {
        document.getElementById('rejectReason').focus();
    }, 100);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('show');
    currentRejectRequestId = null;
}

// Close modal when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRejectModal();
    }
});

// ===== VIEW REQUEST DETAILS =====
function viewRequestDetails(requestId) {
    // For now, scroll to the card and highlight it
    const card = document.querySelector(`[data-request-id="${requestId}"]`);
    
    if (card) {
        // Scroll to card
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Add highlight effect
        card.style.boxShadow = '0 0 0 4px rgba(255, 152, 0, 0.3)';
        setTimeout(() => {
            card.style.boxShadow = '';
        }, 2000);
    }
    
    // TODO: In future, open a detailed modal or navigate to detail page
    // window.location.href = `/pet-sitter/requests/${requestId}/detail`;
}

// ===== ANIMATIONS CSS (Add to page) =====
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
`;
document.head.appendChild(animationStyles);

// ===== ACCEPT REQUEST CONFIRMATION =====
document.querySelectorAll('.btn-accept').forEach(button => {
    button.addEventListener('click', function(e) {
        const form = this.closest('form');
        
        // Add loading state
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Accepting...';
        
        // Let form submit naturally
    });
});

// ===== UTILITY FUNCTIONS =====
function formatPrice(price) {
    return 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
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

    .toast span {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }
`;
document.head.appendChild(toastStyles);

// ===== LOG INITIALIZATION =====
console.log('%c📋 Booking Requests Page Loaded', 'color: #FF9800; font-size: 14px; font-weight: bold;');
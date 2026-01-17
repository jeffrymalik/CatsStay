// ==========================================
// REQUEST DETAIL PAGE JAVASCRIPT
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    initializeDetailPage();
});

function initializeDetailPage() {
    // Initialize review photo lightbox if exists
    initPhotoLightbox();
    
    // Initialize smooth scroll for long content
    initSmoothScroll();
}

// ==========================================
// ACCEPT CONFIRMATION
// ==========================================

function confirmAccept() {
    return confirm(
        'Are you sure you want to accept this booking request?\n\n' +
        'By accepting, you confirm that:\n' +
        '✓ You are available for the scheduled dates\n' +
        '✓ You can accommodate the cat\'s needs\n' +
        '✓ You agree to the service terms\n\n' +
        'This action cannot be undone.'
    );
}

// ==========================================
// REJECT MODAL
// ==========================================

function showRejectModal(requestId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    // Update form action with request ID
    form.action = `/pet-sitter/requests/${requestId}/reject`;
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
    
    // Reset form
    document.getElementById('rejectForm').reset();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('rejectModal');
    if (e.target === modal) {
        closeRejectModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRejectModal();
    }
});

// ==========================================
// PHOTO LIGHTBOX
// ==========================================

function initPhotoLightbox() {
    const reviewPhotos = document.querySelectorAll('.review-photo');
    
    if (reviewPhotos.length === 0) return;
    
    reviewPhotos.forEach(photo => {
        photo.addEventListener('click', function() {
            openLightbox(this.src);
        });
    });
}

function openLightbox(imageSrc) {
    // Create lightbox
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = `
        <div class="lightbox-content">
            <button class="lightbox-close">&times;</button>
            <img src="${imageSrc}" alt="Review photo">
        </div>
    `;
    
    document.body.appendChild(lightbox);
    document.body.style.overflow = 'hidden';
    
    // Close lightbox
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox || e.target.className === 'lightbox-close') {
            document.body.removeChild(lightbox);
            document.body.style.overflow = 'auto';
        }
    });
}

// Add lightbox styles dynamically
const lightboxStyles = `
    .lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }
    
    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
    }
    
    .lightbox-content img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 8px;
    }
    
    .lightbox-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        color: #333;
        transition: all 0.3s ease;
    }
    
    .lightbox-close:hover {
        background: #FF9800;
        color: white;
        transform: rotate(90deg);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = lightboxStyles;
document.head.appendChild(styleSheet);

// ==========================================
// SMOOTH SCROLL
// ==========================================

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ==========================================
// PRINT FUNCTIONALITY (Optional)
// ==========================================

function printRequest() {
    window.print();
}

// ==========================================
// CONTACT ACTIONS
// ==========================================

document.querySelectorAll('.btn-contact-action.message').forEach(btn => {
    btn.addEventListener('click', function() {
        alert('Message functionality will be available soon!');
        // TODO: Implement messaging system
    });
});

// ==========================================
// UTILITY FUNCTIONS
// ==========================================

// Copy booking code to clipboard
function copyBookingCode() {
    const bookingCode = document.querySelector('.booking-code').textContent;
    navigator.clipboard.writeText(bookingCode).then(() => {
        showNotification('Booking code copied to clipboard!');
    });
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4CAF50;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 99999;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add notification animations
const notifStyles = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;

const notifStyleSheet = document.createElement('style');
notifStyleSheet.textContent = notifStyles;
document.head.appendChild(notifStyleSheet);
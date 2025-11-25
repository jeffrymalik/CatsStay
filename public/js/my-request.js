// ===================================
// MY REQUEST - JAVASCRIPT
// ===================================

let currentBookingId = null;

// Cancel Booking Modal Functions
function cancelBooking(bookingId) {
    currentBookingId = bookingId;
    const modal = document.getElementById('cancelModal');
    modal.classList.add('active');
    
    // Clear previous input
    document.getElementById('cancelReason').value = '';
}

function closeCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.remove('active');
    currentBookingId = null;
}

function confirmCancel() {
    const reason = document.getElementById('cancelReason').value.trim();
    
    if (!reason) {
        alert('Please provide a reason for cancellation');
        return;
    }
    
    // TODO: In real implementation, send AJAX request to server
    console.log('Cancelling booking:', currentBookingId, 'Reason:', reason);
    
    // For now, just show success message and reload
    alert('Booking cancelled successfully');
    closeCancelModal();
    
    // Reload page to show updated status
    // In real implementation, update UI dynamically
    window.location.reload();
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('cancelModal');
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeCancelModal();
            }
        });
    }
    
    // Handle ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('active')) {
            closeCancelModal();
        }
    });
});

// Filter animations (smooth scroll to top when changing filter)
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            // Optional: Add loading animation
            const bookingsGrid = document.querySelector('.bookings-grid');
            if (bookingsGrid) {
                bookingsGrid.style.opacity = '0.5';
            }
        });
    });
});

// Smooth scroll for back button
document.addEventListener('DOMContentLoaded', function() {
    const backButton = document.querySelector('.back-button');
    
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            // Optional: Add transition animation
            document.body.style.opacity = '0.95';
        });
    }
});

// Card hover effects enhancement
document.addEventListener('DOMContentLoaded', function() {
    const bookingCards = document.querySelectorAll('.booking-card');
    
    bookingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });
});

// Auto-dismiss notifications (if implemented)
function showNotification(message, type = 'success') {
    // TODO: Implement notification system
    console.log(`[${type.toUpperCase()}] ${message}`);
}

// Format price display
function formatPrice(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// Calculate days between dates
function calculateDays(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const diffTime = Math.abs(end - start);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays + 1; // Include both start and end date
}

// Status badge color helper
function getStatusColor(status) {
    const colors = {
        'pending': '#FFA726',
        'confirmed': '#66BB6A',
        'in_progress': '#42A5F5',
        'completed': '#9E9E9E',
        'cancelled': '#EF5350'
    };
    return colors[status] || '#9E9E9E';
}

// Export for potential future use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        cancelBooking,
        closeCancelModal,
        confirmCancel,
        formatPrice,
        calculateDays,
        getStatusColor
    };
}
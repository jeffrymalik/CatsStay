// Find Sitter JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // ================ Elements ================
    const filterBtn = document.getElementById('filterBtn');
    const filterPanel = document.getElementById('filterPanel');
    const closeFilterBtn = document.getElementById('closeFilterBtn');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const clearFilterBtn = document.getElementById('clearFilterBtn');
    const filterBadge = document.getElementById('filterBadge');
    
    const searchInput = document.getElementById('searchInput');
    const locationFilter = document.getElementById('locationFilter');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const verifiedOnly = document.getElementById('verifiedOnly');
    const experienceCheckboxes = document.querySelectorAll('.experience-checkbox');
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    const ratingRadios = document.querySelectorAll('input[name="rating"]');
    
    const sortBy = document.getElementById('sortBy');
    const sittersGrid = document.getElementById('sittersGrid');
    const resultCount = document.getElementById('resultCount');
    
    const favoriteBtns = document.querySelectorAll('.favorite-btn');

    // ================ Filter Panel Toggle ================
    if (filterBtn && filterPanel) {
        filterBtn.addEventListener('click', function() {
            filterPanel.classList.toggle('active');
        });
    }

    if (closeFilterBtn) {
        closeFilterBtn.addEventListener('click', function() {
            filterPanel.classList.remove('active');
        });
    }

    // ================ Filter Badge Count ================
    function updateFilterBadge() {
        let count = 0;

        // Check service
        const checkedServices = document.querySelectorAll('.service-checkbox:checked');
        if (checkedServices.length > 0) count++;

        // Check location
        if (locationFilter && locationFilter.value) count++;
        
        // Check price range
        if ((minPrice && minPrice.value) || (maxPrice && maxPrice.value)) count++;
        
        // Check rating
        const checkedRating = document.querySelector('input[name="rating"]:checked');
        if (checkedRating) count++;
        
        // Check experience
        const checkedExperience = document.querySelectorAll('.experience-checkbox:checked');
        if (checkedExperience.length > 0) count++;
        
        // Check verified
        if (verifiedOnly && verifiedOnly.checked) count++;

        if (filterBadge) {
            if (count > 0) {
                filterBadge.textContent = count;
                filterBadge.style.display = 'block';
            } else {
                filterBadge.style.display = 'none';
            }
        }
    }

    // ================ Apply Filters ================
    if (applyFilterBtn) {
        applyFilterBtn.addEventListener('click', function() {
            applyFilters();
            updateFilterBadge();
            filterPanel.classList.remove('active');
        });
    }

    function applyFilters() {
        const cards = document.querySelectorAll('.sitter-card');
        let visibleCount = 0;

        cards.forEach(card => {
            let show = true;

            // Service filter
            const checkedServices = document.querySelectorAll('.service-checkbox:checked');
            if (checkedServices.length > 0) {
                const cardServices = card.getAttribute('data-services');
                let matchService = false;
                
                checkedServices.forEach(checkbox => {
                    if (cardServices && cardServices.includes(checkbox.value)) {
                        matchService = true;
                    }
                });

                if (!matchService) {
                    show = false;
                }
            }

            // Location filter
            if (locationFilter && locationFilter.value) {
                const cardLocation = card.getAttribute('data-location');
                if (cardLocation !== locationFilter.value) {
                    show = false;
                }
            }

            // Price filter
            const cardPrice = parseInt(card.getAttribute('data-price'));
            if (minPrice && minPrice.value) {
                if (cardPrice < parseInt(minPrice.value)) {
                    show = false;
                }
            }
            if (maxPrice && maxPrice.value) {
                if (cardPrice > parseInt(maxPrice.value)) {
                    show = false;
                }
            }

            // Rating filter
            const checkedRating = document.querySelector('input[name="rating"]:checked');
            if (checkedRating) {
                const cardRating = parseFloat(card.getAttribute('data-rating'));
                const minRating = parseFloat(checkedRating.value);
                if (cardRating < minRating) {
                    show = false;
                }
            }

            // Experience filter
            const checkedExperience = document.querySelectorAll('.experience-checkbox:checked');
            if (checkedExperience.length > 0) {
                const cardExperience = parseInt(card.getAttribute('data-experience'));
                let matchExperience = false;
                
                checkedExperience.forEach(checkbox => {
                    const minExp = parseInt(checkbox.value);
                    if (cardExperience >= minExp) {
                        matchExperience = true;
                    }
                });

                if (!matchExperience) {
                    show = false;
                }
            }

            // Verified filter
            if (verifiedOnly && verifiedOnly.checked) {
                const isVerified = card.getAttribute('data-verified');
                if (isVerified !== 'true') {
                    show = false;
                }
            }

            // Show/hide card
            if (show) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update result count
        if (resultCount) {
            resultCount.textContent = visibleCount;
        }
    }

    // ================ Clear All Filters ================
    if (clearFilterBtn) {
        clearFilterBtn.addEventListener('click', function() {
            // Reset all filter inputs
            if (locationFilter) locationFilter.value = '';
            if (minPrice) minPrice.value = '';
            if (maxPrice) maxPrice.value = '';
            if (verifiedOnly) verifiedOnly.checked = false;
            
            serviceCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            experienceCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            ratingRadios.forEach(radio => {
                radio.checked = false;
            });

            // Show all cards
            const cards = document.querySelectorAll('.sitter-card');
            cards.forEach(card => {
                card.style.display = 'block';
            });

            // Update count
            if (resultCount) {
                resultCount.textContent = cards.length;
            }

            // Update badge
            updateFilterBadge();

            // Close filter panel
            if (filterPanel) {
                filterPanel.classList.remove('active');
            }
        });
    }

    // ================ Search Functionality ================
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.sitter-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.querySelector('.sitter-card-name').textContent.toLowerCase();
                const location = card.querySelector('.sitter-card-location').textContent.toLowerCase();
                const bio = card.querySelector('.sitter-bio').textContent.toLowerCase();

                if (name.includes(searchTerm) || location.includes(searchTerm) || bio.includes(searchTerm)) {
                    // Only show if not filtered out
                    if (card.style.display !== 'none' || searchTerm === '') {
                        card.style.display = 'block';
                        visibleCount++;
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            if (resultCount) {
                resultCount.textContent = visibleCount;
            }
        });
    }

    // ================ Sort Functionality ================
    if (sortBy && sittersGrid) {
        sortBy.addEventListener('change', function() {
            const sortValue = this.value;
            const cards = Array.from(document.querySelectorAll('.sitter-card'));

            cards.sort((a, b) => {
                switch(sortValue) {
                    case 'rating':
                        return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
                    
                    case 'price-low':
                        return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
                    
                    case 'price-high':
                        return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
                    
                    case 'experience':
                        return parseInt(b.getAttribute('data-experience')) - parseInt(a.getAttribute('data-experience'));
                    
                    case 'reviews':
                        const reviewsA = parseInt(a.querySelector('.rating-text').textContent.match(/\((\d+)\)/)[1]);
                        const reviewsB = parseInt(b.querySelector('.rating-text').textContent.match(/\((\d+)\)/)[1]);
                        return reviewsB - reviewsA;
                    
                    default: // recommended
                        return 0;
                }
            });

            // Re-append sorted cards
            cards.forEach(card => {
                sittersGrid.appendChild(card);
            });
        });
    }

    // ================ Favorite Functionality ================
    favoriteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            
            const sitterId = this.getAttribute('data-sitter-id');
            
            // Here you would typically make an AJAX call to save/remove favorite
            // Example:
            // fetch('/api/favorites/toggle', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            //     },
            //     body: JSON.stringify({ sitter_id: sitterId })
            // });

            // Visual feedback
            if (this.classList.contains('active')) {
                showNotification('Added to favorites!');
            } else {
                showNotification('Removed from favorites');
            }
        });
    });

    // ================ Helper: Show Notification ================
    function showNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification-toast';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #FFA726 0%, #FF9800 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(255, 167, 38, 0.3);
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Add animation styles
    if (!document.getElementById('notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
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
        document.head.appendChild(style);
    }

    // ================ Initial Setup ================
    updateFilterBadge();
});
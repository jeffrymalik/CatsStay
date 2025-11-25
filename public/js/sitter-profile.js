// ===================================
// SITTER PROFILE - JavaScript
// Gallery Lightbox & Interactive Features
// ===================================

// Gallery photos array (will be populated from blade)
let galleryPhotos = [];
let currentPhotoIndex = 0;

// Initialize gallery photos on page load
document.addEventListener('DOMContentLoaded', function() {
    // Get all gallery images
    const galleryItems = document.querySelectorAll('.gallery-item img');
    galleryPhotos = Array.from(galleryItems).map(img => img.src);
    
    console.log('Sitter Profile page loaded');
    console.log('Gallery photos:', galleryPhotos.length);
});

// ===================================
// LIGHTBOX FUNCTIONS
// ===================================

function openLightbox(index) {
    currentPhotoIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    
    if (galleryPhotos[index]) {
        lightboxImg.src = galleryPhotos[index];
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

function changeLightboxImage(direction) {
    currentPhotoIndex += direction;
    
    // Loop around if at the end or beginning
    if (currentPhotoIndex >= galleryPhotos.length) {
        currentPhotoIndex = 0;
    } else if (currentPhotoIndex < 0) {
        currentPhotoIndex = galleryPhotos.length - 1;
    }
    
    const lightboxImg = document.getElementById('lightbox-img');
    lightboxImg.src = galleryPhotos[currentPhotoIndex];
}

// Keyboard navigation for lightbox
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    
    if (lightbox.classList.contains('active')) {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            changeLightboxImage(-1);
        } else if (e.key === 'ArrowRight') {
            changeLightboxImage(1);
        }
    }
});

// ===================================
// SMOOTH SCROLL TO SECTIONS
// ===================================

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// ===================================
// LOAD MORE REVIEWS
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.querySelector('.btn-load-more');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // In real implementation, this would fetch more reviews via AJAX
            alert('Loading more reviews... (This will be implemented with backend)');
            
            // Example: You could add animation or loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            
            // Simulate loading
            setTimeout(() => {
                this.innerHTML = 'Load More Reviews';
                alert('More reviews loaded!');
            }, 1500);
        });
    }
});

// ===================================
// SEND MESSAGE BUTTON
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    const messageBtn = document.querySelector('.btn-message');
    
    if (messageBtn) {
        messageBtn.addEventListener('click', function() {
            // In real implementation, this would open a message modal or redirect to messages page
            alert('Message feature coming soon! You will be able to chat with the sitter.');
        });
    }
});

// ===================================
// STICKY CTA CARD ON MOBILE
// ===================================

function handleStickyCard() {
    const ctaCard = document.querySelector('.cta-card');
    const heroRight = document.querySelector('.hero-right');
    
    if (window.innerWidth <= 968 && ctaCard) {
        // Remove sticky behavior on mobile/tablet
        heroRight.style.position = 'static';
    } else if (ctaCard) {
        // Restore sticky behavior on desktop
        heroRight.style.position = 'sticky';
    }
}

// Run on load and resize
window.addEventListener('load', handleStickyCard);
window.addEventListener('resize', handleStickyCard);

// ===================================
// ANIMATE ON SCROLL (Optional enhancement)
// ===================================

function animateOnScroll() {
    const elements = document.querySelectorAll('.service-card, .review-card, .gallery-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    entry.target.style.transition = 'all 0.5s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);
                
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });
    
    elements.forEach(element => {
        observer.observe(element);
    });
}

// Initialize animations when page loads
document.addEventListener('DOMContentLoaded', animateOnScroll);

// ===================================
// BOOK NOW BUTTON - Scroll to top on mobile
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    const bookNowBtn = document.querySelector('.btn-book-now');
    
    if (bookNowBtn && window.innerWidth <= 640) {
        bookNowBtn.addEventListener('click', function(e) {
            // Smooth scroll to top before redirect (for better UX)
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});

console.log('✅ Sitter Profile JavaScript loaded successfully');
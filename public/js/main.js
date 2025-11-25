// ===============================================
// NAVBAR - COMPLETE JAVASCRIPT (UPDATED)
// Replace your entire main.js with this
// ===============================================

const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const body = document.body;

// Function to toggle menu (UPDATED - No body scroll lock)
function toggleMenu() {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    
    // REMOVED: body.style.overflow control
    // Mobile menu now scrolls independently
}

// Function to close menu
function closeMenu() {
    hamburger.classList.remove('active');
    mobileMenu.classList.remove('active');
    // REMOVED: body.style.overflow = 'auto'
}

// Hamburger click event
hamburger.addEventListener('click', toggleMenu);

// Close mobile menu when clicking outside (UPDATED - only close on backdrop)
mobileMenu.addEventListener('click', (e) => {
    // Only close if clicking the backdrop, not the content
    if (e.target === mobileMenu) {
        closeMenu();
    }
});

// Close mobile menu when clicking a menu item
const mobileMenuLinks = document.querySelectorAll('.mobile-nav-menu a');
mobileMenuLinks.forEach(link => {
    link.addEventListener('click', closeMenu);
});

// Smooth scroll for buttons (optional)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

// Sticky Navbar with Scroll Effect
const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// ================ User Menu Dropdown Toggle ================
document.addEventListener('DOMContentLoaded', function() {
  const userMenuBtn = document.getElementById('userMenuBtn');
  const userDropdown = document.getElementById('userDropdown');

  // Toggle User Dropdown
  if (userMenuBtn && userDropdown) {
    userMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
      userMenuBtn.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove('show');
        userMenuBtn.classList.remove('active');
      }
    });

    // Close dropdown when window scrolls
    window.addEventListener('scroll', function() {
      if (userDropdown.classList.contains('show')) {
        userDropdown.classList.remove('show');
        userMenuBtn.classList.remove('active');
      }
    });

    // Close dropdown when mobile menu opens
    if (hamburger) {
      hamburger.addEventListener('click', function() {
        if (userDropdown.classList.contains('show')) {
          userDropdown.classList.remove('show');
          userMenuBtn.classList.remove('active');
        }
      });
    }
  }
});
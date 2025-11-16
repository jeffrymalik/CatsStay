<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/jepi.css')}}">
  <title>Document</title>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <img src="images/logo.png" alt="CatStay Logo">
      <span>CATS STAY</span>
    </div>

    <ul class="nav-menu" id="navMenu">
      <li><a href="#" class="active">Home</a></li>
      <li><a href="#">About Us</a></li>
      <li><a href="/dash">Cat Care</a></li>
      <li><a href="#">Contact</a></li>
    </ul>

    <div class="nav-buttons" id="navButtons">
      <button class="nav-btn btn-signin">Sign In</button>
      <button class="nav-btn btn-signup">Sign Up</button>
    </div>

    <div class="hamburger" id="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </div>

  </nav>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-content">
      <ul class="mobile-nav-menu">
        <li><a href="#" class="active">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Cat Core</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <div class="mobile-nav-buttons">
        <button class="nav-btn btn-signin">Sign In</button>
        <button class="nav-btn btn-signup">Sign Up</button>
      </div>
    </div>
  </div>
  

  <div class="hero-container">
    <div class="header-wrapper">
      <img class="paw-icon" src="images/Group1.svg" alt="">
        <h1 class="hero-title">
            <span class="title-line1">Welcome to <span class="highlight-orange">Cats</span> Stay</span>
        </h1>
        
      <img class="paw-icon" src="images/Group.svg" alt="">
    </div>
    
    <h2 class="hero-title title-line2">
        Your <span class="highlight-yellow">Cats</span> Second <span class="highlight-yellow">Home</span>!
    </h2>
    
    <p class="hero-subtitle">
        At Cats Stay, we make sure every cat feels safe, loved, and comfortable just like home.<br>
        The perfect place for your furry friend while you're away.
    </p>
    
    <div class="hero-buttons">
        <button class="btn btn-primary">Read More</button>
        <button class="btn btn-secondary">
            <div class="play-icon"></div>
            Watch Video
        </button>
    </div>
    
    <div class="cats-showcase">
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500&h=500&fit=crop" alt="Cat with blue background">
        </div>
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=500&h=500&fit=crop" alt="Orange cat with yellow background">
        </div>
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=500&fit=crop" alt="Tabby cat">
        </div>
    </div>
</div>

<!-- Service Section - Tambahkan setelah </div> penutup hero-container -->
<section class="service-section">
  <div class="service-container">
    <!-- Left Side - Title and Description -->
    <div class="service-left">
      <div class="paw-decoration">
        <img src="images/Group.svg" alt="paw" class="paw paw-1">
        <img src="images/Group.svg" alt="paw" class="paw paw-2">
        <img src="images/Group.svg" alt="paw" class="paw paw-3">
        <img src="images/Group.svg" alt="paw" class="paw paw-4">
      </div>

      <div class="service-content">
        <h3 class="service-subtitle">OUR SERVICES</h3>
        <h2 class="service-title">A Haven of Indulgence and Customized Pet Services</h2>
        <p class="service-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="paw-decoration paw-bottom">
        <img src="images/Group.svg" alt="paw" class="paw paw-5">
        <img src="images/Group.svg" alt="paw" class="paw paw-6">
        <img src="images/Group.svg" alt="paw" class="paw paw-7">
        <img src="images/Group.svg" alt="paw" class="paw paw-8">
      </div>
    </div>

    <!-- Right Side - Service Cards -->
    <div class="service-right">
      <div class="service-card">
        <div class="service-icon">
          <img src="images/pet-house.svg" alt="Cat Boarding">
        </div>
        <h4 class="service-card-title">Cat Boarding</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="service-card">
        <div class="service-icon">
          <img src="images/Cat-Grooming.svg" alt="Cat Grooming">
        </div>
        <h4 class="service-card-title">Cat Grooming</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="service-card service-card-center">
        <div class="service-icon">
          <img src="images/Cat-sitter.png" alt="Cat Sitter">
        </div>
        <h4 class="service-card-title">Cat Sitter</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Sitter Section - Tambahkan setelah penutup </section> dari service-section -->
<section class="sitter-section">
  <div class="sitter-container">
    <h2 class="sitter-title">OUR SITTER</h2>
    
    <div class="sitter-grid">
      <!-- Sitter Card 1 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1529257414772-1960b7bea4eb?w=500&h=400&fit=crop" alt="Anggara with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Anggara" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Anggara</h4>
                <span class="sitter-rating">4.5 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 2 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=400&fit=crop" alt="Nazar with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" alt="Nazar" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Nazar</h4>
                <span class="sitter-rating">5.0 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 3 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1573865526739-10c1de0ace9d?w=500&h=400&fit=crop" alt="Rifa with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&h=100&fit=crop" alt="Rifa" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Rifa</h4>
                <span class="sitter-rating">4.8 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 4 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=500&h=400&fit=crop" alt="Halim with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&h=100&fit=crop" alt="Halim" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Halim</h4>
                <span class="sitter-rating">4.9 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>
    </div>

    <!-- See All Button -->
    <div class="sitter-footer">
      <a href="#" class="btn-see-all">
        See All
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- Footer Section - Tambahkan sebelum penutup </body> -->
<footer class="footer">
  <div class="footer-container">
    <!-- Left Side - Logo & Copyright -->
    <div class="footer-left">
      <div class="footer-logo">
        <img src="images/logo.png" alt="CatStay Logo">
        <span>CATS STAY</span>
      </div>
      <p class="footer-copyright">© 2025 Cats Stay. All Rights Reserved.</p>
    </div>

    <!-- Right Side - Social Media -->
    <div class="footer-right">
      <a href="#" class="social-link" aria-label="Facebook">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 2H15C13.6739 2 12.4021 2.52678 11.4645 3.46447C10.5268 4.40215 10 5.67392 10 7V10H7V14H10V22H14V14H17L18 10H14V7C14 6.73478 14.1054 6.48043 14.2929 6.29289C14.4804 6.10536 14.7348 6 15 6H18V2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <a href="#" class="social-link" aria-label="Instagram">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M16 11.37C16.1234 12.2022 15.9813 13.0522 15.5938 13.799C15.2063 14.5458 14.5931 15.1514 13.8416 15.5297C13.0901 15.9079 12.2384 16.0396 11.4077 15.9059C10.5771 15.7723 9.80976 15.3801 9.21484 14.7852C8.61992 14.1902 8.22773 13.4229 8.09407 12.5923C7.9604 11.7616 8.09207 10.9099 8.47033 10.1584C8.84859 9.40685 9.45419 8.79374 10.201 8.40624C10.9478 8.01874 11.7978 7.87658 12.63 8C13.4789 8.12588 14.2649 8.52146 14.8717 9.1283C15.4785 9.73515 15.8741 10.5211 16 11.37Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M17.5 6.5H17.51" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <a href="#" class="social-link" aria-label="Twitter">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M23 3.00005C22.0424 3.67552 20.9821 4.19216 19.86 4.53005C19.2577 3.83756 18.4573 3.34674 17.567 3.12397C16.6767 2.90121 15.7395 2.95724 14.8821 3.28445C14.0247 3.61166 13.2884 4.19445 12.773 4.95376C12.2575 5.71308 11.9877 6.61238 12 7.53005V8.53005C10.2426 8.57561 8.50127 8.18586 6.93101 7.39549C5.36074 6.60513 4.01032 5.43868 3 4.00005C3 4.00005 -1 13 8 17C5.94053 18.398 3.48716 19.099 1 19C10 24 21 19 21 7.50005C20.9991 7.2215 20.9723 6.94364 20.92 6.67005C21.9406 5.66354 22.6608 4.39276 23 3.00005Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
</footer>

</body>
<script>
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const body = document.body;

// Function to toggle menu and body scroll
function toggleMenu() {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    
    // Disable/Enable body scroll
    if (mobileMenu.classList.contains('active')) {
        body.style.overflow = 'hidden';
    } else {
        body.style.overflow = 'auto';
    }
}

// Function to close menu
function closeMenu() {
    hamburger.classList.remove('active');
    mobileMenu.classList.remove('active');
    body.style.overflow = 'auto';
}

// Hamburger click event
hamburger.addEventListener('click', toggleMenu);

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
        if (mobileMenu.classList.contains('active')) {
            closeMenu();
        }
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
</script>
</html>
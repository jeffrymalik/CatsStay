<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Care - Cats Stay</title>
    <link rel="stylesheet" href="css/catcare.css">
</head>
<body>
    <!-- NavBar -->
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

    <!-- Main Content -->
    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section" id="filterSection">
            <div class="filter-row">
                <div class="filter-item">
                    <label>Lokasi</label>
                    <select>
                        <option>Jakarta Selatan</option>
                        <option>Jakarta Pusat</option>
                        <option>Jakarta Utara</option>
                        <option>Jakarta Barat</option>
                        <option>Jakarta Timur</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Dari</label>
                    <input type="text" placeholder="20 Okt" value="20 Okt">
                </div>
                <div class="filter-item">
                    <label>Sampai</label>
                    <input type="text" placeholder="24 Okt" value="24 Okt">
                </div>
                <button class="btn btn-find">Find a sitter</button>
            </div>
        </div>

        <!-- Detail Page -->
        <div class="detail-page" id="detailPage">
            <button class="back-btn" onclick="showCards()">← Back</button>
            
            <div class="profile-section">
                <div class="profile-left">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop" alt="Profile" class="profile-image" id="detailProfileImage">
                </div>
                <div class="profile-right">
                    <h1 class="profile-name" id="detailName">Anggara</h1>
                    <div class="profile-info">
                        <div class="info-item">
                            <span class="info-icon">📝</span>
                            <span id="detailReviews">50 reviews complete</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">💳</span>
                            <span>Rp.60.000/Days</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">📅</span>
                            <span>Gabung dari October 15, 2020</span>
                        </div>
                        <div class="info-item">
                            <span class="stars">★★★★★</span>
                            <span>(50 Reviews)</span>
                        </div>
                        <div class="info-item">
                            <span class="location-tag">📍 Depok, Jawa Barat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            <div class="gallery-section">
                <div class="gallery-grid">
                    <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?w=300&h=300&fit=crop" alt="Gallery 1" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=300&h=300&fit=crop" alt="Gallery 2" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=300&h=300&fit=crop" alt="Gallery 3" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1573865526739-10c1dd8f0f51?w=300&h=300&fit=crop" alt="Gallery 4" class="gallery-image">
                </div>
            </div>

            <!-- Reviews -->
            <div class="reviews-section">
                <div class="section-header">
                    <h2 class="section-title">50 Reviews</h2>
                    <button class="btn-review">Find review</button>
                </div>
                
                <div class="reviews-container">
                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Nazar Rifa Anggara</div>
                                <div class="review-date">28 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Pelayanan Sangat Baik.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Nazar Rifa Anggara</div>
                                <div class="review-date">28 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Pelayanan Sangat Baik.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Rifa Ahmad</div>
                                <div class="review-date">27 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Sangat puas dengan pelayanan yang diberikan. Kucing saya dirawat dengan baik sekali!</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Halim Santoso</div>
                                <div class="review-date">26 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Recommended! Cat sitter yang sangat profesional dan care terhadap hewan.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Budi Setiawan</div>
                                <div class="review-date">25 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Tempat yang nyaman dan bersih. Kucing saya kelihatan senang!</p>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="booking-section">
                <div class="booking-form">
                    <div class="form-group">
                        <label>Number of Cats</label>
                        <select>
                            <option>Number of Cats</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Days</label>
                        <select>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Booking</label>
                        <input type="text" placeholder="20 Okt" value="20 Okt">
                    </div>
                    <div class="form-group">
                        <label>Additional Service</label>
                        <select>
                            <option>Grooming</option>
                            <option>Vaccination</option>
                            <option>Health Check</option>
                        </select>
                    </div>
                </div>
                <div class="booking-buttons">
                    <button class="btn-contact">Contact</button>
                    <button class="btn-booking">Booking</button>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="cards-grid" id="cardsGrid">
            <!-- Card 1 -->
            <div class="card" onclick="showDetail('Anggara', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=300&fit=crop" alt="Anggara" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Anggara</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card" onclick="showDetail('Nazar', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" alt="Nazar" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Nazar</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card" onclick="showDetail('Rifa', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" alt="Rifa" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Rifa</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card" onclick="showDetail('Halim', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=300&fit=crop" alt="Halim" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Halim</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="card" onclick="showDetail('Anggara', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" alt="Anggara" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Anggara</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="card" onclick="showDetail('Nazar', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=300&fit=crop" alt="Nazar" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Nazar</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="card" onclick="showDetail('Rifa', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=300&fit=crop" alt="Rifa" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Rifa</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="card" onclick="showDetail('Halim', 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=300&fit=crop" alt="Halim" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Halim</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
        function showDetail(name, imageUrl) {
            document.getElementById('detailPage').classList.add('active');
            document.getElementById('cardsGrid').classList.add('hidden');
            document.getElementById('filterSection').classList.add('hidden');
            document.getElementById('detailName').textContent = name;
            document.getElementById('detailProfileImage').src = imageUrl;
            window.scrollTo(0, 0);
        }

        function showCards() {
            document.getElementById('detailPage').classList.remove('active');
            document.getElementById('cardsGrid').classList.remove('hidden');
            document.getElementById('filterSection').classList.remove('hidden');
            window.scrollTo(0, 0);
        }
    </script>
</body>
</html>
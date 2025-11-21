<nav class="navbar">
    <div class="logo">
      <img src="{{asset('images/logo.png')}}" alt="CatStay Logo">
      <span>CATS STAY</span>
    </div>

    @auth
        {{-- NAVBAR UNTUK USER YANG SUDAH LOGIN --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('/my-bookings') }}" class="{{ Request::is('my-bookings') ? 'active' : '' }}">My Bookings</a></li>
            <li><a href="{{ url('/my-cats') }}" class="{{ Request::is('my-cats') ? 'active' : '' }}">My Cats</a></li>
        </ul>

        <div class="nav-buttons" id="navButtons">
            {{-- Notification Bell --}}
            <button class="nav-icon-btn notification-btn" id="notificationBtn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="notification-badge">3</span>
            </button>

            {{-- User Profile Dropdown --}}
            <div class="user-menu">
                <button class="user-menu-btn" id="userMenuBtn">
                    <div class="user-avatar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <svg class="dropdown-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <p class="dropdown-name">{{ Auth::user()->name }}</p>
                        <p class="dropdown-email">{{ Auth::user()->email }}</p>
                        <span class="dropdown-role">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('/profile') }}" class="dropdown-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        My Profile
                    </a>
                    <a href="{{ url('/settings') }}" class="dropdown-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 1v6m0 6v6M1 12h6m6 0h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-form">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

    @else
        {{-- NAVBAR UNTUK USER YANG BELUM LOGIN --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/aboutus') }}" class="{{ Request::is('aboutus') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ url('/catcare') }}" class="{{ Request::is('catcare') ? 'active' : '' }}">Cat Care</a></li>
            <li><a href="{{ url('/contact') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>

        <div class="nav-buttons" id="navButtons">
            <a href="{{ url('/login') }}"><button class="nav-btn btn-signin">Sign In</button></a>
            <a href="{{ url('/signup') }}"><button class="nav-btn btn-signup">Sign Up</button></a>
        </div>
    @endauth

    <div class="hamburger" id="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-content">
      @auth
        {{-- MOBILE MENU UNTUK USER YANG SUDAH LOGIN --}}
        <ul class="mobile-nav-menu">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('/my-bookings') }}" class="{{ Request::is('my-bookings') ? 'active' : '' }}">My Bookings</a></li>
            <li><a href="{{ url('/my-cats') }}" class="{{ Request::is('my-cats') ? 'active' : '' }}">My Cats</a></li>
        </ul>
        
        <div class="mobile-nav-buttons">
            <div class="mobile-user-info">
                <p class="mobile-user-name">{{ Auth::user()->name }}</p>
                <p class="mobile-user-email">{{ Auth::user()->email }}</p>
                <span class="mobile-user-role">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
            <a href="{{ url('/profile') }}"><button class="nav-btn btn-profile">My Profile</button></a>
            <a href="{{ url('/settings') }}"><button class="nav-btn btn-settings">Settings</button></a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="nav-btn btn-logout">Logout</button>
            </form>
        </div>

      @else
        {{-- MOBILE MENU UNTUK USER YANG BELUM LOGIN --}}
        <ul class="mobile-nav-menu">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/aboutus') }}" class="{{ Request::is('aboutus') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ url('/catcare') }}" class="{{ Request::is('catcare') ? 'active' : '' }}">Cat Care</a></li>
            <li><a href="{{ url('/contact') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>
        
        <div class="mobile-nav-buttons">
            <a href="{{ url('/login') }}"><button class="nav-btn btn-signin">Sign In</button></a>
            <a href="{{ url('/signup') }}"><button class="nav-btn btn-signup">Sign Up</button></a>
        </div>
      @endauth
    </div>
</div>
<nav class="navbar">
    <div class="logo">
      <img src="{{asset('images/logo.png')}}" alt="CatStay Logo">
      <span>CATS STAY</span>
    </div>

    @guest
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
    @endguest

    @auth

    @if (Auth::user()->role === "sitter")
            {{-- NAVBAR UNTUK USER YANG SUDAH LOGIN --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('/my-service') }}" class="{{ Request::is('find-sitter') ? 'active' : '' }}">Service</a></li>
            <li><a href="{{ url('/request') }}" class="{{ Request::is('my-request*') ? 'active' : '' }}">Request</a></li>
            <li><a href="{{ url('/history') }}" class="{{ Request::is('my-cats*') ? 'active' : '' }}">History</a></li>
        </ul>

        <div class="nav-buttons" id="navButtons">
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
                        <span class="dropdown-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    
                    {{-- Notifications & Messages Section --}}
                    <a href="{{ url('/profile/notifications') }}" class="dropdown-item dropdown-notif-item {{ Request::is('notifications') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Notifications</span>
                        <span class="dropdown-badge">3</span>
                    </a>
                    <a href="{{ url('/messages') }}" class="dropdown-item dropdown-notif-item {{ Request::is('messages*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Messages</span>
                        <span class="dropdown-badge message-badge-dropdown">5</span>
                    </a>
                    
                    <div class="dropdown-divider"></div>
                    
                    {{-- Profile Actions --}}
                    <a href="{{ url('/profile') }}" class="dropdown-item {{ Request::is('profile*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        My Profile
                    </a>
                    {{-- <a href="{{ url('/settings') }}" class="dropdown-item {{ Request::is('settings*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 1v6m0 6v6M1 12h6m6 0h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Settings
                    </a> --}}
                    
                    <div class="dropdown-divider"></div>
                    
                    {{-- Logout --}}
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
    @elseif(Auth::user()->role === "normal")

        {{-- NAVBAR UNTUK USER YANG SUDAH LOGIN --}}
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('/find-sitter') }}" class="{{ Request::is('find-sitter') ? 'active' : '' }}">Find Sitter</a></li>
            <li><a href="{{ url('/my-request') }}" class="{{ Request::is('my-request*') ? 'active' : '' }}">My Request</a></li>
            <li><a href="{{ url('/my-cats') }}" class="{{ Request::is('my-cats*') ? 'active' : '' }}">My Cats</a></li>
        </ul>

        <div class="nav-buttons" id="navButtons">
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
                        <span class="dropdown-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    
                    {{-- Notifications & Messages Section --}}
                    <a href="{{ url('/profile/notifications') }}" class="dropdown-item dropdown-notif-item {{ Request::is('notifications') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Notifications</span>
                        <span class="dropdown-badge">3</span>
                    </a>
                    <a href="{{ url('/messages') }}" class="dropdown-item dropdown-notif-item {{ Request::is('messages*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Messages</span>
                        <span class="dropdown-badge message-badge-dropdown">5</span>
                    </a>
                    
                    <div class="dropdown-divider"></div>
                    
                    {{-- Profile Actions --}}
                    <a href="{{ url('/profile') }}" class="dropdown-item {{ Request::is('profile*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        My Profile
                    </a>
                    {{-- <a href="{{ url('/settings') }}" class="dropdown-item {{ Request::is('settings*') ? 'active' : '' }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 1v6m0 6v6M1 12h6m6 0h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Settings
                    </a> --}}
                    
                    <div class="dropdown-divider"></div>
                    
                    {{-- Logout --}}
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
        @endif
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
      @if(Auth::user()->role === "sitter")
        <ul class="mobile-nav-menu">
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('service/') }}" class="{{ Request::is('find-sitter') ? 'active' : '' }}">Service</a></li>
            <li><a href="{{ url('/notifications') }}" class="{{ Request::is('notifications') ? 'active' : '' }}">
                Notifications 
                <span class="mobile-badge notif-badge-mobile">3</span>
            </a></li>
            <li><a href="{{ url('/messages') }}" class="{{ Request::is('messages*') ? 'active' : '' }}">
                Messages 
                <span class="mobile-badge">5</span>
            </a></li>
            <li><a href="{{ url('/request') }}" class="{{ Request::is('request*') ? 'active' : '' }}">Request</a></li>
            <li><a href="{{ url('/history') }}" class="{{ Request::is('history*') ? 'active' : '' }}">History</a></li>
        </ul>
        
        <div class="mobile-nav-buttons">
            <div class="mobile-user-info">
                <p class="mobile-user-name">{{ Auth::user()->name }}</p>
                <p class="mobile-user-email">{{ Auth::user()->email }}</p>
                <span class="mobile-user-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
            </div>
            <a href="{{ url('/profile') }}"><button class="nav-btn btn-profile">My Profile</button></a>
        {{-- <a href="{{ url('/settings') }}"><button class="nav-btn btn-settings">Settings</button></a> --}}
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="nav-btn btn-logout">Logout</button>
            </form>
        </div>

      @elseif(Auth::user()->role === "normal")
        {{-- MOBILE MENU UNTUK USER YANG SUDAH LOGIN --}}
        <ul class="mobile-nav-menu">
            <li><a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ url('/find-sitter') }}" class="{{ Request::is('find-sitter') ? 'active' : '' }}">Find Sitter</a></li>
            <li><a href="{{ url('/notifications') }}" class="{{ Request::is('notifications') ? 'active' : '' }}">
                Notifications 
                <span class="mobile-badge notif-badge-mobile">3</span>
            </a></li>
            <li><a href="{{ url('/messages') }}" class="{{ Request::is('messages*') ? 'active' : '' }}">
                Messages 
                <span class="mobile-badge">5</span>
            </a></li>
            <li><a href="{{ url('/my-request') }}" class="{{ Request::is('my-request*') ? 'active' : '' }}">My Request</a></li>
            <li><a href="{{ url('/my-cats') }}" class="{{ Request::is('my-cats*') ? 'active' : '' }}">My Cats</a></li>
        </ul>
        
        <div class="mobile-nav-buttons">
            <div class="mobile-user-info">
                <p class="mobile-user-name">{{ Auth::user()->name }}</p>
                <p class="mobile-user-email">{{ Auth::user()->email }}</p>
                <span class="mobile-user-role">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
            </div>
            <a href="{{ url('/profile') }}"><button class="nav-btn btn-profile">My Profile</button></a>
        {{-- <a href="{{ url('/settings') }}"><button class="nav-btn btn-settings">Settings</button></a> --}}
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
        @endif
      @endauth
    </div>
</div>
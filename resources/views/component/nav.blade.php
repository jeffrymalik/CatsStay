<nav class="navbar">
    <div class="logo">
      <img src="images/logo.png" alt="CatStay Logo">
      <span>CATS STAY</span>
    </div>

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
        <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ url('/aboutus') }}" class="{{ Request::is('aboutus') ? 'active' : '' }}">About Us</a></li>
        <li><a href="{{ url('/catcare') }}" class="{{ Request::is('catcare') ? 'active' : '' }}">Cat Care</a></li>
        <li><a href="{{ url('/contact') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Contact</a></li>
      </ul>
      <div class="mobile-nav-buttons">
        <a href="{{ url('/login') }}"><button class="nav-btn btn-signin">Sign In</button></a>
        <a href="{{ url('/signup') }}"><button class="nav-btn btn-signup">Sign Up</button></a>
      </div>
    </div>
  </div>
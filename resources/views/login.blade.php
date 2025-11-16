<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/login.css')}}">
  <title>Sign In - Cats Stay</title>
</head>
<body>
  <div class="login-container">
    <!-- Left Side - Form -->
    <div class="login-left">
      <div class="login-content">
        <h1 class="login-title">Sign In</h1>
        
        <p class="login-subtitle">
          If you don't have an account register<br>
          You can <a href="#" class="register-link">Sign Up here !</a>
        </p>

        <form class="login-form">
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              id="email" 
              class="form-input" 
              placeholder="Example@email.com"
              required
            >
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input 
              type="password" 
              id="password" 
              class="form-input" 
              placeholder="At least 8 characters"
              required
            >
          </div>

          <div class="form-options">
            <label class="checkbox-wrapper">
              <input type="checkbox" class="checkbox-input">
              <span class="checkbox-label">Remember me</span>
            </label>
            <a href="#" class="forgot-link">Forgot Password ?</a>
          </div>

          <button type="submit" class="btn-login">Sign In</button>

          <div class="divider">
            <span>or continue with</span>
          </div>

          <button type="button" class="btn-google">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18.1713 8.36788H17.5001V8.33329H10.0001V11.6666H14.7096C14.0225 13.6069 12.1763 15 10.0001 15C7.23882 15 5.00007 12.7612 5.00007 9.99996C5.00007 7.23871 7.23882 4.99996 10.0001 4.99996C11.2746 4.99996 12.4342 5.48079 13.3171 6.26621L15.6742 3.90913C14.1859 2.52204 12.1951 1.66663 10.0001 1.66663C5.39799 1.66663 1.66675 5.39788 1.66675 9.99996C1.66675 14.602 5.39799 18.3333 10.0001 18.3333C14.6022 18.3333 18.3334 14.602 18.3334 9.99996C18.3334 9.44121 18.2767 8.89579 18.1713 8.36788Z" fill="#FFC107"/>
              <path d="M2.62756 6.12121L5.36548 8.12913C6.10631 6.29496 7.90048 5 10.0005 5C11.275 5 12.4346 5.48083 13.3175 6.26625L15.6746 3.90917C14.1863 2.52208 12.1955 1.66667 10.0005 1.66667C6.79881 1.66667 4.02423 3.47375 2.62756 6.12121Z" fill="#FF3D00"/>
              <path d="M10.0001 18.3333C12.1526 18.3333 14.1084 17.5095 15.5871 16.17L13.0079 13.9875C12.1431 14.6452 11.0864 15.0009 10.0001 15C7.83261 15 5.99177 13.6179 5.29844 11.6892L2.58344 13.7829C3.96094 16.4817 6.76094 18.3333 10.0001 18.3333Z" fill="#4CAF50"/>
              <path d="M18.1713 8.36796H17.5V8.33337H10V11.6667H14.7096C14.3809 12.5902 13.7889 13.3972 13.0067 13.9879L13.0079 13.9871L15.5871 16.1696C15.4046 16.3354 18.3333 14.1667 18.3333 10C18.3333 9.44129 18.2767 8.89587 18.1713 8.36796Z" fill="#1976D2"/>
            </svg>
            Continue with google
          </button>
        </form>
      </div>
    </div>

    <!-- Right Side - Illustration -->
    <div class="login-right">
      <div class="illustration-wrapper">
        <img src="images/unnamed2.png" alt="Cute cat illustration" class="cat-illustration">
        <div class="orange-blob"></div>
        <div class="decorative-dots">
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  // Login Page JavaScript - Tambahkan sebelum penutup </body> di login.blade.php

document.addEventListener('DOMContentLoaded', function() {
  const loginForm = document.querySelector('.login-form');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const btnLogin = document.querySelector('.btn-login');
  const btnGoogle = document.querySelector('.btn-google');

  // Form Validation
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  function validatePassword(password) {
    return password.length >= 8;
  }

  function showError(input, message) {
    const formGroup = input.parentElement;
    
    // Remove existing error
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
      existingError.remove();
    }

    // Add error styling
    input.style.borderColor = '#f44336';
    
    // Add error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.color = '#f44336';
    errorDiv.style.fontSize = '0.85rem';
    errorDiv.style.marginTop = '5px';
    formGroup.appendChild(errorDiv);
  }

  function clearError(input) {
    const formGroup = input.parentElement;
    const errorMessage = formGroup.querySelector('.error-message');
    
    if (errorMessage) {
      errorMessage.remove();
    }
    
    input.style.borderColor = '#E0E0E0';
  }

  // Real-time validation
  emailInput.addEventListener('input', function() {
    if (this.value) {
      if (!validateEmail(this.value)) {
        showError(this, 'Please enter a valid email address');
      } else {
        clearError(this);
      }
    } else {
      clearError(this);
    }
  });

  passwordInput.addEventListener('input', function() {
    if (this.value) {
      if (!validatePassword(this.value)) {
        showError(this, 'Password must be at least 8 characters');
      } else {
        clearError(this);
      }
    } else {
      clearError(this);
    }
  });

  // Form Submit Handler
  loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let isValid = true;

    // Validate Email
    if (!emailInput.value) {
      showError(emailInput, 'Email is required');
      isValid = false;
    } else if (!validateEmail(emailInput.value)) {
      showError(emailInput, 'Please enter a valid email address');
      isValid = false;
    } else {
      clearError(emailInput);
    }

    // Validate Password
    if (!passwordInput.value) {
      showError(passwordInput, 'Password is required');
      isValid = false;
    } else if (!validatePassword(passwordInput.value)) {
      showError(passwordInput, 'Password must be at least 8 characters');
      isValid = false;
    } else {
      clearError(passwordInput);
    }

    if (isValid) {
      // Show loading state
      const originalText = btnLogin.textContent;
      btnLogin.textContent = 'Signing In...';
      btnLogin.disabled = true;
      btnLogin.style.opacity = '0.7';
      btnLogin.style.cursor = 'not-allowed';

      // Simulate API call (Replace with actual API call)
      setTimeout(() => {
        // On success
        console.log('Login successful!');
        console.log('Email:', emailInput.value);
        console.log('Password:', passwordInput.value);
        
        // Redirect or show success message
        // window.location.href = '/dashboard';
        
        // Reset button state (for demo)
        btnLogin.textContent = originalText;
        btnLogin.disabled = false;
        btnLogin.style.opacity = '1';
        btnLogin.style.cursor = 'pointer';
        
        alert('Login successful! (Demo)');
      }, 1500);
    }
  });

  // Google Sign In Handler
  btnGoogle.addEventListener('click', function() {
    const originalText = this.innerHTML;
    this.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Loading...';
    this.disabled = true;
    this.style.opacity = '0.7';

    // Simulate Google OAuth (Replace with actual Google OAuth)
    setTimeout(() => {
      console.log('Google Sign In clicked');
      
      // Reset button
      this.innerHTML = originalText;
      this.disabled = false;
      this.style.opacity = '1';
      
      alert('Google Sign In (Demo)');
    }, 1500);
  });

  // Clear errors when input gets focus
  [emailInput, passwordInput].forEach(input => {
    input.addEventListener('focus', function() {
      clearError(this);
    });
  });
});
</script>
</html>
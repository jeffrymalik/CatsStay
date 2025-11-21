// Login Page JavaScript

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
  if (emailInput) {
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
  }

  if (passwordInput) {
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
  }

  // Form Submit Handler - ONLY CLIENT-SIDE VALIDATION
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
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

      // Jika validasi gagal, prevent submit
      if (!isValid) {
        e.preventDefault();
        return false;
      }

      // Jika validasi berhasil, tampilkan loading state
      // Tapi JANGAN prevent default - biarkan form submit ke server
      if (btnLogin) {
        btnLogin.textContent = 'Signing In...';
        btnLogin.disabled = true;
        btnLogin.style.opacity = '0.7';
        btnLogin.style.cursor = 'not-allowed';
      }

      // Form akan submit ke server secara normal
      // Laravel controller akan handle login process
    });
  }

  // Google Sign In Handler
  if (btnGoogle) {
    btnGoogle.addEventListener('click', function() {
      const originalHTML = this.innerHTML;
      this.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Loading...';
      this.disabled = true;
      this.style.opacity = '0.7';

      // Simulate Google OAuth (Replace with actual Google OAuth)
      setTimeout(() => {
        console.log('Google Sign In clicked');
        
        // Reset button
        this.innerHTML = originalHTML;
        this.disabled = false;
        this.style.opacity = '1';
        
        alert('Google Sign In - Coming Soon!');
      }, 1500);
    });
  }

  // Clear errors when input gets focus
  [emailInput, passwordInput].forEach(input => {
    if (input) {
      input.addEventListener('focus', function() {
        clearError(this);
      });
    }
  });
});
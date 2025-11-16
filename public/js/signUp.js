// Sign Up Page JavaScript - Multi-Step Form

document.addEventListener('DOMContentLoaded', function() {
  // Elements
  const btnBack = document.getElementById('btnBack');
  const btnNextRole = document.getElementById('btnNextRole');
  const btnNextInfo = document.getElementById('btnNextInfo');
  const btnSubmit = document.getElementById('btnSubmit');
  const btnSubmitNormal = document.getElementById('btnSubmitNormal');
  
  const stepRole = document.getElementById('stepRole');
  const stepInfo = document.getElementById('stepInfo');
  const stepPhoto = document.getElementById('stepPhoto');
  const stepFinish = document.getElementById('stepFinish');
  
  const roleCards = document.querySelectorAll('.role-card');
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  
  // File upload elements
  const uploadArea = document.getElementById('uploadArea');
  const btnChooseFile = document.getElementById('btnChooseFile');
  const fileInput = document.getElementById('fileInput');
  const previewArea = document.getElementById('previewArea');
  const previewImage = document.getElementById('previewImage');
  const btnRemoveImage = document.getElementById('btnRemoveImage');
  
  let selectedRole = null;
  let uploadedFile = null;
  let currentStep = 1;

  // ================ STEP 1: Role Selection ================
  roleCards.forEach(card => {
    card.addEventListener('click', function() {
      roleCards.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      selectedRole = this.dataset.role;
      btnNextRole.disabled = false;
      
      this.style.transform = 'scale(1.05)';
      setTimeout(() => { this.style.transform = ''; }, 200);
    });
  });

  btnNextRole.addEventListener('click', function() {
    if (!selectedRole) return;
    
    const originalText = this.textContent;
    this.textContent = 'Loading...';
    this.disabled = true;

    setTimeout(() => {
      stepRole.classList.remove('active');
      stepInfo.classList.add('active');
      btnBack.style.display = 'flex';
      currentStep = 2;
      
      this.textContent = originalText;
      this.disabled = false;
    }, 500);
  });

  // ================ STEP 2: Basic Information ================
  
  // Validation Functions
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validatePassword(password) {
    return password.length >= 8;
  }

  function showError(input, message) {
    const formGroup = input.parentElement;
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) existingError.remove();
    
    input.style.borderColor = '#f44336';
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    formGroup.appendChild(errorDiv);
  }

  function clearError(input) {
    const formGroup = input.parentElement;
    const errorMessage = formGroup.querySelector('.error-message');
    if (errorMessage) errorMessage.remove();
    input.style.borderColor = '#E0E0E0';
  }

  // Real-time Validation
  nameInput.addEventListener('input', function() {
    if (this.value && this.value.length < 2) {
      showError(this, 'Name must be at least 2 characters');
    } else {
      clearError(this);
    }
  });

  emailInput.addEventListener('input', function() {
    if (this.value && !validateEmail(this.value)) {
      showError(this, 'Please enter a valid email address');
    } else {
      clearError(this);
    }
  });

  passwordInput.addEventListener('input', function() {
    if (this.value && !validatePassword(this.value)) {
      showError(this, 'Password must be at least 8 characters');
    } else {
      clearError(this);
    }
  });

  btnNextInfo.addEventListener('click', function() {
    let isValid = true;

    if (!nameInput.value || nameInput.value.length < 2) {
      showError(nameInput, 'Name must be at least 2 characters');
      isValid = false;
    } else {
      clearError(nameInput);
    }

    if (!emailInput.value || !validateEmail(emailInput.value)) {
      showError(emailInput, 'Please enter a valid email address');
      isValid = false;
    } else {
      clearError(emailInput);
    }

    if (!passwordInput.value || !validatePassword(passwordInput.value)) {
      showError(passwordInput, 'Password must be at least 8 characters');
      isValid = false;
    } else {
      clearError(passwordInput);
    }

    if (isValid) {
      const originalText = this.textContent;
      this.textContent = 'Loading...';
      this.disabled = true;

      setTimeout(() => {
        stepInfo.classList.remove('active');
        
        if (selectedRole === 'sitter') {
          stepPhoto.classList.add('active');
        } else {
          stepFinish.classList.add('active');
        }
        
        currentStep = 3;
        
        this.textContent = originalText;
        this.disabled = false;
      }, 500);
    }
  });

  // ================ STEP 3: Photo Upload (Pet Sitter) ================
  
  if (uploadArea && fileInput) {
    uploadArea.addEventListener('click', () => fileInput.click());
    btnChooseFile.addEventListener('click', (e) => {
      e.stopPropagation();
      fileInput.click();
    });

    // Drag & Drop
    uploadArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', () => {
      uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadArea.classList.remove('drag-over');
      if (e.dataTransfer.files.length > 0) {
        handleFile(e.dataTransfer.files[0]);
      }
    });

    fileInput.addEventListener('change', function() {
      if (this.files.length > 0) {
        handleFile(this.files[0]);
      }
    });

    function handleFile(file) {
      if (!file.type.startsWith('image/')) {
        alert('Please upload an image file');
        return;
      }

      if (file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB');
        return;
      }

      uploadedFile = file;
      
      const reader = new FileReader();
      reader.onload = function(e) {
        previewImage.src = e.target.result;
        uploadArea.style.display = 'none';
        previewArea.style.display = 'block';
        btnSubmit.disabled = false;
      };
      reader.readAsDataURL(file);
    }

    btnRemoveImage.addEventListener('click', function(e) {
      e.stopPropagation();
      uploadedFile = null;
      previewImage.src = '';
      previewArea.style.display = 'none';
      uploadArea.style.display = 'block';
      fileInput.value = '';
      btnSubmit.disabled = true;
    });
  }

  // Submit for Pet Sitter
  if (btnSubmit) {
    btnSubmit.addEventListener('click', function() {
      if (!uploadedFile) {
        alert('Please upload a photo for verification');
        return;
      }

      const originalText = this.textContent;
      this.textContent = 'Uploading...';
      this.disabled = true;

      setTimeout(() => {
        console.log('Registration Success!');
        console.log('Name:', nameInput.value);
        console.log('Email:', emailInput.value);
        console.log('Role:', selectedRole);
        console.log('Photo:', uploadedFile.name);

        alert('Registration successful!\n\nRole: Pet Sitter\nPhoto uploaded for verification.');
        // window.location.href = '/login';
        
        this.textContent = originalText;
        this.disabled = false;
      }, 2000);
    });
  }

  // Submit for Normal User
  if (btnSubmitNormal) {
    btnSubmitNormal.addEventListener('click', function() {
      const originalText = this.textContent;
      this.textContent = 'Creating Account...';
      this.disabled = true;

      setTimeout(() => {
        console.log('Registration Success!');
        console.log('Name:', nameInput.value);
        console.log('Email:', emailInput.value);
        console.log('Role:', selectedRole);

        alert('Registration successful!\n\nRole: Normal User\nWelcome to Cats Stay!');
        // window.location.href = '/login';
        
        this.textContent = originalText;
        this.disabled = false;
      }, 1500);
    });
  }

  // ================ Back Button Navigation ================
  
  btnBack.addEventListener('click', function() {
    if (currentStep === 3) {
      // Go back to step 2
      stepPhoto.classList.remove('active');
      stepFinish.classList.remove('active');
      stepInfo.classList.add('active');
      currentStep = 2;
    } else if (currentStep === 2) {
      // Go back to step 1
      stepInfo.classList.remove('active');
      stepRole.classList.add('active');
      btnBack.style.display = 'none';
      currentStep = 1;
    }
  });

  // Clear errors on focus
  [nameInput, emailInput, passwordInput].forEach(input => {
    input.addEventListener('focus', function() {
      clearError(this);
    });
  });

  // Keyboard navigation for role cards
  document.addEventListener('keydown', function(e) {
    if (currentStep === 1 && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) {
      e.preventDefault();
      const activeCard = document.querySelector('.role-card.active');
      const cards = Array.from(roleCards);
      
      if (!activeCard) {
        cards[0].click();
      } else {
        const currentIndex = cards.indexOf(activeCard);
        const nextIndex = e.key === 'ArrowDown' 
          ? (currentIndex + 1) % cards.length 
          : (currentIndex - 1 + cards.length) % cards.length;
        cards[nextIndex].click();
      }
    }
  });
});
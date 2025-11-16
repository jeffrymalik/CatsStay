<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/signup.css')}}">
  <title>Sign Up - Cats Stay</title>
</head>
<body>
  <div class="signup-container">
    <!-- Left Side - Form -->
    <div class="signup-left">
      <!-- Mobile Header Decoration -->
      <div class="mobile-header">
        <div class="mobile-blob"></div>
        <img src="images/unnamed2.png" alt="Cat" class="mobile-cat">
        <div class="mobile-dots">
          <span class="mobile-dot"></span>
          <span class="mobile-dot"></span>
          <span class="mobile-dot"></span>
        </div>
      </div>

      <!-- Back Button -->
      <button class="btn-back" id="btnBack" style="display: none;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>

      <div class="signup-content">
        <!-- STEP 1: Role Selection -->
        <div class="form-step active" id="stepRole">
          <h1 class="signup-title">Sign Up</h1>
          
          <p class="signup-subtitle">
            If you have an account Sign In now<br>
            You can <a href="/login" class="signin-link">Sign In here !</a>
          </p>

          <!-- Role Selection -->
          <div class="role-selection">
            <h3 class="role-title">Choose Your Role</h3>
            
            <div class="role-options">
              <!-- Normal User -->
              <div class="role-card" data-role="normal">
                <div class="role-icon">
                  <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&h=200&fit=crop" alt="Normal User">
                </div>
                <h4 class="role-name">Normal user</h4>
                <div class="role-checkmark">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </div>

              <!-- Pet Sitter -->
              <div class="role-card" data-role="sitter">
                <div class="role-icon">
                  <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=200&h=200&fit=crop" alt="Pet Sitter">
                </div>
                <h4 class="role-name">Pet Sitter</h4>
                <div class="role-checkmark">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17L4 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <button type="button" class="btn-next" id="btnNextRole" disabled>Next</button>
        </div>

        <!-- STEP 2: Basic Information -->
        <div class="form-step" id="stepInfo">
          <h1 class="signup-title">Sign Up</h1>
          
          <p class="signup-subtitle">
            If you have an account Sign In Now<br>
            You can <a href="/login" class="signin-link">Sign In here !</a>
          </p>

          <form class="signup-form">
            <div class="form-group">
              <label for="name" class="form-label">Name</label>
              <input 
                type="text" 
                id="name" 
                class="form-input" 
                placeholder="Name"
                required
              >
            </div>

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

            <button type="button" class="btn-next" id="btnNextInfo">Next</button>
          </form>
        </div>

        <!-- STEP 3: Photo Upload (Pet Sitter Only) -->
        <div class="form-step" id="stepPhoto">
          <h1 class="signup-title">Choose Your Photos</h1>
          
          <p class="signup-subtitle">
            If you are a cat sitter, upload a photo<br>
            as proof for verification.
          </p>

          <div class="upload-area" id="uploadArea">
            <div class="upload-icon">
              <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 18C7 18 6 18 6 17C6 16 7 13 11 13C15 13 16 16 16 17C16 18 15 18 15 18H7Z" stroke="#CCC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="11" cy="8" r="3" stroke="#CCC" stroke-width="1.5"/>
                <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#CCC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 2V8H20" stroke="#CCC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <p class="upload-text">Drop & drag your files here or</p>
            <button type="button" class="btn-choose-file" id="btnChooseFile">Choose File</button>
            <input type="file" id="fileInput" accept="image/*" hidden>
          </div>

          <!-- Preview Area -->
          <div class="preview-area" id="previewArea" style="display: none;">
            <img src="" alt="Preview" id="previewImage">
            <button type="button" class="btn-remove-image" id="btnRemoveImage">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>

          <button type="button" class="btn-submit" id="btnSubmit" disabled>Sign Up</button>
        </div>

        <!-- STEP 3 Alternative: Finish (Normal User) -->
        <div class="form-step" id="stepFinish">
          <h1 class="signup-title">Almost Done!</h1>
          
          <p class="signup-subtitle">
            Click the button below to complete your registration.
          </p>

          <div class="success-icon">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="#FFA726" stroke-width="2"/>
              <path d="M8 12L11 15L16 9" stroke="#FFA726" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>

          <button type="button" class="btn-submit" id="btnSubmitNormal">Sign Up</button>
        </div>
      </div>
    </div>

    <!-- Right Side - Illustration -->
    <div class="signup-right">
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

  <script src="js/signUp.js"></script>
</body>
</html>
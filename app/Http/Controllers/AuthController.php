<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PetSitterProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Show Login Form
     */
    public function showLogin()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('pages.login');
    }

    /**
     * Process Login
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Ambil nilai remember me
        $remember = $request->has('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session untuk security
            $request->session()->regenerate();
            
            // Role-based redirect
            $user = Auth::user();
            
            switch ($user->role) {
                case 'normal':
                    return redirect()->intended('/dashboard')->with('success', 'Login successful!');
                    
                case 'sitter':
                    return redirect()->intended('/pet-sitter/dashboard')->with('success', 'Login successful!');
                    
                case 'admin':
                    return redirect()->intended('/admin/dashboard')->with('success', 'Login successful!');
                    
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Role tidak valid.',
                    ]);
            }
        }

        // Jika gagal, return error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show Register Form
     */
    public function showRegister()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('pages.signup');
    }

    /**
     * Process Register
     */
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:normal,sitter,admin',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Handle photo upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('avatars', 'public');
    }

    // Create user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
        'photo' => $photoPath,
        'is_verified' => $validated['role'] === 'normal' ? true : false,
        'status' => 'active',
    ]);

    // Create sitter profile if role is sitter
    if ($validated['role'] === 'sitter') {
        PetSitterProfile::create([
            'user_id' => $user->id,
            
            // Experience & Verification
            'years_of_experience' => 0,
            'is_verified' => false,
            'verified_at' => null,
            
            // Services Offered (all disabled by default)
            'offers_cat_sitting' => false,
            'offers_grooming' => false,
            'offers_home_visit' => false,
            
            // Pricing (all null, will be set when sitter setup profile)
            'cat_sitting_price' => null,
            'grooming_price' => null,
            'home_visit_price' => null,
            
            // Additional Info
            'max_cats_accepted' => 2,
            'home_description' => null,
            'home_photos' => null,
            
            // Availability
            'is_available' => false, // ⚠️ Set to false until profile is complete
            'response_time' => '1 hour',
            
            // Stats (auto-calculated, start with 0)
            'rating_average' => 0,
            'total_bookings' => 0,
            'completed_bookings' => 0,
            'total_reviews' => 0,
        ]);
    }

    Auth::login($user);

    switch ($user->role) {
        case 'normal':
            return redirect('/dashboard')->with('success', 'Registration successful! Welcome to Cats Stay!');
            
        case 'sitter':
            return redirect('/pet-sitter/dashboard')->with('success', 'Registration successful! Please complete your profile to start accepting bookings.');
            
        case 'admin':
            return redirect('/admin/dashboard')->with('success', 'Admin account created successfully!');
            
        default:
            return redirect('/login');
    }
}

    /**
     * Helper: Redirect based on user role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'normal':
                return redirect('/dashboard');
            case 'sitter':
                return redirect('/pet-sitter/dashboard');
            case 'admin':
                return redirect('/admin/dashboard');
            default:
                return redirect('/');
        }
    }

        public function logout(Request $request)
    {
        // Logout user
        Auth::logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Redirect ke login dengan success message
        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
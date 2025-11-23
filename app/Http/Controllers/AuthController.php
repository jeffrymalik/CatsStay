<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        // Jika sudah login, redirect ke home
        if (Auth::check()) {
            return redirect('/');
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
            
            // Redirect ke halaman yang dituju atau home
            return redirect()->intended('/dashboard')->with('success', 'Login successful!');
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
        // Jika sudah login, redirect ke home
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        
        return view('pages.signup');
    }

    /**
     * Process Register
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:normal,sitter,admin',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // Handle photo upload untuk pet sitter
        $photoPath = null;
        if ($request->role === 'sitter' && $request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('sitter-photos', 'public');
        }

        // Create user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'photo' => $photoPath,
            'is_verified' => $validated['role'] === 'normal' ? true : false, // Normal user auto verified
        ]);

        // Auto login setelah register
        Auth::login($user);

        // Redirect ke home dengan success message
        return redirect('/dashboard')->with('success', 'Registration successful! Welcome to Cats Stay!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        
        // Redirect ke login dengan success message
        return redirect('/')->with('success', 'Logged out successfully!');
    }
}
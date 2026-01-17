<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PetSitterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'sitter') {
            return $next($request);
        }

        // Redirect based on actual role
        if (Auth::check()) {
            $role = Auth::user()->role;
            
            if ($role === 'normal') {
                return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            
            if ($role === 'admin') {
                return redirect('/admin/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle request
     */
    public function handle(Request $request, Closure $next)
    {
        // 🔒 Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // 🔒 Cek apakah admin
        if (Auth::user()->is_admin !== '1') {
            return redirect('/dashboard')->with('error', 'Akses ditolak, bukan admin');
        }

        return $next($request);
    }
}

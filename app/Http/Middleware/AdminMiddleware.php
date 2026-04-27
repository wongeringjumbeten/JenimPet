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
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }

    if (!Auth::user()->is_admin) {
        return redirect('/dashboard')->with('error', 'Akses ditolak, bukan admin');
    }

    return $next($request);
    }
}

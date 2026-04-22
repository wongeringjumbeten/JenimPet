<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\c_googleauth;

// Landing page
Route::get('/', function () {
    return view('v_landingpage');
})->name('home');

// Login page
Route::get('/login', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin === '1') {
            return redirect('/admin/dashboard');
        }
        return redirect('/dashboard');
    }

    return view('v_login');
})->name('login');


Route::get('/auth/google', [c_googleauth::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [c_googleauth::class, 'handleGoogleCallback']);
Route::post('/logout', [c_googleauth::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('v_dashboardpelanggan', [
            'user' => auth()->user()
        ]);
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('v_dashboardadmin', [
            'user' => auth()->user()
        ]);
    });
});

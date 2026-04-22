<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\c_googleauth;

Route::get('/test-google', function () {
    return redirect('/auth/google');
});

// landing
Route::get('/', function () {
    return view('v_landingpage');
});

// login (TANPA redirect logic dulu)
Route::get('/login', function () {
    return view('v_login');
})->name('login');
// google
Route::get('/auth/google', [c_googleauth::class, 'redirectToGoogle'])
    ->withoutMiddleware(['auth']);

Route::get('/auth/google/callback', [c_googleauth::class, 'handleGoogleCallback'])
    ->withoutMiddleware(['auth']);

Route::post('/logout', [c_googleauth::class, 'logout'])->name('logout');

// dashboard pelanggan
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
    return view('v_dashboardpelanggan', [
        'user' => auth()->user()
        ]);
    })->name('dashboard');
});

// dashboard admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
    return view('v_dashboardadmin', [
        'user' => auth()->user()
        ]);
    })->name('admin.dashboard');
});


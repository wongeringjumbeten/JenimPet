<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\c_googleauth;
use App\Http\Controllers\c_profil;
use App\Http\Controllers\c_pelanggan;
use App\Http\Controllers\c_produk;
use App\Http\Controllers\c_dashboard;
use App\Http\Controllers\c_apiwilayah;

Route::get('/test-google', function () {
    return redirect('/auth/google');
});
//LANDING LOGIN
Route::get('/', function () {
    return view('v_landingpage');
});

Route::get('/login', function () {
    return view('v_login');
})->name('login');
//GOOGLE AUTH
Route::get('/auth/google', [c_googleauth::class, 'redirectToGoogle'])
    ->withoutMiddleware(['auth'])
    ->name('google.login');

Route::get('/auth/google/callback', [c_googleauth::class, 'handleGoogleCallback'])
    ->withoutMiddleware(['auth']);

Route::post('/logout', [c_googleauth::class, 'logout'])->name('logout');
//AREA PELANGGAN
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('v_profilpelanggan', [
            'user' => auth()->user()
        ]);
    })->name('profile');

    Route::get('/profile/edit-hp', [c_profil::class, 'editNoHpUser'])
        ->name('profile.edit.hp');

    Route::post('/profile/update-hp', [c_profil::class, 'updateNoHpUser'])
        ->name('profile.update.hp');

    Route::get('/profile/edit-alamat', [c_profil::class, 'editAlamat'])
        ->name('profile.edit.alamat');

    Route::post('/profile/update-alamat', [c_profil::class, 'updateAlamat'])
        ->name('profile.update.alamat');

    Route::get('/profile/edit-nama', [c_profil::class, 'editNama'])
        ->name('profile.edit.nama');

    Route::post('/profile/update-nama', [c_profil::class, 'updateNama'])
        ->name('profile.update.nama');

    Route::get('/katalog', [c_produk::class, 'katalogPelanggan'])
        ->name('katalog.pelanggan');


// API Wilayah (Proxy)
Route::get('/api/wilayah/provinces', [c_apiwilayah::class, 'getProvinces']);
Route::get('/api/wilayah/regencies/{provinceCode}', [c_apiwilayah::class, 'getRegencies']);
Route::get('/api/wilayah/districts/{regencyCode}', [c_apiwilayah::class, 'getDistricts']);
});
//AREA ADMIN
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [c_dashboard::class, 'index'])
    ->name('admin.dashboard');

    Route::get('/admin/profile', function () {
        return view('v_profiladmin', [
            'user' => auth()->user()
        ]);
    })->name('admin.profile');

    Route::get('/admin/profile/edit-hp', [c_profil::class, 'editNoHpAdmin'])
        ->name('admin.edit.hp');

    Route::post('/admin/profile/update-hp', [c_profil::class, 'updateNoHpAdmin'])
        ->name('admin.update.hp');

    Route::get('/admin/pelanggan', [c_pelanggan::class, 'index'])
        ->name('admin.pelanggan');

    Route::get('/admin/pelanggan/{id}', [c_pelanggan::class, 'detail'])
        ->name('admin.pelanggan.detail');

    Route::get('/admin/katalog', [c_produk::class, 'index'])
        ->name('admin.katalog');

    Route::get('/admin/katalog/create', [c_produk::class, 'create'])
        ->name('admin.katalog.create');

    Route::post('/admin/katalog/store', [c_produk::class, 'store'])
        ->name('admin.katalog.store');

    Route::get('/admin/katalog/{id}/edit', [c_produk::class, 'edit'])
        ->name('admin.katalog.edit');

    Route::put('/admin/katalog/{id}', [c_produk::class, 'update'])
        ->name('admin.katalog.update');

    Route::delete('/admin/katalog/{id}', [c_produk::class, 'destroy'])
        ->name('admin.katalog.delete');

    Route::patch('/admin/katalog/{id}/toggle-show', [c_produk::class, 'toggleShow'])
    ->name('admin.katalog.toggleShow');

});

<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\m_akun;
use Exception;

class c_googleauth extends Controller
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
            ->stateless()
            ->with(['prompt' => 'select_account'])
            ->redirect();
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal menghubungkan ke Google.');
            }
            }

            public function handleGoogleCallback(Request $request)
    {
    if ($request->has('error')) {
        return redirect('/login')->with('error', 'Login dibatalkan');
    }

    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = m_akun::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'nama_lengkap' => $googleUser->getName() ?? 'User Google',
                'google_id' => $googleUser->getId(),
                'password' => bcrypt('dummy'),
                'is_admin' => '0',
            ]
        );

        // update data
        $user->update([
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token ?? null,
            'google_refresh_token' => $googleUser->refreshToken ?? null,
            'avatar' => $googleUser->getAvatar(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // redirect sesuai role
        if ($user->is_admin) {
            return redirect('/admin/dashboard');
        }

        return redirect('/profile');

    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Login gagal');
    }
    }

    public function logout(Request $request)
    {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
    }
}

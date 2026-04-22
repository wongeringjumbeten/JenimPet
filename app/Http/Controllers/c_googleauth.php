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
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal menghubungkan ke Google.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser->getEmail()) {
                return redirect('/login')->with('error', 'Email akun Google tidak tersedia.');
            }

            $user = m_akun::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token ?? null,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                $user = m_akun::create([
                    'nama_lengkap' => $googleUser->getName() ?? 'User Google',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token ?? null,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt('google_login_dummy_password'),
                    'is_admin' => 0,
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            if ($user->is_admin === 1) {
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}

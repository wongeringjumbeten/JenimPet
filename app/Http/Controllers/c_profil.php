<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class c_profil extends Controller
{
    // =====================
    // ADMIN
    // =====================
    public function editNoHpAdmin()
    {
        return view('v_formupdatenomorhp', [
            'user' => Auth::user()
        ]);
    }

    public function updateNoHpAdmin(Request $request)
    {
        $this->validateHp($request);

        $user = auth()->user();
        $user->no_telp = $request->no_telp;
        $user->save();

        return redirect()->route('admin.profile')
            ->with('success', 'Nomor HP berhasil diperbarui!');
    }

    // =====================
    // PELANGGAN
    // =====================
    public function editNoHpUser()
    {
        return view('v_formupdatenomorhppelanggan', [
            'user' => Auth::user()
        ]);
    }

    public function updateNoHpUser(Request $request)
    {
        $this->validateHp($request);

        $user = auth()->user();
        $user->no_telp = $request->no_telp;
        $user->save();

        return redirect()->route('profile')
            ->with('success', 'Nomor HP berhasil diperbarui!');
    }

    // =====================
    // VALIDASI (BIAR GA DUPLIKASI)
    // =====================
    private function validateHp($request)
    {
        $request->validate([
            'no_telp' => [
                'required',
                'regex:/^[0-9]+$/',
                'digits_between:10,13'
            ]
        ], [
            'no_telp.required' => 'harap isi perubahan anda',
            'no_telp.regex' => 'harap isi dengan angka',
            'no_telp.digits_between' => 'nomor hp harus 10-13 digit'
        ]);
    }

    public function editAlamat()
    {
    return view('v_updatealamatpelanggan', [
        'user' => auth()->user()
    ]);
    }

    public function updateAlamat(Request $request)
    {
    $request->validate([
        'provinsi' => 'required',
        'kota' => 'required',
        'kecamatan' => 'required',
    ]);

    $alamat = $request->provinsi . ', ' .
            $request->kota . ', ' .
            $request->kecamatan;

    $user = auth()->user();
    $user->alamat = $alamat;
    $user->save();

    return redirect()->route('profile')
        ->with('success', 'Alamat berhasil diperbarui!');
    }
    public function editNama()
    {
    return view('v_formupdatenamapelanggan', [
        'user' => auth()->user()
    ]);
    }

    public function updateNama(Request $request)
    {
    $request->validate([
        'nama_lengkap' => [
            'required',
            'regex:/^[a-zA-Z\s]+$/',
            'min:3',
            'max:50'
        ]
    ], [
        'nama_lengkap.required' => 'Nama wajib diisi',
        'nama_lengkap.regex' => 'Nama tidak boleh mengandung angka atau simbol',
        'nama_lengkap.min' => 'Nama minimal 3 karakter',
        'nama_lengkap.max' => 'Nama maksimal 50 karakter',
    ]);

    $user = auth()->user();
    $user->nama_lengkap = $request->nama_lengkap;
    $user->save();

    return redirect()->route('profile')
        ->with('success', 'Nama berhasil diperbarui!');
    }
}

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

    // Di c_profil.php, replace method updateAlamat yang lama

public function updateAlamat(Request $request)
{
    $request->validate([
        'kecamatan_kode' => 'required|string',  // kode dari API (contoh: "31.74.06")
        'detail_alamat' => 'nullable|string|max:500',
        'provinsi' => 'required|string',
        'kota' => 'required|string',
        'kecamatan' => 'required|string',
    ]);

    // Cari kecamatan berdasarkan KODE dari API
    $kecamatan = m_kecamatan::where('kode', $request->kecamatan_kode)->first();

    if (!$kecamatan) {
        return back()->withErrors(['kecamatan' => 'Wilayah tidak ditemukan di database. Silakan coba lagi.']);
    }

    $user = auth()->user();

    // Simpan ID kecamatan (auto-increment) ke tabel akun
    $user->kecamatan_id = $kecamatan->id_kecamatan;
    $user->detail_alamat = $request->detail_alamat;

    // Backup string alamat (opsional)
    $user->alamat = $request->provinsi . ', ' . $request->kota . ', ' . $request->kecamatan;

    $user->save();

    return redirect()->route('profile')
        ->with('success', 'Alamat berhasil diperbarui!');
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

<?php

namespace App\Http\Controllers;

use App\Models\m_akun;
use App\Models\m_pesanan;
use Illuminate\Http\Request;

class c_pelanggan extends Controller
{
    public function index()
    {
        $pelanggan = m_akun::where('is_admin', 0)->get();

        return view('v_pelanggan', compact('pelanggan'));
    }

    public function detail($id)
    {
        $pelanggan = m_akun::findOrFail($id);

        // 🔥 PAKAI MODEL m_pesanan DENGAN RELASI detail.produk 🔥
        $pesanan = m_pesanan::with('detail.produk')
            ->where('akun_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('v_detailpelanggan', compact('pelanggan', 'pesanan'));
    }
}

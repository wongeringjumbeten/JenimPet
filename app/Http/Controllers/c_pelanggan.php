<?php

namespace App\Http\Controllers;

use App\Models\m_akun;
use Illuminate\Support\Facades\DB;
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

        $pesanan = DB::table('pesanan')
            ->where('akun_id', $id)
            ->latest()
            ->get();

        return view('v_detailpelanggan', compact('pelanggan','pesanan'));
    }
}

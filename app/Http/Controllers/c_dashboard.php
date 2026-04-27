<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class c_dashboard extends Controller
{
    public function index()
    {
        $produk = DB::table('produk')
            ->where('is_deleted', '0')
            ->latest()
            ->limit(4)
            ->get();

        $pesanan = DB::table('pesanan')
            ->latest()
            ->limit(5)
            ->get();

        return view('v_dashboardadmin', compact('produk','pesanan'));
    }
}

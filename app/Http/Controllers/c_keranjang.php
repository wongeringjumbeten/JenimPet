<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_keranjang;
use App\Models\m_produk;

class c_keranjang extends Controller
{
    // Ambil jumlah item di keranjang (untuk badge navbar)
    public static function getCartCount()
    {
        if (!auth()->check()) {
            return 0;
        }
        return m_keranjang::where('akun_id_akun', auth()->id())->sum('kuantitas');
    }

    // Tampilkan halaman keranjang
    public function index()
    {
        $keranjang = m_keranjang::with('produk')
            ->where('akun_id_akun', auth()->id())
            ->get();

        $totalHarga = $keranjang->sum(function($item) {
            return $item->produk->harga * $item->kuantitas;
        });

        return view('v_keranjang', compact('keranjang', 'totalHarga'));
    }

    // Tambah produk ke keranjang
    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id_produk',
            'kuantitas' => 'required|integer|min:1'
        ]);

        $keranjang = m_keranjang::where('akun_id_akun', auth()->id())
            ->where('produk_id_produk', $request->produk_id)
            ->first();

        if ($keranjang) {
            $keranjang->kuantitas += $request->kuantitas;
            $keranjang->save();
        } else {
            m_keranjang::create([
                'akun_id_akun' => auth()->id(),
                'produk_id_produk' => $request->produk_id,
                'kuantitas' => $request->kuantitas,
                'is_selected' => '0'
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    // Update kuantitas
    public function update(Request $request, $id)
    {
        $item = m_keranjang::where('akun_id_akun', auth()->id())
            ->where('id_keranjang', $id)
            ->firstOrFail();

        $request->validate([
            'kuantitas' => 'required|integer|min:1'
        ]);

        $item->kuantitas = $request->kuantitas;
        $item->save();

        return response()->json(['success' => true, 'kuantitas' => $item->kuantitas]);
    }

    // Hapus item dari keranjang
    public function hapus($id)
    {
    $item = m_keranjang::where('akun_id_akun', auth()->id())
        ->where('id_keranjang', $id)
        ->firstOrFail();

    $item->delete();

    // Kalau pake AJAX, return response JSON
    if (request()->ajax()) {
        return response()->json(['success' => true]);
    }

    // Kalau redirect biasa
    return redirect()->route('keranjang.index')->with('success', 'Item dihapus dari keranjang');
    }

    // Toggle pilih / batal pilih item
    public function toggleSelect(Request $request, $id)
    {
        $item = m_keranjang::where('akun_id_akun', auth()->id())
            ->where('id_keranjang', $id)
            ->firstOrFail();

        $item->is_selected = $request->is_selected ?? ($item->is_selected == '0' ? '1' : '0');
        $item->save();

        return response()->json(['success' => true, 'is_selected' => $item->is_selected]);
    }
}

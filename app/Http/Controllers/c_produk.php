<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_produk;

class c_produk extends Controller
{
    // ==================== ADMIN ====================

    public function index()
    {
        // Pisahkan produk yang tampil dan tidak tampil
        $produkTampil = m_produk::where('is_deleted', '0')->orderBy('created_at', 'desc')->get();
        $produkTidakTampil = m_produk::where('is_deleted', '1')->orderBy('created_at', 'desc')->get();

        return view('v_katalogadmin', compact('produkTampil', 'produkTidakTampil'));
    }

    public function create()
    {
        return view('v_formtambahproduk');
    }

    public function store(Request $request)
    {
        // validasi dan store
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $request->file('foto_produk')->store('produk', 'public');

        m_produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto_produk' => $fotoPath,
            'is_deleted' => '0', // default aktif
        ]);

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil ditambahkan');
    }


    public function edit($id)
    {
        $produk = m_produk::findOrFail($id);
        return view('v_formeditproduk', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = m_produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('foto_produk')) {
            $fotoPath = $request->file('foto_produk')->store('produk', 'public');
            $data['foto_produk'] = $fotoPath;
        }

        $produk->update($data);

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = m_produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.katalog')->with('success', 'Produk berhasil dihapus');
    }

    public function toggleShow($id)
    {
        $produk = m_produk::findOrFail($id);

        // Toggle status (0 -> 1 atau 1 -> 0)
        $produk->is_deleted = $produk->is_deleted == '1' ? '0' : '1';
        $produk->save();

        return response()->json(['success' => true]);
    }

    // ==================== PELANGGAN ====================

    public function katalogPelanggan()
    {
        $produk = m_produk::where('is_deleted', '0')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('v_katalogpelanggan', compact('produk'));
    }
}

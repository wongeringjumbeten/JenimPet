<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_produk;
use Illuminate\Support\Facades\DB;

class c_produk extends Controller
{
    // tampil katalog
    public function index()
    {
        $produk = m_produk::where('is_deleted', '0')
                    ->latest()
                    ->get();

        return view('v_katalogadmin', compact('produk'));
    }

    // form tambah produk
    public function create()
    {
        return view('v_formtambahproduk');
    }

    // simpan produk
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:30',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto_produk' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload foto
        $path = $request->file('foto_produk')->store('produk', 'public');

        // simpan ke database
        m_produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto_produk' => $path,
            'is_deleted' => '0',
        ]);

        return redirect()->route('admin.katalog')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function destroy($id)
    {
    DB::table('produk')
        ->where('id_produk', $id)
        ->update(['is_deleted' => '1']);

    return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    public function edit($id)
    {
    $produk = DB::table('produk')->where('id_produk', $id)->first();

    return view('v_formeditproduk', compact('produk'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|max:30',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
        'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'nama_produk' => $request->nama_produk,
        'deskripsi' => $request->deskripsi,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'updated_at' => now()
    ];

    if ($request->hasFile('foto_produk')) {
        $path = $request->file('foto_produk')->store('produk', 'public');
        $data['foto_produk'] = $path;
    }

    DB::table('produk')
        ->where('id_produk', $id)
        ->update($data);

    return redirect()->route('admin.katalog')
        ->with('success', 'Produk berhasil diupdate');
    }
    public function katalogPelanggan()
    {
    $produk = DB::table('produk')
        ->where('is_deleted', '0')
        ->latest()
        ->get();

    return view('v_katalogpelanggan', compact('produk'));
    }
}

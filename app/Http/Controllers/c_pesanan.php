<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_pesanan;
use App\Models\m_detailpesanan;
use App\Models\m_keranjang;
use App\Models\m_produk;
use Illuminate\Support\Facades\Storage;

class c_pesanan extends Controller
{
    // ==================== PELANGGAN ====================

    // Tampilkan halaman form checkout
public function formCheckout(Request $request)
{
    $selectedItems = json_decode($request->selected_items, true);

    if (empty($selectedItems)) {
        return redirect()->route('keranjang.index')->with('error', 'Tidak ada item yang dipilih');
    }

    // Ambil detail item dari keranjang
    $cartItems = m_keranjang::with('produk')
        ->where('akun_id_akun', auth()->id())
        ->whereIn('id_keranjang', $selectedItems)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('keranjang.index')->with('error', 'Item tidak ditemukan');
    }

    $totalHarga = $cartItems->sum(function($item) {
        return $item->produk->harga * $item->kuantitas;
    });

    return view('v_formmembuatpesanan', compact('cartItems', 'totalHarga', 'selectedItems'));
}

    // Proses checkout dari keranjang
    public function prosesCheckout(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'integer|exists:keranjang,id_keranjang',
            'alamat' => 'required|string|min:10|max:500',
            'metode_pembayaran' => 'required|string|in:transfer_bca,transfer_mandiri,e_wallet',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:500'
        ]);

        // 2. AMBIL SELECTED ITEMS DARI KERANJANG
        $selectedItems = $request->selected_items;
        $cartItems = m_keranjang::with('produk')
            ->where('akun_id_akun', auth()->id())
            ->whereIn('id_keranjang', $selectedItems)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ], 404);
        }

        // 3. CEK STOK PRODUK
        foreach ($cartItems as $item) {
            if ($item->kuantitas > $item->produk->stok) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk {$item->produk->nama_produk} tidak mencukupi. Stok tersedia: {$item->produk->stok}"
                ], 400);
            }
        }

        // 4. UPLOAD BUKTI PEMBAYARAN
        $buktiFile = $request->file('bukti_pembayaran');
        $buktiPath = $buktiFile->store('bukti_pembayaran', 'public');

        // 5. HITUNG TOTAL PEMBAYARAN
        $totalPembayaran = 0;
        foreach ($cartItems as $item) {
            $totalPembayaran += $item->produk->harga * $item->kuantitas;
        }

        // 6. SIMPAN PESANAN
        $pesanan = m_pesanan::create([
            'akun_id' => auth()->id(),
            'tanggal_pesanan' => now(),
            'total_pembayaran' => $totalPembayaran,
            'status_pesanan' => 'pengecekan pembayaran',
            'alamat' => $request->alamat,
            'catatan' => $request->catatan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $buktiPath
        ]);

        // 7. SIMPAN DETAIL PESANAN & KURANGI STOK
        foreach ($cartItems as $item) {
            m_detailpesanan::create([
                'pesanan_id' => $pesanan->id_pesanan,
                'produk_id' => $item->produk_id_produk,
                'kuantitas_pembelian' => $item->kuantitas,
                'harga_satuan' => $item->produk->harga
            ]);

            // Kurangi stok produk
            $produk = m_produk::find($item->produk_id_produk);
            $produk->stok -= $item->kuantitas;
            $produk->save();
        }

        // 8. HAPUS ITEM DARI KERANJANG
        m_keranjang::where('akun_id_akun', auth()->id())
            ->whereIn('id_keranjang', $selectedItems)
            ->delete();

        // 9. RETURN RESPONSE
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'redirect' => route('pesanan.detail', $pesanan->id_pesanan)
        ]);
    }

    // Lihat daftar pesanan pelanggan
    public function indexPelanggan()
    {
        $pesanan = m_pesanan::where('akun_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('v_pesanan_pelanggan', compact('pesanan'));
    }

    // Lihat detail pesanan pelanggan
    public function detailPelanggan($id)
    {
        $pesanan = m_pesanan::with('detail.produk')
            ->where('akun_id', auth()->id())
            ->where('id_pesanan', $id)
            ->firstOrFail();

        return view('v_detail_pesanan_pelanggan', compact('pesanan'));
    }

    // ==================== ADMIN ====================

    // Lihat semua pesanan (admin)
    public function indexAdmin()
    {
        $pesanan = m_pesanan::with('user', 'detail.produk')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('v_pesanan_admin', compact('pesanan'));
    }

    // Lihat detail pesanan (admin)
    public function detailAdmin($id)
    {
        $pesanan = m_pesanan::with('user', 'detail.produk')->findOrFail($id);
        return view('v_detail_pesanan_admin', compact('pesanan'));
    }

    // Update status pesanan (admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pengecekan pembayaran,diproses,dikirim,ditolak,selesai'
        ]);

        $pesanan = m_pesanan::findOrFail($id);
        $oldStatus = $pesanan->status_pesanan;
        $pesanan->status_pesanan = $request->status;
        $pesanan->save();

        return redirect()->route('admin.pesanan.detail', $id)
            ->with('success', "Status pesanan berhasil diubah dari {$oldStatus} menjadi {$request->status}");
    }

    // Update nomor resi (admin)
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'nomor_resi' => 'required|string|max:50'
        ]);

        $pesanan = m_pesanan::findOrFail($id);
        $pesanan->nomor_resi = $request->nomor_resi;
        $pesanan->save();

        return redirect()->route('admin.pesanan.detail', $id)
            ->with('success', 'Nomor resi berhasil ditambahkan');
    }
}

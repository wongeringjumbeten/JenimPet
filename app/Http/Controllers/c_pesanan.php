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

    public function formCheckout(Request $request)
    {
        $selectedItems = json_decode($request->selected_items, true);

        if (empty($selectedItems)) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada item yang dipilih');
        }

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

    public function prosesCheckout(Request $request)
    {
        // 1. VALIDASI (HAPUS VALIDASI ALAMAT)
            $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'integer|exists:keranjang,id_keranjang',
            'alamat' => 'required|string|min:15|max:500',
            'metode_pembayaran' => 'required|string|in:dana,gopay,shopeepay,bri,mandiri,bca',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:500'
        ]);
        // 2. AMBIL SELECTED ITEMS
        $selectedItems = $request->selected_items;
        $cartItems = m_keranjang::with('produk')
            ->where('akun_id_akun', auth()->id())
            ->whereIn('id_keranjang', $selectedItems)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang');
        }

        // 3. CEK STOK
        foreach ($cartItems as $item) {
            if ($item->kuantitas > $item->produk->stok) {
                return redirect()->back()->with('error', "Stok produk {$item->produk->nama_produk} tidak mencukupi. Tersedia: {$item->produk->stok}");
            }
        }

        // 4. CEK ALAMAT USER
        $user = auth()->user();
        if (empty($user->alamat)) {
            return redirect()->back()->with('error', 'Alamat pengiriman wajib diisi. Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // 5. UPLOAD BUKTI
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // 6. HITUNG TOTAL PRODUK
        $totalProduk = 0;
        foreach ($cartItems as $item) {
            $totalProduk += $item->produk->harga * $item->kuantitas;
        }

        // 6b. AMBIL ONGKIR DARI REQUEST (dari form checkout)
        $ongkir = $request->ongkir ?? 0;

        // 6c. TOTAL PEMBAYARAN = TOTAL PRODUK + ONGKIR
        $totalPembayaran = $totalProduk + $ongkir;

        // 7. SIMPAN PESANAN (DENGAN SNAPSHOT ALAMAT)
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

        // 8. SIMPAN DETAIL & KURANGI STOK
        foreach ($cartItems as $item) {
            m_detailpesanan::create([
                'pesanan_id' => $pesanan->id_pesanan,
                'produk_id' => $item->produk_id_produk,
                'kuantitas_pembelian' => $item->kuantitas,
                'harga_satuan' => $item->produk->harga
            ]);

            $produk = m_produk::find($item->produk_id_produk);
            $produk->stok -= $item->kuantitas;
            $produk->save();
        }

        // 9. HAPUS KERANJANG
        m_keranjang::where('akun_id_akun', auth()->id())
            ->whereIn('id_keranjang', $selectedItems)
            ->delete();

        // 10. REDIRECT
        return redirect()->route('pesanan.detail', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function indexPelanggan()
    {
        $pesanan = m_pesanan::where('akun_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('v_pesananpelanggan', compact('pesanan'));
    }

    public function detailPelanggan($id)
    {
        $pesanan = m_pesanan::with('detail.produk')
            ->where('akun_id', auth()->id())
            ->where('id_pesanan', $id)
            ->firstOrFail();

        return view('v_detailpesananpelanggan', compact('pesanan'));
    }

    // ==================== ADMIN ====================

    public function indexAdmin(Request $request)
    {
    $query = m_pesanan::with('user', 'detail.produk');

    if ($request->has('status') && $request->status != '') {
        $query->where('status_pesanan', $request->status);
    }

    $pesanan = $query->orderBy('created_at', 'desc')->get();

    return view('v_pesananadmin', compact('pesanan'));
    }

    public function detailAdmin($id)
    {
        $pesanan = m_pesanan::with('user', 'detail.produk')->findOrFail($id);
        return view('v_detailpesananadmin', compact('pesanan'));
    }

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

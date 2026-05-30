<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_produk;
use App\Models\m_pesanan;
use App\Models\m_detailpesanan;
use App\Models\m_akun;

class c_dashboard extends Controller
{
    // ==================== ADMIN ====================

    public function index()
    {
        // Total Omset (dari pesanan SELESAI)
        $totalOmset = m_pesanan::where('status_pesanan', 'selesai')->sum('total_pembayaran');

        // Omset Hari Ini (pesanan selesai)
        $omsetHariIni = m_pesanan::where('status_pesanan', 'selesai')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_pembayaran');

        // Omset Minggu Ini (pesanan selesai)
        $omsetMingguIni = m_pesanan::where('status_pesanan', 'selesai')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_pembayaran');

        // Omset Bulan Ini (pesanan selesai)
        $omsetBulanIni = m_pesanan::where('status_pesanan', 'selesai')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_pembayaran');

        // Total Pesanan (semua status)
        $totalPesanan = m_pesanan::count();

        // Pesanan Pending (pengecekan pembayaran)
        $pesananPending = m_pesanan::where('status_pesanan', 'pengecekan pembayaran')->count();

        // Total Produk
        $totalProduk = m_produk::where('is_deleted', '0')->count();

        // Produk terbaru (limit 4)
        $produk = m_produk::where('is_deleted', '0')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Pesanan terbaru (limit 5)
        $pesanan = m_pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return (object) [
                    'id_pesanan' => $item->id_pesanan,
                    'nama_pelanggan' => $item->user->nama_lengkap ?? 'Pelanggan',
                    'total' => $item->total_pembayaran,
                    'status' => $item->status_pesanan,
                    'tanggal' => $item->created_at,
                    'status_label' => $this->getStatusLabel($item->status_pesanan)
                ];
            });

        return view('v_dashboardadmin', compact(
            'totalOmset',
            'omsetHariIni',
            'omsetMingguIni',
            'omsetBulanIni',
            'produk',
            'pesanan',
            'totalPesanan',
            'pesananPending',
            'totalProduk'
        ));
    }

    public function profileAdmin()
    {
        $user = auth()->user();

        $totalProduk = m_produk::where('is_deleted', '0')->count();
        $totalPesanan = m_pesanan::count();
        $totalPendapatan = m_pesanan::where('status_pesanan', 'selesai')->sum('total_pembayaran');
        $totalUser = m_akun::where('is_admin', false)->count();

        return view('v_profiladmin', compact('user', 'totalProduk', 'totalPesanan', 'totalPendapatan', 'totalUser'));
    }

    // ==================== PELANGGAN ====================

    public function dashboardPelanggan()
    {
        $user = auth()->user();

        // Ambil 4 produk terbaru untuk ditampilkan di dashboard
        $produkTerbaru = m_produk::where('is_deleted', '0')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Ambil riwayat pesanan pelanggan (limit 3)
        $riwayatPesanan = m_pesanan::with('detail.produk')
            ->where('akun_id', $user->id_akun)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Total pesanan pelanggan
        $totalPesanan = m_pesanan::where('akun_id', $user->id_akun)->count();

        // Total pendapatan (dari pesanan selesai)
        $totalPendapatan = m_pesanan::where('akun_id', $user->id_akun)
            ->where('status_pesanan', 'selesai')
            ->sum('total_pembayaran');

        return view('v_dashboardpelanggan', compact(
            'user',
            'produkTerbaru',
            'riwayatPesanan',
            'totalPesanan',
            'totalPendapatan'
        ));
    }

    // Helper untuk status label
    private function getStatusLabel($status)
    {
        $labels = [
            'pengecekan pembayaran' => ['label' => 'Pengecekan Pembayaran', 'color' => 'bg-yellow-500'],
            'diproses' => ['label' => 'Diproses', 'color' => 'bg-blue-500'],
            'dikirim' => ['label' => 'Dikirim', 'color' => 'bg-indigo-500'],
            'ditolak' => ['label' => 'Ditolak', 'color' => 'bg-red-500'],
            'selesai' => ['label' => 'Selesai', 'color' => 'bg-green-500'],
        ];
        return $labels[$status] ?? ['label' => $status, 'color' => 'bg-gray-500'];
    }
}

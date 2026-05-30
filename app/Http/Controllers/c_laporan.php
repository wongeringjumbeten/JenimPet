<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\m_pesanan;
use App\Models\m_detailpesanan;
use App\Models\m_produk;
use Illuminate\Support\Facades\DB;

class c_laporan extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'year');

        // Ambil data pesanan selesai
        $query = m_pesanan::where('status_pesanan', 'selesai');

        $now = now();
        switch ($period) {
            case 'day':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'week':
                $query->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                break;
            case 'year':
                $query->whereYear('created_at', $now->year);
                break;
        }

        $pesananSelesai = $query->get();

        // Total Omset & Pesanan
        $totalOmset = $pesananSelesai->sum('total_pembayaran');
        $totalPesanan = $pesananSelesai->count();

        // Data untuk grafik per bulan (tahun ini)
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = m_pesanan::where('status_pesanan', 'selesai')
                ->whereYear('created_at', $now->year)
                ->whereMonth('created_at', $i)
                ->sum('total_pembayaran');
        }

        // Produk Terlaris dari detail pesanan (hanya pesanan selesai)
        $produkTerlaris = m_detailpesanan::select(
                'produk_id',
                DB::raw('SUM(kuantitas_pembelian) as total_terjual')
            )
            ->whereHas('pesanan', function($q) {
                $q->where('status_pesanan', 'selesai');
            })
            ->groupBy('produk_id')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->with('produk')
            ->get();

        return response()->json([
            'total_omset' => $totalOmset,
            'total_pesanan' => $totalPesanan,
            'monthly_data' => $monthlyData,
            'produk_terlaris' => $produkTerlaris,
            'period' => $period
        ]);
    }
    public function getTransaksi(Request $request)
{
    $period = $request->get('period', 'year');

    $query = m_pesanan::with('user', 'detail.produk')
        ->where('status_pesanan', 'selesai');

    $now = now();
    switch ($period) {
        case 'day':
            $query->whereDate('created_at', $now->toDateString());
            break;
        case 'week':
            $query->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]);
            break;
        case 'month':
            $query->whereMonth('created_at', $now->month)
                  ->whereYear('created_at', $now->year);
            break;
        case 'year':
            $query->whereYear('created_at', $now->year);
            break;
    }

    $pesanan = $query->get();

    $transaksi = [];
    foreach ($pesanan as $p) {
        foreach ($p->detail as $item) {
            $transaksi[] = [
                'nama_pelanggan' => $p->user->nama_lengkap ?? 'Unknown',
                'tanggal' => $p->created_at->format('d-m-Y'),
                'metode_pembayaran' => $p->metode_pembayaran,
                'metode_pembayaran_label' => $p->metode_pembayaran_label,
                'nama_produk' => $item->produk->nama_produk ?? 'Produk tidak ditemukan',
                'jumlah' => $item->kuantitas_pembelian,
                'total' => $item->subtotal
            ];
        }
    }

    return response()->json([
        'transaksi' => $transaksi
    ]);
}
}

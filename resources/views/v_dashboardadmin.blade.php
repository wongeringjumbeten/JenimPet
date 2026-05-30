<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out forwards;
        }
        .stat-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -10px rgba(0, 0, 0, 0.15);
        }
        .product-item {
            transition: all 0.2s ease;
        }
        .product-item:hover {
            transform: translateX(4px);
            background-color: #D4A574/10;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar')

<section class="px-6 md:px-16 py-10">

    {{-- HERO --}}
    <div class="mb-10 animate-fade-slide-up">
        <h1 class="text-4xl font-bold text-[#2C1810] mb-3">
            Halo, Admin! 
        </h1>
        <p class="text-[#6B5847] max-w-xl">
            Selamat datang di dashboard admin. Anda dapat memantau aktivitas penjualan,
            mengelola katalog produk, serta melihat riwayat transaksi pelanggan secara real-time.
        </p>
    </div>

    {{-- STATS CARDS (Ringkasan) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4]">
            <p class="text-sm text-[#6B5847]">Total Omset</p>
            <h3 class="text-2xl font-bold text-[#D4A574]">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4]">
            <p class="text-sm text-[#6B5847]">Total Pesanan</p>
            <h3 class="text-2xl font-bold text-[#2C1810]">{{ number_format($totalPesanan) }}</h3>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4]">
            <p class="text-sm text-[#6B5847]">Pesanan Pending</p>
            <h3 class="text-2xl font-bold text-[#2C1810]">{{ number_format($pesananPending) }}</h3>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4]">
            <p class="text-sm text-[#6B5847]">Total Produk</p>
            <h3 class="text-2xl font-bold text-[#2C1810]">{{ number_format(\App\Models\m_produk::count()) }}</h3>
        </div>
    </div>

    {{-- LAPORAN OMSET --}}
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow mb-10 animate-scale-in">
        <h2 class="text-xl font-semibold text-[#2C1810] mb-6">
            Laporan Omset
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-[#F5E6D3] p-4 rounded-xl hover:scale-105 hover:shadow-lg transition">
                <p class="text-sm text-[#6B5847]">Hari Ini</p>
                <h3 class="text-lg font-bold text-[#2C1810]">Rp {{ number_format($omsetHariIni, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-[#F5E6D3] p-4 rounded-xl hover:scale-105 hover:shadow-lg transition">
                <p class="text-sm text-[#6B5847]">Minggu Ini</p>
                <h3 class="text-lg font-bold text-[#2C1810]">Rp {{ number_format($omsetMingguIni, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-[#F5E6D3] p-4 rounded-xl hover:scale-105 hover:shadow-lg transition">
                <p class="text-sm text-[#6B5847]">Bulan Ini</p>
                <h3 class="text-lg font-bold text-[#2C1810]">Rp {{ number_format($omsetBulanIni, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-[#F5E6D3] p-4 rounded-xl hover:scale-105 hover:shadow-lg transition">
                <p class="text-sm text-[#6B5847]">Total Omset</p>
                <h3 class="text-lg font-bold text-[#D4A574]">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- KATALOG --}}
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow mb-10 animate-scale-in">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-[#2C1810]">
                Katalog Produk Terbaru
            </h2>
            <a href="{{ route('admin.katalog') }}" class="text-[#D4A574] hover:underline text-sm flex items-center gap-1">
                Lihat selengkapnya →
            </a>
        </div>

        @if($produk->isEmpty())
            <div class="text-center py-10 text-[#6B5847]">
                Belum terdapat data katalog produk. Silakan tambahkan produk untuk mulai mengelola penjualan Anda.
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($produk as $p)
                <div class="product-item p-4 rounded-xl bg-[#F5E6D3] hover:shadow-lg transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-[#2C1810]">{{ $p->nama_produk }}</h3>
                            <p class="text-sm text-[#6B5847]">Stok: {{ $p->stok }}</p>
                        </div>
                        <span class="text-[#D4A574] font-semibold">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- PESANAN TERBARU --}}
<div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow animate-scale-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-[#2C1810]">
            Pesanan Terbaru
        </h2>
        <a href="{{ route('admin.pesanan') }}" class="text-[#D4A574] hover:underline text-sm flex items-center gap-1">
            Lihat selengkapnya →
        </a>
    </div>

    @if($pesanan->isEmpty())
        <div class="text-center py-10 text-[#6B5847]">
            Belum terdapat transaksi yang tercatat.
        </div>
    @else
        <div class="space-y-3">
            @foreach($pesanan as $ps)
            <div class="p-4 bg-[#F5E6D3] rounded-xl flex justify-between items-center hover:shadow-lg transition">
                <div>
                    <h3 class="font-semibold text-[#2C1810]">
                        {{ $ps->nama_pelanggan }}
                    </h3>
                    <p class="text-xs text-[#6B5847] font-mono">
                        #{{ $ps->id_pesanan }} • {{ \Carbon\Carbon::parse($ps->tanggal)->translatedFormat('d F Y, H:i') }}
                    </p>
                    <p class="text-xs mt-1">
                        <span class="px-2 py-0.5 rounded-full text-white text-xs {{ $ps->status_label['color'] }}">
                            {{ $ps->status_label['label'] }}
                        </span>
                    </p>
                </div>
                <span class="text-[#D4A574] font-semibold">Rp {{ number_format($ps->total, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
    @endif
</div>

</section>

</body>
</html>

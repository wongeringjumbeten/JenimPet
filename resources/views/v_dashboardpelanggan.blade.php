<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - JenimPet</title>
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
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }
        .product-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: scale(1.02);
        }
        .order-item {
            transition: all 0.2s ease;
        }
        .order-item:hover {
            background-color: #F5E6D3;
            transform: translateX(4px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="px-6 md:px-16 py-10">

    {{-- HERO SECTION --}}
    <div class="mb-12 animate-fade-slide-up">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl md:text-5xl font-bold text-[#2C1810] mb-3">
                    Halo, {{ $user->nama_lengkap }}! 👋
                </h1>
                <p class="text-[#6B5847] max-w-xl">
                    Selamat datang di dashboard pelanggan JenimPet. Lihat pesanan terbaru, produk favorit, dan info toko di sini.
                </p>
            </div>
            <div class="relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-[#D4A574] to-[#B8965A] rounded-full blur opacity-0 group-hover:opacity-50 transition duration-500"></div>
                <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/100' }}"
                     class="w-20 h-20 rounded-full border-4 border-[#D4A574] shadow-lg object-cover">
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4] shadow-md animate-scale-in" style="animation-delay: 0.05s">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-[#6B5847]">Total Pesanan</p>
                    <p class="text-2xl font-bold text-[#2C1810]">{{ number_format($totalPesanan) }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4] shadow-md animate-scale-in" style="animation-delay: 0.1s">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-[#6B5847]">Total Belanja</p>
                    <p class="text-2xl font-bold text-[#D4A574]">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-2xl p-5 border border-[#E8D5C4] shadow-md animate-scale-in" style="animation-delay: 0.15s">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-[#6B5847]">Member Sejak</p>
                    <p class="text-lg font-bold text-[#2C1810]">{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUK TERBARU --}}
    <div class="mb-12 animate-scale-in">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#2C1810] flex items-center gap-2">
                <span class="text-3xl animate-float">🐹</span>
                Produk Terbaru
            </h2>
            <a href="{{ route('katalog.pelanggan') }}" class="text-[#D4A574] hover:underline text-sm flex items-center gap-1">
                Lihat semua →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($produkTerbaru as $item)
            <div class="product-card bg-white/70 backdrop-blur-sm rounded-2xl overflow-hidden shadow border border-[#E8D5C4] hover:shadow-xl transition">
                <div class="aspect-square overflow-hidden bg-[#F5E6D3]">
                    <img src="{{ asset('storage/'.$item->foto_produk) }}"
                         alt="{{ $item->nama_produk }}"
                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-[#2C1810]">{{ $item->nama_produk }}</h3>
                    <p class="text-sm text-[#6B5847] mt-1 line-clamp-2">{{ $item->deskripsi }}</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-lg font-bold text-[#D4A574]">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <a href="{{ route('katalog.detail', $item->id_produk) }}"
                           class="px-3 py-1 bg-[#D4A574] text-white rounded-lg text-sm hover:bg-[#B8965A] transition">
                            Beli
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- RIWAYAT PESANAN & LOKASI TOKO --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- RIWAYAT PESANAN --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in">
            <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Riwayat Pesanan
            </h2>

            @if($riwayatPesanan->isEmpty())
                <div class="text-center py-10 text-[#6B5847]">
                    <div class="text-5xl mb-3">📦</div>
                    <p>Belum ada pesanan</p>
                    <a href="{{ route('katalog.pelanggan') }}" class="inline-block mt-3 text-[#D4A574] hover:underline">Mulai Belanja</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($riwayatPesanan as $pesanan)
                    <div class="order-item p-4 bg-[#F5E6D3]/30 rounded-xl transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-xs text-[#6B5847] font-mono">#{{ $pesanan->id_pesanan }}</p>
                                <p class="text-xs text-[#6B5847]">{{ $pesanan->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-white text-xs font-semibold
                                @if($pesanan->status_pesanan == 'pengecekan pembayaran') bg-yellow-500
                                @elseif($pesanan->status_pesanan == 'diproses') bg-blue-500
                                @elseif($pesanan->status_pesanan == 'dikirim') bg-indigo-500
                                @elseif($pesanan->status_pesanan == 'ditolak') bg-red-500
                                @elseif($pesanan->status_pesanan == 'selesai') bg-green-500
                                @else bg-gray-500
                                @endif">
                                {{ $pesanan->status_label['label'] ?? $pesanan->status_pesanan }}
                            </span>
                        </div>
                        <div class="space-y-2">
                            @foreach($pesanan->detail as $item)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-[#2C1810]">{{ $item->produk->nama_produk }} ({{ $item->kuantitas_pembelian }}x)</span>
                                <span class="text-sm font-semibold text-[#D4A574]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-2 border-t border-[#E8D5C4] flex justify-between items-center">
                            <span class="text-sm font-bold text-[#2C1810]">Total</span>
                            <span class="font-bold text-[#D4A574]">Rp {{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($totalPesanan > 3)
                <div class="mt-4 text-center">
                    <a href="{{ route('pesanan.index') }}" class="text-sm text-[#D4A574] hover:underline">Lihat semua pesanan →</a>
                </div>
                @endif
            @endif
        </div>

        {{-- LOKASI TOKO --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in">
            <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Lokasi Toko
            </h2>
            <div class="rounded-2xl overflow-hidden shadow-lg mb-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7898.800141188276!2d113.6995634!3d-8.1623861!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695745f57a925%3A0xbf3f0ef2a184a578!2sJenim%20Hamster%20Farm!5e0!3m2!1sid!2sid!4v1776688569039!5m2!1sid!2sid"
                    width="100%"
                    height="250"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
            <div class="space-y-3 mt-4">
                <div class="flex items-center gap-3 p-2 hover:bg-[#F5E6D3]/30 rounded-lg transition">
                    <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-[#6B5847]">Alamat</p>
                        <p class="text-sm font-medium text-[#2C1810]">Jl. Herpet No.123, Jakarta Selatan, DKI Jakarta 12345</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-2 hover:bg-[#F5E6D3]/30 rounded-lg transition">
                    <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-[#6B5847]">Telepon</p>
                        <p class="text-sm font-medium text-[#2C1810]">+62 812-3456-7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-2 hover:bg-[#F5E6D3]/30 rounded-lg transition">
                    <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-[#6B5847]">Email</p>
                        <p class="text-sm font-medium text-[#2C1810]">hello@jenimpets.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- REVIEW PELANGGAN --}}
<div class="mt-8 bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in">
    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
        </svg>
        Review Pelanggan
    </h2>
    <div class="elfsight-widget-container">
        <script src="https://elfsightcdn.com/platform.js" async></script>
        <div class="elfsight-app-1b2adfe6-8ccd-47d4-bacc-0e4b8f5d486e" data-elfsight-app-lazy></div>
    </div>
</div>

</div>

</body>
</html>

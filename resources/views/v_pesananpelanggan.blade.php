<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pesanan Saya - JenimPet</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        .status-badge {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        .status-badge:hover::before {
            left: 100%;
        }
        .status-badge:hover {
            transform: scale(1.05);
            filter: brightness(1.05);
        }
        .order-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .order-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 35px -12px rgba(0, 0, 0, 0.2);
        }
        .item-hover {
            transition: all 0.2s ease;
        }
        .item-hover:hover {
            background-color: #F5E6D3;
            transform: translateX(4px);
        }
        .empty-state {
            animation: fadeSlideUp 0.5s ease-out;
        }
        /* Skeleton loader */
        .skeleton {
            background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
            background-size: 1000px 100%;
            animation: shimmer 1.5s infinite;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #E8D5C4;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4A574;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    {{-- Header dengan animasi --}}
    <div class="mb-8 relative">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#D4A574]/20 rounded-full blur-2xl"></div>
        <h1 class="text-3xl md:text-5xl font-bold text-[#2C1810] mb-2 relative inline-block">
            Pesanan Saya
            <div class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-[#D4A574] to-[#B8965A] rounded-full"></div>
        </h1>
        <p class="text-[#6B5847] mt-4 max-w-md">Lihat status dan riwayat pesanan Anda</p>
    </div>

    @if($pesanan->isEmpty())
        {{-- EMPTY STATE YANG MENARIK --}}
        <div class="empty-state bg-white/70 backdrop-blur-xl rounded-3xl p-12 text-center border border-[#E8D5C4] transition-all duration-300 hover:shadow-2xl">
            <div class="text-8xl mb-6 animate-bounce">📦</div>
            <p class="text-xl font-semibold text-[#2C1810]">Belum ada pesanan</p>
            <p class="text-[#6B5847] mt-2">Yuk, mulai belanja sekarang!</p>
            <a href="{{ route('katalog.pelanggan') }}"
               class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl hover:scale-105 hover:shadow-xl transition-all duration-300 group">
                <span>Belanja Sekarang</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    @else
        {{-- DAFTAR PESANAN --}}
        <div class="space-y-8">
            @foreach($pesanan as $index => $p)
            <div class="order-card bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden hover:shadow-2xl transition-all duration-300 animate-scale-in" style="animation-delay: {{ $index * 0.05 }}s">
                {{-- HEADER CARD --}}
                <div class="p-6 bg-gradient-to-r from-[#D4A574]/5 to-transparent border-b border-[#E8D5C4]">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                        {{-- ID Pesanan --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-[#6B5847]">ID PESANAN</p>
                                <p class="font-mono font-bold text-lg text-[#2C1810]">#{{ $p->id_pesanan }}</p>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-[#6B5847]">TANGGAL</p>
                                <p class="font-medium text-[#2C1810]">{{ $p->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-[#6B5847]">TOTAL</p>
                                <p class="font-bold text-xl text-[#D4A574]">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Status Badge --}}
                        <div>
                            <span class="status-badge inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-white text-sm font-semibold {{ $p->status_label['color'] }} shadow-md">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                {{ $p->status_label['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- PRODUK YANG DIPESAN --}}
                <div class="p-6 space-y-3">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-xs font-semibold text-[#6B5847] uppercase tracking-wide">Produk yang Dipesan</p>
                    </div>
                    <div class="grid gap-3">
                        @foreach($p->detail as $item)
                        <div class="item-hover flex items-center gap-4 p-3 bg-white/50 rounded-xl transition-all duration-200">
                            <div class="w-14 h-14 bg-white rounded-xl overflow-hidden shadow-md flex-shrink-0">
                                <img src="{{ asset('storage/'.$item->produk->foto_produk) }}"
                                     alt="{{ $item->produk->nama_produk }}"
                                     class="w-full h-full object-cover hover:scale-110 transition duration-300">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</h3>
                                <p class="text-xs text-[#6B5847]">{{ $item->kuantitas_pembelian }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#D4A574]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- FOOTER CARD --}}
                <div class="px-6 py-4 bg-gradient-to-r from-transparent to-[#D4A574]/5 border-t border-[#E8D5C4] flex justify-end">
                    <a href="{{ route('pesanan.detail', $p->id_pesanan) }}"
                       class="inline-flex items-center gap-2 text-sm font-medium text-[#D4A574] hover:text-[#B8965A] transition-all duration-300 group px-4 py-2 rounded-xl hover:bg-white/50">
                        <span>Detail Pesanan</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- INFO TAMBAHAN (Opsional) --}}
        <div class="mt-8 text-center">
            <p class="text-xs text-[#6B5847]">Menampilkan {{ $pesanan->count() }} pesanan</p>
        </div>
    @endif
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - JenimPet</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .status-badge {
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
        .order-card {
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    <h1 class="text-3xl md:text-4xl font-bold text-[#2C1810] mb-2">Pesanan Saya</h1>
    <p class="text-[#6B5847] mb-8">Lihat status dan riwayat pesanan Anda</p>

    @if($pesanan->isEmpty())
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-12 text-center border border-[#E8D5C4]">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-lg font-medium text-[#6B5847]">Belum ada pesanan</p>
            <p class="text-sm text-[#8B7355] mt-1">Yuk, mulai belanja sekarang!</p>
            <a href="{{ route('katalog.pelanggan') }}"
               class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl hover:scale-105 transition">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($pesanan as $p)
            <div class="order-card bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg border border-[#E8D5C4] overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="p-6">
                    {{-- Header --}}
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 pb-4 border-b border-[#E8D5C4]">
                        <div>
                            <p class="text-xs text-[#6B5847]">ID PESANAN</p>
                            <p class="font-mono font-semibold text-[#2C1810]">#{{ $p->id_pesanan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#6B5847]">TANGGAL PESANAN</p>
                            <p class="font-medium text-[#2C1810]">{{ $p->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#6B5847]">TOTAL PEMBAYARAN</p>
                            <p class="font-bold text-lg text-[#D4A574]">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <span class="status-badge inline-block px-3 py-1 rounded-full text-white text-xs font-semibold {{ $p->status_label['color'] }}">
                                {{ $p->status_label['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="pt-4 space-y-3">
                        @foreach($p->detail as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-lg overflow-hidden shadow-sm flex-shrink-0">
                                <img src="{{ asset('storage/'.$item->produk->foto_produk) }}"
                                     alt="{{ $item->produk->nama_produk }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</h3>
                                <p class="text-xs text-[#6B5847]">{{ $item->kuantitas_pembelian }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-[#2C1810]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer with detail button --}}
                    <div class="pt-4 mt-2 border-t border-[#E8D5C4] flex justify-end">
                        <a href="{{ route('pesanan.detail', $p->id_pesanan) }}"
                           class="inline-flex items-center gap-2 text-sm text-[#D4A574] hover:text-[#B8965A] transition group">
                            Detail Pesanan
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>

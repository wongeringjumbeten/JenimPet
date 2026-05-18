<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - JenimPet</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scalePop {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-pop {
            animation: scalePop 0.3s ease-out forwards;
        }
        .status-badge {
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="max-w-4xl mx-auto px-6 py-10 animate-fade-slide-up">
    {{-- Tombol Kembali --}}
    <a href="{{ route('pesanan.index') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/50 backdrop-blur-sm rounded-full text-[#6B5847] hover:bg-white/70 hover:scale-105 transition-all duration-300 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Pesanan Saya
    </a>

    {{-- Header Pesanan --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden animate-scale-pop">
        <div class="p-6 border-b border-[#E8D5C4] bg-gradient-to-r from-[#D4A574]/10 to-transparent">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <p class="text-xs text-[#6B5847]">ID PESANAN</p>
                    <p class="font-mono font-bold text-xl text-[#2C1810]">#{{ $pesanan->id_pesanan }}</p>
                </div>
                <div>
                    <p class="text-xs text-[#6B5847]">TANGGAL PESANAN</p>
                    <p class="font-medium text-[#2C1810]">{{ $pesanan->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div>
                    <span class="status-badge inline-block px-4 py-2 rounded-full text-white text-sm font-semibold {{ $pesanan->status_label['color'] }}">
                        {{ $pesanan->status_label['label'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="p-6 border-b border-[#E8D5C4]">
            <h2 class="text-lg font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-4-4m4 4H4m16 0l-4-4" />
                </svg>
                Detail Produk
            </h2>
            <div class="space-y-3">
                @foreach($pesanan->detail as $item)
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 p-3 bg-[#F5E6D3]/30 rounded-xl animate-scale-pop">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/'.$item->produk->foto_produk) }}"
                             alt="{{ $item->produk->nama_produk }}"
                             class="w-12 h-12 object-cover rounded-lg bg-white shadow">
                        <div>
                            <p class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</p>
                            <p class="text-xs text-[#6B5847]">Harga Satuan: Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <p class="text-sm text-[#6B5847]">Jumlah: {{ $item->kuantitas_pembelian }}x</p>
                        <p class="font-bold text-[#D4A574]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Total Harga --}}
        <div class="p-6 border-b border-[#E8D5C4] bg-[#F5E6D3]/20">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-[#2C1810]">Total Harga</span>
                <span class="text-2xl font-bold text-[#D4A574]">Rp {{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="p-6 border-b border-[#E8D5C4]">
            <h2 class="text-lg font-bold text-[#2C1810] mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Metode Pembayaran
            </h2>
            <p class="font-medium text-[#2C1810]">{{ $pesanan->metode_pembayaran_label }}</p>
        </div>

        {{-- Catatan --}}
        @if($pesanan->catatan)
        <div class="p-6 border-b border-[#E8D5C4]">
            <h2 class="text-lg font-bold text-[#2C1810] mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Catatan
            </h2>
            <p class="text-[#6B5847] italic">"{{ $pesanan->catatan }}"</p>
        </div>
        @endif

        {{-- Alamat Pengiriman --}}
        <div class="p-6 border-b border-[#E8D5C4]">
            <h2 class="text-lg font-bold text-[#2C1810] mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Lokasi Pengiriman
            </h2>
            <p class="text-[#2C1810]">{{ $pesanan->alamat ?? 'Alamat tidak tersedia' }}</p>
        </div>

        {{-- Bukti Pembayaran --}}
        <div class="p-6">
            <h2 class="text-lg font-bold text-[#2C1810] mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Bukti Pembayaran
            </h2>
            <div class="mt-2">
                <a href="{{ asset('storage/'.$pesanan->bukti_pembayaran) }}" target="_blank"
                   class="inline-flex items-center gap-2 text-[#D4A574] hover:text-[#B8965A] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Bukti Pembayaran
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

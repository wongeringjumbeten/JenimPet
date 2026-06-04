<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - JenimPet</title>
    <link rel="icon" type="image/png" href="{{ asset('icons/JenimHamsterLogo.png') }}">
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

        {{-- Tombol WhatsApp --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 transition-all duration-300 hover:shadow-2xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.077 4.928C17.191 3.041 14.683 2 12.006 2 6.798 2 2.5 6.298 2.5 11.505c0 1.688.438 3.335 1.274 4.796L2.5 21.5l5.323-1.289c1.396.756 2.964 1.144 4.55 1.144h.004c5.202 0 9.5-4.298 9.5-9.505 0-2.677-1.041-5.186-2.928-7.082z M12.006 20.232c-1.443 0-2.855-.392-4.07-1.125l-.297-.176-3.196.774.824-3.079-.184-.3a8.247 8.247 0 01-1.312-4.401c0-4.563 3.718-8.281 8.285-8.281 2.212 0 4.291.864 5.85 2.423 1.56 1.56 2.419 3.639 2.419 5.85 0 4.563-3.718 8.281-8.285 8.281z M16.878 13.869c-.271-.136-1.586-.781-1.833-.87-.247-.09-.427-.136-.607.136-.18.272-.699.871-.856 1.049-.157.178-.314.2-.585.064-.271-.136-1.144-.422-2.178-1.344-.805-.718-1.348-1.604-1.507-1.875-.157-.271-.017-.418.12-.554.123-.123.271-.318.405-.478.135-.159.18-.271.27-.452.09-.181.045-.34-.022-.476s-.607-1.463-.83-2.003c-.219-.528-.44-.457-.607-.457-.157 0-.337-.02-.517-.02-.18 0-.472.067-.719.338-.247.271-.94.922-.94 2.245 0 1.323.959 2.598 1.095 2.78.136.18 1.892 2.89 4.585 4.053.64.276 1.141.442 1.532.567.644.204 1.23.175 1.693.106.517-.076 1.586-.648 1.81-1.274.224-.626.224-1.162.157-1.274-.067-.112-.247-.18-.518-.315z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-[#2C1810]">Butuh Bantuan?</h3>
                    <p class="text-sm text-[#6B5847]">Mengalami kendala saat checkout? Tim kami siap membantu Anda melalui WhatsApp.</p>
                </div>
                <a href="#" target="_blank"
                class="flex items-center gap-2 px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-all duration-200 hover:scale-105 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.077 4.928C17.191 3.041 14.683 2 12.006 2 6.798 2 2.5 6.298 2.5 11.505c0 1.688.438 3.335 1.274 4.796L2.5 21.5l5.323-1.289c1.396.756 2.964 1.144 4.55 1.144h.004c5.202 0 9.5-4.298 9.5-9.505 0-2.677-1.041-5.186-2.928-7.082z M12.006 20.232c-1.443 0-2.855-.392-4.07-1.125l-.297-.176-3.196.774.824-3.079-.184-.3a8.247 8.247 0 01-1.312-4.401c0-4.563 3.718-8.281 8.285-8.281 2.212 0 4.291.864 5.85 2.423 1.56 1.56 2.419 3.639 2.419 5.85 0 4.563-3.718 8.281-8.285 8.281z M16.878 13.869c-.271-.136-1.586-.781-1.833-.87-.247-.09-.427-.136-.607.136-.18.272-.699.871-.856 1.049-.157.178-.314.2-.585.064-.271-.136-1.144-.422-2.178-1.344-.805-.718-1.348-1.604-1.507-1.875-.157-.271-.017-.418.12-.554.123-.123.271-.318.405-.478.135-.159.18-.271.27-.452.09-.181.045-.34-.022-.476s-.607-1.463-.83-2.003c-.219-.528-.44-.457-.607-.457-.157 0-.337-.02-.517-.02-.18 0-.472.067-.719.338-.247.271-.94.922-.94 2.245 0 1.323.959 2.598 1.095 2.78.136.18 1.892 2.89 4.585 4.053.64.276 1.141.442 1.532.567.644.204 1.23.175 1.693.106.517-.076 1.586-.648 1.81-1.274.224-.626.224-1.162.157-1.274-.067-.112-.247-.18-.518-.315z"/>
                    </svg>
                    <span>Hubungi via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

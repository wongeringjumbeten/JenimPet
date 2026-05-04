<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - JenimPet</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="px-6 md:px-16 py-10">

    {{-- TITLE --}}
    <h1 class="text-3xl font-bold text-[#2C1810]">
        Temukan Produk Terbaik untuk Hewan Kesayanganmu 🐾
    </h1>

    <p class="text-[#6B5847] mt-2 mb-8 max-w-xl">
        Kami menyediakan berbagai pilihan produk berkualitas mulai dari makanan, aksesoris, hingga kebutuhan perawatan hewan peliharaan Anda.
    </p>

    {{-- CEK APAKAH ADA PRODUK --}}
    @if($produk->isEmpty())
        <div class="text-center text-gray-500 mt-20">
            <p class="text-lg font-medium">
                Belum ada produk tersedia
            </p>
            <p class="text-sm">
                Silakan kembali lagi nanti
            </p>
        </div>
    @else

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($produk as $item)
        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

            {{-- FOTO --}}
            <div class="w-full aspect-square bg-gray-200 overflow-hidden">
                <img src="{{ asset('storage/'.$item->foto_produk) }}"
                    alt="{{ $item->nama_produk }}"
                    class="w-full h-full object-cover hover:scale-105 transition duration-300">
            </div>

            {{-- INFO --}}
            <div class="p-3">

                <h2 class="font-semibold text-sm text-[#2C1810] truncate">
                    {{ $item->nama_produk }}
                </h2>

                <p class="text-xs text-gray-500 line-clamp-2 mt-1">
                    {{ $item->deskripsi }}
                </p>

                <div class="flex justify-between items-center mt-3">

                    <span class="text-sm font-bold text-[#D4A574]">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </span>

                    <span class="text-xs text-gray-500">
                        🐹 Stok: {{ $item->stok }}
                    </span>

                    <button class="text-xs bg-[#D4A574] text-white px-3 py-1 rounded-lg hover:bg-[#B8965A] hover:scale-105 transition">
                        Beli
                    </button>

                </div>

            </div>

        </div>
        @endforeach

    </div>

    @endif

</div>

</body>
</html>

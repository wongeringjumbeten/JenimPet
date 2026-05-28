<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog - JenimPet</title>
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
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -10px rgba(0, 0, 0, 0.15);
        }
        .search-highlight {
            background-color: #D4A57430;
            border-radius: 4px;
            padding: 0 2px;
        }
        .skeleton {
            background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
            background-size: 1000px 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    {{-- TITLE --}}
    <h1 class="text-3xl md:text-4xl font-bold text-[#2C1810]">
        Temukan Produk Terbaik untuk Hewan Kesayanganmu 🐾
    </h1>
    <p class="text-[#6B5847] mt-2 mb-8 max-w-xl">
        Kami menyediakan berbagai pilihan produk berkualitas mulai dari makanan, aksesoris, hingga kebutuhan perawatan hewan peliharaan Anda.
    </p>

    {{-- SEARCH BAR --}}
    <div class="mb-8 max-w-md">
        <div class="relative">
            <input type="text" id="searchInput"
                   placeholder="Cari produk..."
                   autocomplete="off"
                   class="w-full px-5 py-3 pl-12 rounded-2xl border border-[#D4A574]/50 bg-white/80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-[#D4A574] transition-all duration-200">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#6B5847]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            @if(request()->get('search'))
            <a href="{{ route('katalog.pelanggan') }}"
               class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-[#D4A574] hover:text-[#B8965A] transition">
                Reset
            </a>
            @endif
        </div>
        <p id="searchResultCount" class="text-xs text-[#6B5847] mt-2"></p>
    </div>

    {{-- LOADING SKELETON (ditampilkan saat search) --}}
    <div id="loadingSkeleton" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
        @for($i = 0; $i < 4; $i++)
        <div class="bg-white/70 rounded-2xl overflow-hidden">
            <div class="skeleton w-full aspect-square"></div>
            <div class="p-3 space-y-2">
                <div class="skeleton h-5 w-3/4 rounded"></div>
                <div class="skeleton h-4 w-full rounded"></div>
                <div class="skeleton h-4 w-2/3 rounded"></div>
                <div class="flex justify-between items-center pt-2">
                    <div class="skeleton h-5 w-20 rounded"></div>
                    <div class="skeleton h-8 w-16 rounded-full"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    {{-- GRID PRODUK --}}
    <div id="produkGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($produk as $item)
        <div class="product-card bg-white/80 backdrop-blur-sm rounded-2xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden group animate-scale-in"
             data-nama="{{ strtolower($item->nama_produk) }}"
             data-deskripsi="{{ strtolower($item->deskripsi) }}">
            {{-- FOTO --}}
            <div class="w-full aspect-square bg-gray-200 overflow-hidden">
                <img src="{{ asset('storage/'.$item->foto_produk) }}"
                     alt="{{ $item->nama_produk }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
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
                    <a href="{{ route('katalog.detail', $item->id_produk) }}"
                       class="block text-center text-xs bg-[#D4A574] text-white px-3 py-1 rounded-lg hover:bg-[#B8965A] hover:scale-105 transition">
                        Beli
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- EMPTY STATE (ditampilkan saat search tidak menemukan hasil) --}}
    <div id="emptyState" class="text-center py-20 hidden">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-lg font-medium text-[#6B5847]">Produk tidak ditemukan</p>
        <p class="text-sm text-[#8B7355] mt-1">Coba gunakan kata kunci lain</p>
    </div>

    @if($produk->isEmpty())
    <div id="noProductState" class="text-center text-gray-500 mt-20">
        <p class="text-lg font-medium">Belum ada produk tersedia</p>
        <p class="text-sm">Silakan kembali lagi nanti</p>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const produkGrid = document.getElementById('produkGrid');
    const loadingSkeleton = document.getElementById('loadingSkeleton');
    const emptyState = document.getElementById('emptyState');
    const noProductState = document.getElementById('noProductState');
    const searchResultCount = document.getElementById('searchResultCount');

    let searchTimeout;
    let originalProdukHTML = produkGrid ? produkGrid.innerHTML : '';
    let allProducts = [];

    // Simpan data semua produk
    if (produkGrid) {
        const productCards = produkGrid.querySelectorAll('.product-card');
        productCards.forEach(card => {
            allProducts.push({
                element: card,
                nama: card.dataset.nama || '',
                deskripsi: card.dataset.deskripsi || '',
                html: card.outerHTML
            });
        });
    }

    // Fungsi filter produk
    function filterProducts(keyword) {
        if (!produkGrid) return;

        const trimmedKeyword = keyword.trim().toLowerCase();

        if (trimmedKeyword === '') {
            // Tampilkan semua produk
            produkGrid.innerHTML = originalProdukHTML;
            emptyState.classList.add('hidden');
            searchResultCount.innerText = `Menampilkan ${allProducts.length} produk`;
            return;
        }

        // Filter produk
        const filtered = allProducts.filter(product =>
            product.nama.includes(trimmedKeyword) ||
            product.deskripsi.includes(trimmedKeyword)
        );

        if (filtered.length === 0) {
            produkGrid.innerHTML = '';
            emptyState.classList.remove('hidden');
            searchResultCount.innerText = `Tidak ada produk untuk "${keyword}"`;
        } else {
            produkGrid.innerHTML = filtered.map(p => p.html).join('');
            emptyState.classList.add('hidden');
            searchResultCount.innerText = `Menampilkan ${filtered.length} hasil untuk "${keyword}"`;

            // Highlight kata kunci
            if (trimmedKeyword !== '') {
                highlightKeyword(trimmedKeyword);
            }
        }
    }

    // Fungsi highlight keyword
    function highlightKeyword(keyword) {
        const productTitles = produkGrid.querySelectorAll('.product-card h2');
        productTitles.forEach(title => {
            const text = title.innerText;
            if (text.toLowerCase().includes(keyword)) {
                const regex = new RegExp(`(${keyword})`, 'gi');
                title.innerHTML = text.replace(regex, '<span class="search-highlight">$1</span>');
            } else {
                title.innerHTML = text;
            }
        });
    }

    // Search dengan debounce (real-time)
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);

            const keyword = e.target.value;

            // Tampilkan skeleton loading
            if (keyword.trim() !== '') {
                produkGrid.classList.add('hidden');
                loadingSkeleton.classList.remove('hidden');
            }

            searchTimeout = setTimeout(() => {
                filterProducts(keyword);
                produkGrid.classList.remove('hidden');
                loadingSkeleton.classList.add('hidden');
            }, 300);
        });
    }
});
</script>

</body>
</html>

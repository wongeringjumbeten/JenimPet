<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Produk - {{ $produk->nama_produk }}</title>
    @vite('resources/css/app.css')
    <style>
        /* Animasi custom */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .btn-scale {
            transition: all 0.2s ease;
        }
        .btn-scale:active {
            transform: scale(0.95);
        }
        .disabled-btn {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="max-w-6xl mx-auto px-6 py-10 animate-fade-slide-up">
    {{-- Tombol Kembali --}}
    <a href="{{ route('katalog.pelanggan') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/50 backdrop-blur-sm rounded-full text-[#6B5847] hover:bg-white/70 hover:scale-105 transition-all duration-300 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden transition-all duration-500 hover:shadow-2xl">
        <div class="flex flex-col md:flex-row">

            {{-- FOTO PRODUK (dengan efek zoom hover) --}}
            <div class="md:w-1/2 p-6 md:p-8 bg-[#F5E6D3]/30 flex items-center justify-center group overflow-hidden">
                <img src="{{ asset('storage/'.$produk->foto_produk) }}"
                     alt="{{ $produk->nama_produk }}"
                     class="max-w-full max-h-[400px] rounded-2xl shadow-lg object-contain transition-transform duration-500 group-hover:scale-105">
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="md:w-1/2 p-6 md:p-8">
                <h1 class="text-3xl md:text-4xl font-bold text-[#2C1810]">{{ $produk->nama_produk }}</h1>
                <p class="text-[#6B5847] mt-4 leading-relaxed">{{ $produk->deskripsi }}</p>

                <div class="mt-6 pt-4 border-t border-[#E8D5C4]">
                    <div class="flex justify-between items-center">
                        <span class="text-[#6B5847]">Harga</span>
                        <span class="text-2xl font-bold text-[#D4A574]">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-[#6B5847]">Stok Tersedia</span>
                        <span class="font-semibold text-[#2C1810] {{ $produk->stok <= 0 ? 'text-red-500' : '' }}">
                            {{ $produk->stok }} ekor
                        </span>
                    </div>
                </div>

                {{-- INPUT JUMLAH --}}
                <div class="mt-6">
                    <label class="block text-[#6B5847] mb-2">Jumlah</label>
                    <div class="flex items-center gap-4">
                        <button id="btnMinus"
                                class="qty-btn w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition-all duration-200 flex items-center justify-center text-xl font-bold active:scale-95"
                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                            -
                        </button>
                        <input type="number" id="quantity" value="{{ $produk->stok > 0 ? 1 : 0 }}"
                               min="0" max="{{ $produk->stok }}"
                               class="w-20 text-center border rounded-xl py-2 focus:outline-none focus:ring-2 focus:ring-[#D4A574]"
                               {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                        <button id="btnPlus"
                                class="qty-btn w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 transition-all duration-200 flex items-center justify-center text-xl font-bold active:scale-95"
                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                            +
                        </button>
                    </div>
                </div>

                {{-- TOTAL HARGA --}}
                <div class="mt-6 pt-4 border-t border-[#E8D5C4]">
                    <div class="flex justify-between items-center">
                        <span class="text-[#6B5847] font-medium">Total Harga</span>
                        <span id="totalHarga" class="text-2xl font-bold text-[#D4A574]">
                            Rp {{ number_format($produk->stok > 0 ? $produk->harga : 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- TOMBOL TAMBAH KE KERANJANG --}}
                <form action="{{ route('keranjang.tambah') }}" method="POST" id="formTambahKeranjang" class="mt-8">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id_produk }}">
                    <input type="hidden" name="kuantitas" id="hiddenQuantity" value="{{ $produk->stok > 0 ? 1 : 0 }}">
                    <button type="submit" id="btnAddToCart"
                            class="w-full py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl transition-all duration-300 font-semibold flex items-center justify-center gap-2
                            {{ ($produk->stok <= 0) ? 'disabled-btn opacity-50 cursor-not-allowed' : 'hover:scale-105 hover:shadow-lg active:scale-95' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11l-1.5-6"></path>
                        </svg>
                        Tambahkan ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const harga = {{ $produk->harga }};
        const stok = {{ $produk->stok }};
        const qtyInput = document.getElementById('quantity');
        const btnMinus = document.getElementById('btnMinus');
        const btnPlus = document.getElementById('btnPlus');
        const totalSpan = document.getElementById('totalHarga');
        const hiddenQty = document.getElementById('hiddenQuantity');
        const btnAddToCart = document.getElementById('btnAddToCart');
        const form = document.getElementById('formTambahKeranjang');

        // Fungsi update tampilan total + disabled state
        function updateUI() {
            let qty = parseInt(qtyInput.value);
            if (isNaN(qty)) qty = 1;
            // Batasi antara 0 dan stok
            if (qty < 0) qty = 0;
            if (qty > stok) qty = stok;
            qtyInput.value = qty;
            hiddenQty.value = qty;

            // Hitung total
            const total = harga * qty;
            totalSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');

            // Jika stok habis atau jumlah = 0, disable tombol dan beri efek
            if (stok <= 0 || qty === 0) {
                btnAddToCart.disabled = true;
                btnAddToCart.classList.add('disabled-btn', 'opacity-50', 'cursor-not-allowed');
                btnAddToCart.classList.remove('hover:scale-105', 'hover:shadow-lg');
            } else {
                btnAddToCart.disabled = false;
                btnAddToCart.classList.remove('disabled-btn', 'opacity-50', 'cursor-not-allowed');
                btnAddToCart.classList.add('hover:scale-105', 'hover:shadow-lg');
            }
        }

        // Event tombol minus
        if (btnMinus) {
            btnMinus.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                if (!isNaN(val) && val > 0) {
                    qtyInput.value = val - 1;
                    updateUI();
                }
            });
        }

        // Event tombol plus
        if (btnPlus) {
            btnPlus.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                if (!isNaN(val) && val < stok) {
                    qtyInput.value = val + 1;
                    updateUI();
                }
            });
        }

        // Event manual input
        if (qtyInput) {
            qtyInput.addEventListener('input', function() {
                let val = parseInt(this.value);
                if (isNaN(val)) val = 0;
                if (val > stok) val = stok;
                if (val < 0) val = 0;
                this.value = val;
                updateUI();
            });
        }

        // Cegah submit jika stok habis atau jumlah 0
        if (form) {
            form.addEventListener('submit', function(e) {
                const qty = parseInt(hiddenQty.value);
                if (stok <= 0 || qty === 0) {
                    e.preventDefault();
                    alert('Stok tidak mencukupi atau jumlah tidak valid.');
                }
            });
        }

        // Initial update
        updateUI();
    });
</script>

</body>
</html>

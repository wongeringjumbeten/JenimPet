<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja - JenimPet</title>
    @vite('resources/css/app.css')
    <style>
        /* Animasi fade-in & slide-up */
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
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-pulse-slow {
            animation: pulse 0.3s ease-in-out;
        }
        .item-enter {
            animation: fadeSlideUp 0.3s ease-out;
        }
        /* Tombol disabled */
        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        /* Custom scroll */
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
    <h1 class="text-4xl font-bold text-[#2C1810] mb-2">Keranjang</h1>
    <p class="text-[#6B5847] mb-8">Tinjau pesanan Anda sebelum checkout</p>

    @if($keranjang->isEmpty())
        {{-- KERANJANG KOSONG --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-12 text-center border border-[#E8D5C4] animate-fade-slide-up">
            <div class="text-8xl mb-4 animate-bounce">🛒</div>
            <p class="text-xl font-semibold text-[#2C1810]">Keranjang Kosong</p>
            <p class="text-[#6B5847] mt-2">Belum ada produk di keranjang Anda</p>
            <a href="{{ route('katalog.pelanggan') }}"
               class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl hover:scale-105 transition-all duration-300 shadow-md hover:shadow-xl">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- DAFTAR PRODUK --}}
            <div class="flex-1 bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white">
                            <tr>
                                <th class="p-4 text-center w-12">
                                    <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-white cursor-pointer">
                                </th>
                                <th class="p-4 text-left">Produk</th>
                                <th class="p-4 text-center">Harga</th>
                                <th class="p-4 text-center">Jumlah</th>
                                <th class="p-4 text-center">Subtotal</th>
                                <th class="p-4 text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keranjang as $index => $item)
                            <tr class="border-b border-[#E8D5C4] hover:bg-[#F5E6D3]/30 transition-all duration-200 item-row" data-id="{{ $item->id_keranjang }}" data-harga="{{ $item->produk->harga }}" style="animation: fadeSlideUp 0.3s ease-out {{ $index * 0.05 }}s both;">
                                <td class="p-4 text-center">
                                    <input type="checkbox" class="item-checkbox w-4 h-4 rounded border-gray-300 cursor-pointer" data-id="{{ $item->id_keranjang }}" {{ $item->is_selected === '1' ? 'checked' : '' }}>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-white shadow-md group">
                                            <img src="{{ asset('storage/'.$item->produk->foto_produk) }}"
                                                 alt="{{ $item->produk->nama_produk }}"
                                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</h3>
                                            <p class="text-xs text-[#6B5847]">Stok: {{ $item->produk->stok }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center font-medium text-[#2C1810]">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="qty-minus w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 transition-all duration-200 flex items-center justify-center font-bold text-lg active:scale-95">-</button>
                                        <input type="number" value="{{ $item->kuantitas }}" min="1" max="{{ $item->produk->stok }}"
                                               class="qty-input w-16 text-center border rounded-xl py-1 focus:outline-none focus:ring-2 focus:ring-[#D4A574]">
                                        <button class="qty-plus w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 transition-all duration-200 flex items-center justify-center font-bold text-lg active:scale-95">+</button>
                                    </div>
                                </td>
                                <td class="p-4 text-center font-bold text-[#D4A574] subtotal">
                                    Rp {{ number_format($item->produk->harga * $item->kuantitas, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <button class="hapus-item text-red-500 hover:text-red-700 transition-all duration-200 hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- AKSI BAWAH --}}
                <div class="p-4 border-t border-[#E8D5C4] flex justify-between items-center bg-white/30">
                    <div class="flex gap-6">
                        <button id="pilihSemua" class="text-sm text-[#D4A574] hover:text-[#B8965A] transition-all duration-200 flex items-center gap-1 group">
                            <svg class="w-4 h-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pilih Semua ({{ $keranjang->count() }})
                        </button>
                        <button id="hapusTerpilih" class="text-sm text-red-500 hover:text-red-700 transition-all duration-200 flex items-center gap-1 group">
                            <svg class="w-4 h-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN BELANJA --}}
            <div class="lg:w-96 bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 h-fit transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Ringkasan Belanja
                </h2>
                <div class="flex justify-between text-[#6B5847] mb-4">
                    <span>Total ( <span id="totalItemCount" class="font-semibold text-[#2C1810]">0</span> produk ) :</span>
                    <span id="totalHargaDisplay" class="font-bold text-[#D4A574] text-xl">Rp0</span>
                </div>
                <form action="{{ route('checkout.form') }}" method="GET" id="checkoutForm">
                @csrf
                <input type="hidden" name="selected_items" id="selectedItemsInput">
                <button type="submit" id="btnCheckout" class="w-full mt-4 py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl hover:scale-105 transition disabled:opacity-50" disabled>
                    Checkout
                </button>
            </form>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const qtyInputs = document.querySelectorAll('.qty-input');
    const qtyMinus = document.querySelectorAll('.qty-minus');
    const qtyPlus = document.querySelectorAll('.qty-plus');
    const hapusBtns = document.querySelectorAll('.hapus-item');
    const selectAllBtn = document.getElementById('pilihSemua');
    const hapusTerpilihBtn = document.getElementById('hapusTerpilih');
    const btnCheckout = document.getElementById('btnCheckout');
    const totalItemCountSpan = document.getElementById('totalItemCount');
    const totalHargaDisplaySpan = document.getElementById('totalHargaDisplay');
    const selectedItemsInput = document.getElementById('selectedItemsInput');

    function updateTotal() {
        let totalItems = 0;
        let totalHarga = 0;
        let selectedIds = [];

        checkboxes.forEach((cb, index) => {
            if (cb.checked) {
                const row = cb.closest('.item-row');
                const qtyInput = row.querySelector('.qty-input');
                const harga = parseInt(row.dataset.harga);
                const qty = parseInt(qtyInput.value);
                const subtotal = harga * qty;
                totalHarga += subtotal;
                totalItems += qty;
                selectedIds.push(cb.dataset.id);
            }
        });

        totalItemCountSpan.innerText = totalItems;
        totalHargaDisplaySpan.innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
        selectedItemsInput.value = JSON.stringify(selectedIds);
        btnCheckout.disabled = (selectedIds.length === 0);
    }

    function updateSubtotal(row) {
        const harga = parseInt(row.dataset.harga);
        const qty = parseInt(row.querySelector('.qty-input').value);
        const subtotal = harga * qty;
        row.querySelector('.subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        updateTotal();
    }

    // Checkbox event
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updateTotal();
            fetch(`/keranjang/toggle-select/${cb.dataset.id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ is_selected: cb.checked ? '1' : '0' })
            }).catch(err => console.error(err));
        });
    });

    // Quantity buttons
    qtyMinus.forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            const input = qtyInputs[idx];
            let val = parseInt(input.value);
            if (val > 1) {
                val--;
                input.value = val;
                const row = input.closest('.item-row');
                updateSubtotal(row);
                const id = row.dataset.id;
                fetch(`/keranjang/update/${id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ kuantitas: val })
                }).catch(err => console.error(err));
            }
        });
    });

    qtyPlus.forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            const input = qtyInputs[idx];
            let val = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            if (val < max) {
                val++;
                input.value = val;
                const row = input.closest('.item-row');
                updateSubtotal(row);
                const id = row.dataset.id;
                fetch(`/keranjang/update/${id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ kuantitas: val })
                }).catch(err => console.error(err));
            }
        });
    });

    qtyInputs.forEach(input => {
        input.addEventListener('change', function() {
            let val = parseInt(this.value);
            const min = parseInt(this.min);
            const max = parseInt(this.max);
            if (isNaN(val)) val = min;
            if (val < min) val = min;
            if (val > max) val = max;
            this.value = val;
            const row = this.closest('.item-row');
            updateSubtotal(row);
            const id = row.dataset.id;
            fetch(`/keranjang/update/${id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ kuantitas: val })
            }).catch(err => console.error(err));
        });
    });

    // Hapus item
hapusBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const row = btn.closest('.item-row');
        const id = row.dataset.id;
        if (confirm('Hapus item ini dari keranjang?')) {
            fetch(`/keranjang/hapus/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(() => {
                location.reload(); // Refresh halaman setelah hapus
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    });
});
    // Pilih semua
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', () => {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => { cb.checked = !allChecked; cb.dispatchEvent(new Event('change')); });
        });
    }

    // Hapus terpilih
    if (hapusTerpilihBtn) {
        hapusTerpilihBtn.addEventListener('click', () => {
            const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.dataset.id);
            if (selected.length === 0) return;
            if (confirm(`Hapus ${selected.length} item terpilih?`)) {
                Promise.all(selected.map(id =>
                    fetch(`/keranjang/hapus/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
                )).then(() => location.reload());
            }
        });
    }

    updateTotal();
});
</script>

</body>
</html>

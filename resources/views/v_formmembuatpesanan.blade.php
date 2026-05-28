<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - JenimPet</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(40px); }
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
        input:focus, select:focus, textarea:focus {
            outline: none;
            ring: 2px solid #D4A574;
            border-color: #D4A574;
        }
        .dropdown-option {
            transition: all 0.2s ease;
        }
        .dropdown-option:hover {
            background-color: #F5E6D3;
            transform: translateX(4px);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar_pelanggan')

<div class="max-w-7xl mx-auto px-6 py-10 animate-fade-slide-up">
    {{-- Tombol Kembali --}}
    <a href="{{ route('keranjang.index') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/50 backdrop-blur-sm rounded-full text-[#6B5847] hover:bg-white/70 hover:scale-105 transition-all duration-300 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Keranjang
    </a>

    <form id="checkoutForm" action="{{ route('checkout.proses') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(!empty($selectedItems))
            @foreach($selectedItems as $item)
                <input type="hidden" name="selected_items[]" value="{{ $item }}">
            @endforeach
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- FORM KIRI --}}
            <div class="flex-1 space-y-6">
                {{-- Alamat Pengiriman (READ ONLY) --}}
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h2>
                    <div class="p-3 rounded-xl bg-[#F5E6D3]/50 text-[#2C1810]">
                        {{ auth()->user()->full_alamat ?? auth()->user()->alamat ?? 'Alamat belum diisi' }}
                    </div>
                    <input type="hidden" name="alamat" value="{{ auth()->user()->full_alamat ?? auth()->user()->alamat ?? '' }}">
                    <p class="text-xs text-[#6B5847] mt-2">
                        <a href="{{ route('profile') }}" class="text-[#D4A574] hover:underline">Ubah alamat</a> di halaman profil
                    </p>
                </div>

                {{-- Ongkir (Otomatis) --}}
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Pengiriman
                    </h2>
                    <div class="flex justify-between items-center p-3 rounded-xl bg-[#F5E6D3]/30">
                        <span class="text-[#6B5847]">Biaya Pengiriman</span>
                        <span id="ongkirDisplay" class="font-bold text-[#D4A574]">Menghitung...</span>
                    </div>
                    <input type="hidden" name="ongkir" id="ongkirInput" value="0">
                    <input type="hidden" name="kurir" id="kurirInput" value="tiki">
                    <p class="text-xs text-[#6B5847] mt-2">* Biaya pengiriman dihitung otomatis berdasarkan alamat tujuan</p>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 relative z-10">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Metode Pembayaran
                    </h2>
                    <div class="relative">
                        <div id="selectedPaymentDisplay"
                            class="w-full p-3 rounded-xl border border-[#D4A574]/50 bg-white/80 flex items-center justify-between cursor-pointer hover:border-[#D4A574] transition">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#6B5847]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span id="selectedPaymentText" class="text-[#2C1810]">Pilih metode pembayaran</span>
                            </div>
                            <svg class="w-4 h-4 text-[#6B5847] transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div id="paymentDropdown"
                            class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-[#E8D5C4] overflow-hidden z-[999] animate-scale-pop max-h-80 overflow-y-auto">
                            <div class="p-2 space-y-1">
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="dana" data-name="Dana" data-number="1234567890" data-icon="DanaIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/DanaIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">Dana</p><p class="text-xs text-[#6B5847]">No. Rek: 1234567890</p></div>
                                    </div>
                                </div>
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="gopay" data-name="GoPay" data-number="5555566677" data-icon="GopayIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/GopayIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">GoPay</p><p class="text-xs text-[#6B5847]">No. Rek: 5555566677</p></div>
                                    </div>
                                </div>
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="shopeepay" data-name="ShopeePay" data-number="0987654321" data-icon="ShopeepayIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/ShopeepayIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">ShopeePay</p><p class="text-xs text-[#6B5847]">No. Rek: 0987654321</p></div>
                                    </div>
                                </div>
                                <div class="border-t border-[#E8D5C4] my-2"></div>
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="bri" data-name="Bank BRI" data-number="5555666677" data-icon="BRIIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/BRIIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">Bank BRI</p><p class="text-xs text-[#6B5847]">No. Rek: 5555666677</p></div>
                                    </div>
                                </div>
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="mandiri" data-name="Bank Mandiri" data-number="5555666677" data-icon="MandiriIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/MandiriIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">Bank Mandiri</p><p class="text-xs text-[#6B5847]">No. Rek: 5555666677</p></div>
                                    </div>
                                </div>
                                <div class="payment-option px-3 py-2 rounded-lg cursor-pointer dropdown-option" data-value="bca" data-name="Bank BCA" data-number="8888899990" data-icon="BCAIcon.png">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('icons/BCAIcon.png') }}" class="w-8 h-8 object-contain">
                                        <div class="flex-1"><p class="font-semibold text-[#2C1810]">Bank BCA</p><p class="text-xs text-[#6B5847]">No. Rek: 8888899990</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="metode_pembayaran" id="metodePembayaran" required>
                    <div id="selectedPaymentInfo" class="mt-3 p-3 bg-green-50 rounded-xl hidden">
                        <div class="flex items-center gap-2 text-green-700">
                            <span class="text-sm font-medium">✓ Metode pembayaran dipilih</span>
                        </div>
                    </div>
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Bukti Pembayaran <span class="text-red-500 text-sm">*Wajib</span>
                    </h2>
                    <div class="space-y-4">
                        <input type="file" id="buktiPembayaran" name="bukti_pembayaran" class="hidden" accept="image/*" required>
                        <div id="uploadBox"
                            class="w-full h-40 border-2 border-dashed border-[#D4A574]/50 rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:bg-[#D4A574]/10 transition">
                            <div id="uploadText" class="text-center">
                                <svg class="w-10 h-10 mx-auto text-[#D4A574] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="font-medium">Klik untuk pilih foto bukti transfer</p>
                                <p class="text-sm opacity-70">JPG / PNG max 2MB</p>
                            </div>
                            <img id="previewImage" class="hidden w-full h-full object-cover absolute inset-0">
                        </div>
                        <button type="button" id="removeImage" class="hidden text-sm text-red-500 hover:text-red-700">Hapus Foto</button>
                        <p class="text-xs text-green-600" id="uploadStatus"></p>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Catatan Pesanan <span class="text-gray-400 text-sm">(Opsional)</span>
                    </h2>
                    <textarea name="catatan" id="catatan" rows="3"
                        class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] transition"
                        placeholder="Tambahkan catatan untuk penjual"></textarea>
                </div>
            </div>

            {{-- FORM KANAN: Ringkasan --}}
            <div class="lg:w-96 space-y-6">
                <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-[#2C1810] mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3 p-3 bg-[#F5E6D3]/30 rounded-xl">
                            <img src="{{ asset('storage/'.$item->produk->foto_produk) }}" class="w-16 h-16 object-cover rounded-lg bg-white">
                            <div class="flex-1">
                                <h3 class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</h3>
                                <p class="text-xs text-[#6B5847]">Harga: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                                <p class="text-xs text-[#6B5847]">Jumlah: {{ $item->kuantitas }}</p>
                                <p class="text-sm font-bold text-[#D4A574]">Rp {{ number_format($item->produk->harga * $item->kuantitas, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-[#E8D5C4] mt-4 pt-4 space-y-2">
                        <div class="flex justify-between text-[#6B5847]">
                            <span>Subtotal ({{ count($cartItems) }} item)</span>
                            <span id="subtotalAmount">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[#6B5847]">
                            <span>Biaya Pengiriman</span>
                            <span id="ongkirDisplay">Menghitung...</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-[#2C1810] pt-2 border-t border-[#E8D5C4]">
                            <span>Total Pembayaran</span>
                            <span id="totalPembayaran" class="text-[#D4A574]">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" id="btnPesan"
                            class="w-full mt-6 py-3 bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl font-semibold transition hover:scale-105">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==================== PAYMENT DROPDOWN ====================
    const selectedDisplay = document.getElementById('selectedPaymentDisplay');
    const paymentDropdown = document.getElementById('paymentDropdown');
    const paymentOptions = document.querySelectorAll('.payment-option');
    const selectedPaymentText = document.getElementById('selectedPaymentText');
    const metodePembayaranInput = document.getElementById('metodePembayaran');
    const selectedPaymentInfo = document.getElementById('selectedPaymentInfo');

    let dropdownOpen = false;

    selectedDisplay.addEventListener('click', () => {
        dropdownOpen = !dropdownOpen;
        if (dropdownOpen) {
            paymentDropdown.classList.remove('hidden');
            selectedDisplay.querySelector('svg:last-child').style.transform = 'rotate(180deg)';
        } else {
            paymentDropdown.classList.add('hidden');
            selectedDisplay.querySelector('svg:last-child').style.transform = 'rotate(0deg)';
        }
    });

    paymentOptions.forEach(option => {
        option.addEventListener('click', () => {
            const value = option.dataset.value;
            const name = option.dataset.name;
            const number = option.dataset.number;
            const icon = option.dataset.icon;
            selectedPaymentText.innerHTML = `<div class="flex items-center gap-3"><img src="{{ asset('icons/${icon}') }}" class="w-6 h-6 object-contain"><span>${name} - ${number}</span></div>`;
            metodePembayaranInput.value = value;
            selectedPaymentInfo.classList.remove('hidden');
            paymentDropdown.classList.add('hidden');
            dropdownOpen = false;
            selectedDisplay.querySelector('svg:last-child').style.transform = 'rotate(0deg)';
        });
    });

    document.addEventListener('click', (e) => {
        if (!selectedDisplay.contains(e.target) && !paymentDropdown.contains(e.target)) {
            paymentDropdown.classList.add('hidden');
            dropdownOpen = false;
        }
    });

    // ==================== UPLOAD BUKTI ====================
    const input = document.getElementById('buktiPembayaran');
    const box = document.getElementById('uploadBox');
    const preview = document.getElementById('previewImage');
    const text = document.getElementById('uploadText');
    const removeBtn = document.getElementById('removeImage');
    const uploadStatus = document.getElementById('uploadStatus');

    box.addEventListener('click', () => input.click());
    input.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        if (!file.type.match('image.*')) { alert('File harus berupa gambar'); this.value = ''; return; }
        if (file.size > 2 * 1024 * 1024) { alert('Ukuran file maksimal 2MB'); this.value = ''; return; }
        const reader = new FileReader();
        reader.onload = function(e) { preview.src = e.target.result; preview.classList.remove('hidden'); text.classList.add('hidden'); removeBtn.classList.remove('hidden'); uploadStatus.innerText = '✓ Bukti pembayaran terupload'; };
        reader.readAsDataURL(file);
    });
    removeBtn.addEventListener('click', () => { input.value = ''; preview.classList.add('hidden'); text.classList.remove('hidden'); removeBtn.classList.add('hidden'); uploadStatus.innerText = ''; });

    // ==================== RAJAONGKIR (OTOMATIS) ====================
const ongkirDisplay = document.getElementById('ongkirDisplay');
const ongkirInput = document.getElementById('ongkirInput');
const totalPembayaranSpan = document.getElementById('totalPembayaran');
const subtotalAmount = {{ $totalHarga }};
let originId = 30943; // GANTI DENGAN ID TOKO KAMU
let destinationId = null;

// Ambil alamat lengkap dari user
const alamatLengkap = "{{ auth()->user()->full_alamat ?? auth()->user()->alamat ?? '' }}";
console.log('Alamat lengkap:', alamatLengkap);

// Ekstrak kata kunci yang lebih baik (ambil kota/kabupaten)
// Contoh alamat: "Jl. Kironggo No. 15, Cilengkrang, Kabupaten Bandung, Jawa Barat"
// Kita ambil "Bandung" atau "Kabupaten Bandung"
let searchKeyword = '';

// Coba ambil setelah koma ke-2 atau ke-3
const parts = alamatLengkap.split(',');
if (parts.length >= 3) {
    // Ambil bagian kota/kabupaten (biasanya setelah kelurahan/kecamatan)
    searchKeyword = parts[2].trim();
} else if (parts.length >= 2) {
    searchKeyword = parts[1].trim();
} else {
    searchKeyword = alamatLengkap.trim();
}

console.log('Keyword pencarian:', searchKeyword);

function getDestinationAndCalculate() {
    if (searchKeyword.length < 3) {
        ongkirDisplay.innerText = 'Alamat tidak lengkap';
        return;
    }

    fetch(`/api/ongkir/search-destination?q=${encodeURIComponent(searchKeyword)}`)
        .then(res => res.json())
        .then(data => {
            console.log('Hasil pencarian:', data);
            if (data.length > 0) {
                // Ambil ID yang paling relevan (coba cari yang persis atau pertama)
                destinationId = data[0].id;
                console.log('Destination ID dipilih:', destinationId);
                calculateOngkir();
            } else {
                ongkirDisplay.innerText = 'Tidak dapat menentukan lokasi tujuan';
            }
        })
        .catch(err => {
            console.error('Error search:', err);
            ongkirDisplay.innerText = 'Gagal mencari lokasi';
        });
}

function calculateOngkir() {
    if (!destinationId || !originId) return;

    console.log('Menghitung ongkir dari', originId, 'ke', destinationId);

    fetch('/api/ongkir/calculate-cost', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            origin: originId,
            destination: destinationId,
            weight: 1000,
            courier: 'tiki'
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Hasil ongkir:', data);
        if (data && data.length > 0) {
            const ongkir = data[0].cost;
            const serviceName = data[0].service;
            ongkirInput.value = ongkir;
            ongkirDisplay.innerText = 'Rp ' + ongkir.toLocaleString('id-ID') + ' (' + serviceName + ')';
            const total = subtotalAmount + ongkir;
            totalPembayaranSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
        } else {
            ongkirDisplay.innerText = 'Tidak ada layanan pengiriman';
        }
    })
    .catch(err => {
        console.error('Error ongkir:', err);
        ongkirDisplay.innerText = 'Gagal hitung ongkir';
    });
}

// Jalankan saat halaman load
if (searchKeyword && searchKeyword !== '') {
    getDestinationAndCalculate();
} else {
    ongkirDisplay.innerText = 'Alamat belum lengkap';
}

    // ==================== FORM SUBMIT ====================
    const form = document.getElementById('checkoutForm');
    const btnPesan = document.getElementById('btnPesan');
    const alamat = document.getElementById('alamat');
    form.addEventListener('submit', function(e) {
        const metode = metodePembayaranInput.value;
        const bukti = input.files[0];
        if (!metode) { e.preventDefault(); alert('Pilih metode pembayaran'); return; }
        if (!bukti) { e.preventDefault(); alert('Upload bukti pembayaran'); return; }
        btnPesan.disabled = true;
        btnPesan.innerHTML = 'Memproses...';
    });
});
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan - Admin Panel</title>
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
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-pop {
            animation: scalePop 0.3s ease-out forwards;
        }
        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
        .status-badge {
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
            filter: brightness(1.05);
        }
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }
        .modal-content {
            animation: scalePop 0.3s ease-out forwards;
        }
        .info-card {
            transition: all 0.2s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar')

<div class="max-w-5xl mx-auto px-6 py-10 animate-fade-slide-up">
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.pesanan') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/50 backdrop-blur-sm rounded-full text-[#6B5847] hover:bg-white/70 hover:scale-105 transition-all duration-300 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Pesanan
    </a>

    {{-- Header Pesanan --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden animate-scale-pop">
        <div class="p-6 bg-gradient-to-r from-[#D4A574]/10 to-transparent border-b border-[#E8D5C4]">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <p class="text-xs text-[#6B5847]">ID PESANAN</p>
                    <p class="font-mono font-bold text-2xl text-[#2C1810]">#{{ $pesanan->id_pesanan }}</p>
                </div>
                <div>
                    <p class="text-xs text-[#6B5847]">TANGGAL PESANAN</p>
                    <p class="font-medium text-[#2C1810]">{{ $pesanan->created_at->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-[#6B5847]">{{ $pesanan->created_at->translatedFormat('H:i') }}</p>
                </div>
                <div>
                    <span class="status-badge inline-block px-4 py-2 rounded-full text-white text-sm font-semibold {{ $pesanan->status_label['color'] }}">
                        {{ $pesanan->status_label['label'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info Pelanggan & Pengiriman --}}
        <div class="p-6 border-b border-[#E8D5C4] bg-[#F5E6D3]/10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="info-card bg-white/50 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-[#2C1810]">Data Pelanggan</h3>
                    </div>
                    <p class="text-sm text-[#2C1810] font-medium">{{ $pesanan->user->nama_lengkap ?? 'Tidak tersedia' }}</p>
                    <p class="text-xs text-[#6B5847]">{{ $pesanan->user->email ?? 'Tidak tersedia' }}</p>
                    <p class="text-xs text-[#6B5847] mt-1">No. Telp: {{ $pesanan->user->no_telp ?? '-' }}</p>
                </div>

                <div class="info-card bg-white/50 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-[#2C1810]">Lokasi Pengiriman</h3>
                    </div>
                    <p class="text-sm text-[#2C1810]">{{ $pesanan->user->nama_lengkap ?? 'Pelanggan' }}</p>
                    <p class="text-sm text-[#6B5847]">{{ $pesanan->alamat ?? 'Alamat tidak tersedia' }}</p>
                    @if($pesanan->nomor_resi)
                    <div class="mt-2 pt-2 border-t border-[#E8D5C4]">
                        <p class="text-xs text-[#6B5847]">Nomor Resi</p>
                        <p class="text-sm font-mono text-[#2C1810]">{{ $pesanan->nomor_resi }}</p>
                    </div>
                    @endif
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
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 p-3 bg-[#F5E6D3]/30 rounded-xl">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/'.$item->produk->foto_produk) }}"
                             alt="{{ $item->produk->nama_produk }}"
                             class="w-12 h-12 object-cover rounded-lg bg-white shadow">
                        <div>
                            <p class="font-semibold text-[#2C1810]">{{ $item->produk->nama_produk }}</p>
                            <p class="text-xs text-[#6B5847]">Harga Satuan: Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#6B5847]">Jumlah: {{ $item->kuantitas_pembelian }}x</p>
                        </div>
                    </div>
                    <p class="font-bold text-[#D4A574]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Total & Metode Pembayaran --}}
        <div class="p-6 border-b border-[#E8D5C4] bg-[#F5E6D3]/20">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-[#6B5847]">Metode Pembayaran</p>
                    <p class="font-medium text-[#2C1810]">{{ $pesanan->metode_pembayaran_label }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-[#6B5847]">Total Harga</p>
                    <p class="text-2xl font-bold text-[#D4A574]">Rp {{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</p>
                </div>
            </div>
            @if($pesanan->catatan)
            <div class="mt-4 pt-3 border-t border-[#E8D5C4]">
                <p class="text-sm text-[#6B5847]">Catatan</p>
                <p class="text-sm text-[#2C1810] italic">"{{ $pesanan->catatan }}"</p>
            </div>
            @endif
        </div>

        {{-- Tombol Aksi: Bukti Bayar, Resi, Ubah Status --}}
<div class="p-6 flex flex-wrap justify-between items-center gap-4">
    <div>
        <h3 class="text-sm font-semibold text-[#2C1810] mb-2">Bukti Pembayaran</h3>
        <a href="{{ asset('storage/'.$pesanan->bukti_pembayaran) }}" target="_blank"
           class="inline-flex items-center gap-2 text-[#D4A574] hover:text-[#B8965A] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Lihat Bukti Pembayaran
        </a>
    </div>
    <div class="flex gap-3">
        {{-- TOMBOL UBAH STATUS --}}
        <button onclick="openStatusModal()"
                class="px-5 py-2 bg-[#D4A574] text-white rounded-xl hover:bg-[#B8965A] transition-all duration-200 flex items-center gap-2 shadow-md hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Ubah Status
        </button>
    </div>
</div>
    </div>
</div>

{{-- MODAL UPDATE STATUS (CLEAN VERSION) --}}
<div id="statusModal" class="fixed inset-0 z-[9999] hidden items-center justify-center modal-backdrop" onclick="closeStatusModal()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden modal-content" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Ubah Status Pesanan</h2>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 transition text-2xl">&times;</button>
            </div>
        </div>
        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST" class="p-6 space-y-3">
            @csrf
            @method('PATCH')

            <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all duration-200 {{ $pesanan->status_pesanan == 'pengecekan pembayaran' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:bg-gray-50' }}">
            <div class="flex items-center gap-3">
            <input type="radio" name="status" value="pengecekan pembayaran" class="w-4 h-4 text-yellow-500" {{ $pesanan->status_pesanan == 'pengecekan pembayaran' ? 'checked' : '' }}>
            <span class="text-gray-700">Validasi Pembayaran</span>  <!-- ← UBAH INI -->
            </div>
            <span class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-yellow-500">Validasi Pembayaran</span>  <!-- ← UBAH INI -->
            </label>

            <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all duration-200 {{ $pesanan->status_pesanan == 'diproses' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <input type="radio" name="status" value="diproses" class="w-4 h-4 text-blue-500" {{ $pesanan->status_pesanan == 'diproses' ? 'checked' : '' }}>
                    <span class="text-gray-700">Diproses</span>
                </div>
                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-blue-500">Diproses</span>
            </label>

            <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all duration-200 {{ $pesanan->status_pesanan == 'dikirim' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <input type="radio" name="status" value="dikirim" class="w-4 h-4 text-indigo-500" {{ $pesanan->status_pesanan == 'dikirim' ? 'checked' : '' }}>
                    <span class="text-gray-700">Dikirim</span>
                </div>
                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-indigo-500">Dikirim</span>
            </label>

            <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all duration-200 {{ $pesanan->status_pesanan == 'ditolak' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <input type="radio" name="status" value="ditolak" class="w-4 h-4 text-red-500" {{ $pesanan->status_pesanan == 'ditolak' ? 'checked' : '' }}>
                    <span class="text-gray-700">Ditolak</span>
                </div>
                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-red-500">Ditolak</span>
            </label>

            <label class="flex items-center justify-between p-3 rounded-xl border cursor-pointer transition-all duration-200 {{ $pesanan->status_pesanan == 'selesai' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <input type="radio" name="status" value="selesai" class="w-4 h-4 text-green-500" {{ $pesanan->status_pesanan == 'selesai' ? 'checked' : '' }}>
                    <span class="text-gray-700">Selesai</span>
                </div>
                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-green-500">Selesai</span>
            </label>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-xl text-gray-600 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-[#D4A574] text-white rounded-xl hover:bg-[#B8965A] transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TAMBAH/EDIT RESI --}}
<div id="resiModal" class="fixed inset-0 z-[9999] hidden items-center justify-center modal-backdrop" onclick="closeResiModal()">
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-md mx-4 overflow-hidden modal-content" onclick="event.stopPropagation()">
        <div class="p-6 border-b border-[#E8D5C4] bg-gradient-to-r from-[#D4A574]/10 to-transparent">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-[#2C1810]">{{ $pesanan->nomor_resi ? 'Edit' : 'Tambah' }} Nomor Resi</h2>
                <button onclick="closeResiModal()" class="text-gray-400 hover:text-gray-600 transition text-2xl">&times;</button>
            </div>
        </div>
        <form action="{{ route('admin.pesanan.updateResi', $pesanan->id_pesanan) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-[#6B5847] mb-2">Nomor Resi Pengiriman</label>
                <input type="text" name="nomor_resi" value="{{ old('nomor_resi', $pesanan->nomor_resi) }}"
                       class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none transition"
                       placeholder="Contoh: JNE1234567890" required>
                <p class="text-xs text-[#6B5847] mt-2">Masukkan nomor resi dari kurir (JNE, SiCepat, dll)</p>
            </div>
            <div class="flex gap-3 pt-3">
                <button type="button" onclick="closeResiModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-[#D4A574] text-white rounded-lg hover:bg-[#B8965A] transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusModal() {
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('statusModal').classList.add('flex');
    }
    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusModal').classList.remove('flex');
    }
    function openResiModal() {
        document.getElementById('resiModal').classList.remove('hidden');
        document.getElementById('resiModal').classList.add('flex');
    }
    function closeResiModal() {
        document.getElementById('resiModal').classList.add('hidden');
        document.getElementById('resiModal').classList.remove('flex');
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusModal();
            closeResiModal();
        }
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pelanggan - Admin Panel</title>
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
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        .status-badge {
            transition: all 0.2s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
            filter: brightness(1.05);
        }
        .info-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -10px rgba(0, 0, 0, 0.15);
        }
        .order-item {
            transition: all 0.3s ease;
        }
        .order-item:hover {
            transform: translateX(6px);
            background-color: rgba(212, 165, 116, 0.08);
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

@include('layouts.navbar')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.pelanggan') }}"
       class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white/50 backdrop-blur-sm rounded-full text-[#6B5847] hover:bg-white/70 hover:scale-105 transition-all duration-300 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Pelanggan
    </a>

    {{-- Header --}}
    <div class="mb-8 relative">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#D4A574]/20 rounded-full blur-2xl"></div>
        <h1 class="text-3xl md:text-5xl font-bold text-[#2C1810] mb-2 relative inline-block">
            Detail Pelanggan
            <div class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-[#D4A574] to-[#B8965A] rounded-full"></div>
        </h1>
        <p class="text-[#6B5847] mt-4">Informasi lengkap profil dan riwayat pesanan pelanggan</p>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden animate-scale-in">
        <div class="p-6 bg-gradient-to-r from-[#D4A574]/10 to-transparent border-b border-[#E8D5C4]">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#D4A574] to-[#B8965A] rounded-full blur opacity-0 group-hover:opacity-50 transition duration-500"></div>
                    <img src="{{ $pelanggan->avatar ?? 'https://i.pravatar.cc/120' }}"
                         class="relative w-24 h-24 md:w-28 md:h-28 rounded-full border-4 border-[#D4A574] shadow-lg object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#2C1810]">{{ $pelanggan->nama_lengkap }}</h2>
                    <p class="text-[#D4A574] mt-1 flex items-center gap-1 justify-center md:justify-start">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Member sejak {{ \Carbon\Carbon::parse($pelanggan->created_at)->translatedFormat('F Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Info Cards --}}
<div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    {{-- Email --}}
    <div class="info-card bg-white/50 rounded-xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('icons/EmailIcon.svg') }}" class="w-5 h-5" onerror="this.src='https://placehold.co/20x20'">
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-xs text-[#6B5847]">Email</p>
            <p class="text-sm font-medium text-[#2C1810] truncate">{{ $pelanggan->email }}</p>
        </div>
    </div>

    {{-- No HP --}}
    <div class="info-card bg-white/50 rounded-xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('icons/PhoneIcon.svg') }}" class="w-5 h-5" onerror="this.src='https://placehold.co/20x20'">
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-xs text-[#6B5847]">No. HP</p>
            <p class="text-sm font-medium text-[#2C1810]">{{ $pelanggan->no_telp ?? '-' }}</p>
        </div>
    </div>

    {{-- Alamat --}}
    <div class="info-card bg-white/50 rounded-xl p-4 flex items-start gap-3">
        <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
            <img src="{{ asset('icons/LocationIcon.svg') }}" class="w-5 h-5" onerror="this.src='https://placehold.co/20x20'">
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-xs text-[#6B5847]">Alamat Lengkap</p>
            <p class="text-sm font-medium text-[#2C1810] break-words">
                @if($pelanggan->full_alamat)
                    {{ $pelanggan->full_alamat }}
                @elseif($pelanggan->detail_alamat && $pelanggan->alamat)
                    {{ $pelanggan->detail_alamat }}, {{ $pelanggan->alamat }}
                @elseif($pelanggan->alamat)
                    {{ $pelanggan->alamat }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
</div>
        <div class="w-10 h-10 bg-[#D4A574]/20 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
        </div>
    </div>

    {{-- Riwayat Pesanan --}}
    <div class="mt-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-[#D4A574] rounded-full"></div>
            <h2 class="text-2xl md:text-3xl font-bold text-[#2C1810]">Riwayat Pesanan</h2>
            <span class="text-sm text-[#6B5847] bg-white/50 px-3 py-1 rounded-full">{{ $pesanan->count() }} pesanan</span>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden">
            @if($pesanan->isEmpty())
                <div class="p-12 text-center">
                    <div class="text-6xl mb-4 animate-float">📦</div>
                    <p class="text-lg font-medium text-[#6B5847]">Belum ada pesanan</p>
                    <p class="text-sm text-[#8B7355] mt-1">Pelanggan ini belum melakukan transaksi</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white">
                            <tr>
                                <th class="p-4 text-left">ID Pesanan</th>
                                <th class="p-4 text-left">Tanggal</th>
                                <th class="p-4 text-left">Produk</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $p)
                            <tr class="order-item border-b border-[#E8D5C4] hover:bg-[#F5E6D3]/30 transition-all duration-200">
                                <td class="p-4 font-mono font-semibold text-[#2C1810]">#{{ $p->id_pesanan }}</td>
                                <td class="p-4 text-sm text-[#6B5847]">{{ \Carbon\Carbon::parse($p->tanggal_pesanan)->translatedFormat('d F Y') }}</td>
                                <td class="p-4">
    <div class="flex flex-wrap gap-1">
        @if($p->detail->count() > 0)
            @foreach($p->detail->take(2) as $item)
                <span class="inline-block px-2 py-1 bg-[#F5E6D3] rounded-lg text-xs text-[#2C1810]">
                    {{ $item->produk->nama_produk ?? 'Produk' }}
                </span>
            @endforeach
            @if($p->detail->count() > 2)
                <span class="inline-block px-2 py-1 bg-gray-200 rounded-lg text-xs text-gray-500">
                    +{{ $p->detail->count() - 2 }}
                </span>
            @endif
        @else
            <span class="text-xs text-[#6B5847]">-</span>
        @endif
    </div>
</td>
                            <div class="flex flex-wrap gap-1">
                                <td class="p-4 text-center">
                                    <span class="status-badge inline-block px-3 py-1 rounded-full text-white text-xs font-semibold
                                        @if($p->status_pesanan == 'pengecekan pembayaran') bg-yellow-500
                                        @elseif($p->status_pesanan == 'diproses') bg-blue-500
                                        @elseif($p->status_pesanan == 'dikirim') bg-indigo-500
                                        @elseif($p->status_pesanan == 'ditolak') bg-red-500
                                        @elseif($p->status_pesanan == 'selesai') bg-green-500
                                        @else bg-gray-500
                                        @endif">
                                        @if($p->status_pesanan == 'pengecekan pembayaran')
                                            Validasi Pembayaran
                                        @else
                                            {{ ucfirst($p->status_pesanan) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="p-4 text-right font-bold text-[#D4A574]">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        @if(!$pesanan->isEmpty())
        <div class="mt-6 text-center">
            <p class="text-xs text-[#6B5847]">Menampilkan {{ $pesanan->count() }} pesanan</p>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan efek klik pada baris pesanan (opsional)
    document.querySelectorAll('.order-item').forEach(item => {
        item.addEventListener('click', function() {
            this.style.transition = 'all 0.1s ease';
            this.style.backgroundColor = '#D4A57420';
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 200);
        });
    });
});
</script>

</body>
</html>

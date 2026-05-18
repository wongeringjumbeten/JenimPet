<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pesanan - Admin Panel</title>
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
        .status-badge {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .status-badge:hover {
            transform: scale(1.05);
            filter: brightness(1.05);
        }
        .order-card {
            transition: all 0.3s ease;
        }
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#2C1810] mb-2">Manajemen Pesanan</h1>
        <p class="text-[#6B5847]">Kelola status dan nomor resi pesanan pelanggan</p>
    </div>

    {{-- Filter Status --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.pesanan') }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('status') ? 'bg-[#D4A574] text-white shadow-md' : 'bg-white/50 text-[#6B5847] hover:bg-white/70' }}">
            Semua
        </a>
        @foreach(['pengecekan_pembayaran', 'diproses', 'dikirim', 'ditolak', 'selesai'] as $status)
<a href="{{ route('admin.pesanan', ['status' => $status]) }}"
   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('status') == $status ? 'bg-[#D4A574] text-white shadow-md' : 'bg-white/50 text-[#6B5847] hover:bg-white/70' }}">
    @if($status == 'pengecekan_pembayaran')
        Validasi Pembayaran
    @else
        {{ ucfirst(str_replace('_', ' ', $status)) }}
    @endif
</a>
@endforeach
    </div>

    @if($pesanan->isEmpty())
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl p-12 text-center border border-[#E8D5C4]">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-lg font-medium text-[#6B5847]">Belum ada pesanan</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pesanan as $index => $p)
            <div class="order-card bg-white/80 backdrop-blur-sm rounded-2xl shadow border border-[#E8D5C4] overflow-hidden animate-scale-in" style="animation-delay: {{ $index * 0.03 }}s">
                {{-- Header --}}
                <div class="p-4 bg-gradient-to-r from-[#D4A574]/5 to-transparent border-b border-[#E8D5C4]">
                    <div class="flex flex-wrap justify-between items-center gap-3">
                        <div class="flex items-center gap-4">
                            <div>
                                <span class="text-xs text-[#6B5847]">ID Pesanan</span>
                                <p class="font-mono font-bold text-[#2C1810]">#{{ $p->id_pesanan }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-[#6B5847]">Pelanggan</span>
                                <p class="font-medium text-[#2C1810]">{{ $p->user->nama_lengkap ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-[#6B5847]">Tanggal</span>
                                <p class="text-sm text-[#2C1810]">{{ $p->created_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-[#D4A574]">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</span>
                            <span class="status-badge inline-block px-3 py-1 rounded-full text-white text-xs font-semibold {{ $p->status_label['color'] }}">
                                {{ $p->status_label['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Produk --}}
                <div class="p-4 border-b border-[#E8D5C4] bg-white/30">
                    <div class="flex flex-wrap gap-4">
                        @foreach($p->detail->take(2) as $item)
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white rounded-lg overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/'.$item->produk->foto_produk) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-medium text-sm text-[#2C1810]">{{ $item->produk->nama_produk }}</p>
                                <p class="text-xs text-[#6B5847]">{{ $item->kuantitas_pembelian }}x</p>
                            </div>
                        </div>
                        @endforeach
                        @if($p->detail->count() > 2)
                        <div class="flex items-center text-xs text-[#6B5847]">
                            +{{ $p->detail->count() - 2 }} produk lainnya
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Footer (Action Buttons) --}}
                <div class="px-4 py-3 flex justify-end gap-3">
                    <a href="{{ route('admin.pesanan.detail', $p->id_pesanan) }}"
                       class="px-4 py-2 text-sm bg-[#D4A574] text-white rounded-lg hover:bg-[#B8965A] transition">
                        Detail Pesanan
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 text-center">
            <p class="text-xs text-[#6B5847]">Menampilkan {{ $pesanan->count() }} pesanan</p>
        </div>
    @endif
</div>

</body>
</html>

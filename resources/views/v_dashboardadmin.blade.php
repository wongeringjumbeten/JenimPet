<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar')

<section class="px-6 md:px-16 py-10">

    {{-- HERO --}}
    <div class="mb-10 animate-fade-up">
        <h1 class="text-4xl font-bold text-[#2C1810] mb-3">
            Halo, Admin!
        </h1>

        <p class="text-[#6B5847] max-w-xl">
            Selamat datang di dashboard admin. Anda dapat memantau aktivitas penjualan,
            mengelola katalog produk, serta melihat riwayat transaksi pelanggan secara real-time.
        </p>
    </div>

    {{-- LAPORAN OMSET --}}
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow mb-10">
        <h2 class="text-xl font-semibold text-[#2C1810] mb-6">
            Laporan Omset
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            @foreach([
                ['label'=>'Hari Ini','value'=>'Rp 1.2M'],
                ['label'=>'Minggu Ini','value'=>'Rp 5.8M'],
                ['label'=>'Bulan Ini','value'=>'Rp 18.4M'],
                ['label'=>'Total','value'=>'Rp 125M'],
            ] as $item)

            <div class="bg-[#F5E6D3] p-4 rounded-xl
                hover:scale-105 hover:shadow-lg transition">

                <p class="text-sm text-[#6B5847]">
                    {{ $item['label'] }}
                </p>

                <h3 class="text-lg font-bold text-[#2C1810]">
                    {{ $item['value'] }}
                </h3>

            </div>

            @endforeach

        </div>
    </div>

    {{-- KATALOG --}}
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow mb-10">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-[#2C1810]">
                Katalog Anda
            </h2>

            <a href="{{ route('admin.katalog') }}"
               class="text-[#D4A574] hover:underline text-sm">
               Lihat selengkapnya →
            </a>
        </div>

        @if($produk->isEmpty())

            <div class="text-center py-10 text-[#6B5847]">
                Belum terdapat data katalog produk. Silakan tambahkan produk
                untuk mulai mengelola penjualan Anda.
            </div>

        @else

        <div class="grid md:grid-cols-2 gap-4">

            @foreach($produk as $p)
            <div class="p-4 rounded-xl bg-[#F5E6D3]
                hover:shadow-lg hover:scale-[1.02] transition">

                <div class="flex justify-between items-center">

                    <div>
                        <h3 class="font-semibold text-[#2C1810]">
                            {{ $p->nama_produk }}
                        </h3>

                        <p class="text-sm text-[#6B5847]">
                            Stok: {{ $p->stok }}
                        </p>
                    </div>

                    <span class="text-[#D4A574] font-semibold">
                        Rp {{ number_format($p->harga,0,',','.') }}
                    </span>

                </div>

            </div>
            @endforeach

        </div>

        @endif
    </div>

    {{-- PESANAN --}}
    <div class="bg-white/70 backdrop-blur-xl p-6 rounded-3xl shadow">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-[#2C1810]">
                Pesanan
            </h2>

            <a href="#" class="text-[#D4A574] hover:underline text-sm">
                Lihat selengkapnya →
            </a>
        </div>

        @if($pesanan->isEmpty())

            <div class="text-center py-10 text-[#6B5847]">
                Belum terdapat transaksi yang tercatat. Aktivitas pesanan pelanggan akan ditampilkan di sini.
            </div>

        @else

        <div class="space-y-4">

            @foreach($pesanan as $ps)
            <div class="p-4 bg-[#F5E6D3] rounded-xl
                flex justify-between items-center
                hover:shadow-lg transition">

                <div>
                    <h3 class="font-semibold text-[#2C1810]">
                        {{ $ps->nama_pelanggan ?? 'Pelanggan' }}
                    </h3>

                    <p class="text-sm text-[#6B5847]">
                        {{ $ps->kode_pesanan ?? 'ORD-XXXX' }}
                    </p>
                </div>

                <span class="text-[#D4A574] font-semibold">
                    Rp {{ number_format($ps->total ?? 0,0,',','.') }}
                </span>

            </div>
            @endforeach

        </div>

        @endif
    </div>

</section>

</body>
</html>

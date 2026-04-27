<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan</title>
    @vite('resources/css/app.css')
</head>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('menuBtn');
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('overlay');

    let open = false;

    function openMenu() {
        menu.classList.remove('translate-x-full');
        overlay.classList.remove('opacity-0','pointer-events-none');
        open = true;

        const spans = btn.querySelectorAll('span');
        spans[0].classList.add('rotate-45', 'translate-y-[6px]');
        spans[1].classList.add('opacity-0');
        spans[2].classList.add('-rotate-45', '-translate-y-[6px]');
    }

    function closeMenu() {
        menu.classList.add('translate-x-full');
        overlay.classList.add('opacity-0','pointer-events-none');
        open = false;

        const spans = btn.querySelectorAll('span');
        spans.forEach(s => s.classList.remove(
            'rotate-45','translate-y-[6px]',
            'opacity-0',
            '-rotate-45','-translate-y-[6px]'
        ));
    }

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        open ? closeMenu() : openMenu();
    });

    document.addEventListener('click', (e) => {
        if (open && !menu.contains(e.target) && !btn.contains(e.target)) {
            closeMenu();
        }
    });

});

<script>
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.order-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.add('bg-[#D4A574]/20');
            setTimeout(() => {
                item.classList.remove('bg-[#D4A574]/20');
            }, 300);
        });
    });

});
</script>
</script>

<body class="bg-[#FAF7F2] min-h-screen relative overflow-x-hidden">

{{-- BACKGROUND GLOW --}}
<div class="absolute -top-32 -left-32 w-96 h-96 bg-[#D4A574]/30 rounded-full blur-[120px]"></div>
<div class="absolute bottom-0 right-0 w-96 h-96 bg-[#B8965A]/30 rounded-full blur-[120px]"></div>

{{-- NAVBAR --}}
<nav class="flex justify-between items-center px-6 py-4
bg-white/60 backdrop-blur-xl shadow-md sticky top-0 z-[60]">

    {{-- LEFT --}}
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-[#D4A574] to-[#B8965A]
            rounded-full flex items-center justify-center text-white font-bold">
            A
        </div>
        <h1 class="font-semibold text-[#2C1810]">Admin Panel</h1>
    </div>

    {{-- MENU DESKTOP --}}
    <div class="hidden md:flex gap-8 text-[#6B5847] font-medium">
        <a href="#">Katalog</a>
        <a href="#">Pesanan</a>
        <a href="#">Laporan</a>
        <a href="{{ route('admin.pelanggan') }}" class="text-[#D4A574] font-semibold">Pelanggan</a>
        <a href="#">Review</a>
        <a href="{{ route('admin.dashboard') }}">Profil</a>
    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-4">

        <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/100' }}"
             class="w-9 h-9 rounded-full border-2 border-[#D4A574]">

        <button id="menuBtn" class="md:hidden flex flex-col gap-1.5 group">
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
        </button>

    </div>

</nav>

{{-- CONTENT --}}
<section class="px-6 md:px-16 py-10 relative z-10 animate-fade-in">

    {{-- BACK --}}
    <a href="{{ route('admin.pelanggan') }}"
       class="inline-flex items-center gap-2 text-[#D4A574] font-medium mb-6
       hover:gap-4 transition duration-300 group">

        ← Kembali
    </a>

    <h1 class="text-4xl md:text-5xl font-bold text-[#2C1810] mb-10 animate-slide-up">
        Detail Pelanggan
    </h1>

    {{-- PROFILE --}}
    <div class="bg-white/70 backdrop-blur-xl border border-[#E8D5C4]
        rounded-3xl p-8 shadow-lg flex flex-col md:flex-row items-center gap-6
        hover:shadow-2xl hover:-translate-y-2 transition duration-300 group">

        <div class="relative">
            <img src="{{ $pelanggan->avatar ?? 'https://i.pravatar.cc/100' }}"
                 class="w-24 h-24 rounded-full border-4 border-[#D4A574] shadow">

            <div class="absolute inset-0 bg-[#D4A574]/30 blur-xl rounded-full
                opacity-0 group-hover:opacity-100 transition"></div>
        </div>

        <div>
            <h2 class="text-2xl font-bold text-[#2C1810]">
                {{ $pelanggan->nama_lengkap }}
            </h2>

            <p class="text-[#D4A574] mt-1 font-medium">
                Member sejak
                {{ \Carbon\Carbon::parse($pelanggan->created_at)->translatedFormat('F Y') }}
            </p>
        </div>

    </div>

    {{-- INFO --}}
    <div class="mt-8 grid md:grid-cols-2 gap-6">

        @foreach([
            ['icon'=>'EmailIcon.svg','label'=>'Email','value'=>$pelanggan->email],
            ['icon'=>'PhoneIcon.svg','label'=>'No HP','value'=>$pelanggan->no_telp ?? '-'],
            ['icon'=>'LocationIcon.svg','label'=>'Alamat','value'=>$pelanggan->alamat ?? '-']
        ] as $item)

        <div class="flex items-center gap-4 p-5 rounded-2xl
            bg-white/70 backdrop-blur-xl border border-[#E8D5C4]
            hover:bg-[#D4A574]/10 hover:scale-[1.02]
            hover:shadow-xl transition duration-300 group cursor-pointer">

            <div class="bg-[#D4A574]/20 p-3 rounded-xl
                group-hover:rotate-6 group-hover:scale-110 transition">
                <img src="{{ asset('icons/'.$item['icon']) }}" class="w-5">
            </div>

            <div>
                <p class="text-sm text-[#6B5847]">{{ $item['label'] }}</p>
                <p class="font-semibold text-[#2C1810]">
                    {{ $item['value'] }}
                </p>
            </div>

        </div>

        @endforeach

    </div>

    {{-- RIWAYAT --}}
    <div class="mt-10">

        <h2 class="text-3xl font-bold text-[#2C1810] mb-6">
            Riwayat Pesanan
        </h2>

        <div class="bg-white/70 backdrop-blur-xl border border-[#E8D5C4]
            rounded-3xl shadow-lg overflow-hidden">

            @if($pesanan->isEmpty())

                <div class="p-12 text-center text-[#6B5847] animate-pulse">
                    <p class="text-lg font-medium">
                        Pelanggan ini belum melakukan transaksi.
                    </p>
                </div>

            @else

                @foreach($pesanan as $p)
                <div class="flex justify-between items-center p-6 border-t
                    hover:bg-[#D4A574]/10 hover:scale-[1.01]
                    transition duration-300 cursor-pointer group order-item">

                    <div>
                        <p class="font-bold text-[#2C1810]">
                            ORD-{{ $p->id_pesanan }}
                        </p>

                        <p class="text-sm text-[#6B5847]">
                            {{ \Carbon\Carbon::parse($p->tanggal_pesanan)->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-[#2C1810]">
                            Rp {{ number_format($p->total_pembayaran,0,',','.') }}
                        </p>

                        <span class="text-xs px-3 py-1 rounded-full
                        @if($p->status_pesanan=='diantar') bg-green-100 text-green-600
                        @elseif($p->status_pesanan=='diproses') bg-yellow-100 text-yellow-600
                        @else bg-gray-200 text-gray-600
                        @endif
                        group-hover:scale-110 transition">
                            {{ $p->status_pesanan }}
                        </span>
                    </div>

                </div>
                @endforeach

            @endif

        </div>

    </div>

</section>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan</title>
    @vite('resources/css/app.css')
</head>


{{-- SCRIPT --}}
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
</script>


<body class="min-h-screen font-dm-sans
bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

@include('layouts.navbar')
{{-- CONTENT --}}
<section class="px-6 md:px-16 py-10">

    <h1 class="text-4xl md:text-5xl font-bold text-[#2C1810] mb-10">
        Manajemen Akun Pelanggan
    </h1>

    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] overflow-hidden">

        {{-- HEADER --}}
        <div class="hidden md:grid grid-cols-4 bg-[#E8D5C4]/60 p-6 font-semibold text-[#2C1810]">
            <div>Nama</div>
            <div>Email</div>
            <div>Alamat</div>
            <div></div>
        </div>

        {{-- DATA --}}
        @foreach($pelanggan as $p)
        <div onclick="window.location='{{ route('admin.pelanggan.detail',$p->id_akun) }}'"
            class="grid grid-cols-1 md:grid-cols-4 items-center p-6 border-t
            hover:bg-[#D4A574]/10 hover:shadow-md hover:scale-[1.01]
            transition duration-300 cursor-pointer group gap-2">

            <div class="flex items-center gap-3 font-semibold text-[#2C1810]">
                <img src="{{ asset('icons/ProfileIcon.svg') }}" class="w-5">
                {{ $p->nama_lengkap }}
            </div>

            <div class="text-[#6B5847] text-sm">
                {{ $p->email }}
            </div>

            <div class="hidden md:block text-[#6B5847] truncate">
                {{ $p->alamat ?? '-' }}
            </div>

            <div class="hidden md:flex justify-end">
                <a href="{{ route('admin.pelanggan.detail',$p->id_akun) }}"
                   onclick="event.stopPropagation()"
                   class="px-5 py-2 rounded-xl border border-[#D4A574]
                   text-[#D4A574]
                   hover:bg-[#D4A574] hover:text-white
                   transition">
                    Detail
                </a>
            </div>

        </div>
        @endforeach

    </div>

</section>

</body>
</html>

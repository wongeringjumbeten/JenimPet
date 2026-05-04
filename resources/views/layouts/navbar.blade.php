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

    <a href="{{ route('admin.dashboard') }}"
    class="{{ request()->routeIs('admin.dashboard') ? 'text-[#D4A574] font-semibold' : 'hover:text-[#D4A574]' }}">
    Dashboard
    </a>

    <a href="{{ route('admin.katalog') }}"
    class="{{ request()->routeIs('admin.katalog*') ? 'text-[#D4A574] font-semibold' : 'hover:text-[#D4A574]' }}">
    Katalog
    </a>

    <a href="#"
    class="hover:text-[#D4A574]">
    Pesanan
    </a>

    <a href="#"
    class="hover:text-[#D4A574]">
    Laporan
    </a>

    <a href="{{ route('admin.pelanggan') }}"
    class="{{ request()->routeIs('admin.pelanggan*') ? 'text-[#D4A574] font-semibold' : 'hover:text-[#D4A574]' }}">
    Pelanggan
    </a>

    <a href="#"
    class="hover:text-[#D4A574]">
    Review
    </a>

    {{-- INI YANG DIUPDATE --}}
    <a href="{{ route('admin.profile') }}"
    class="{{ request()->routeIs('admin.profile') ? 'text-[#D4A574] font-semibold' : 'hover:text-[#D4A574]' }}">
    Profil
    </a>

</div>

    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-3">

        {{-- AVATAR --}}
        <img src="{{ auth()->user()->avatar ?? 'https://i.pravatar.cc/100' }}"
            class="w-9 h-9 rounded-full border-2 border-[#D4A574] shadow">

        {{-- HAMBURGER MOBILE --}}
        <button id="menuBtn"
            class="md:hidden flex flex-col gap-1.5">
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
            <span class="w-6 h-[2px] bg-[#2C1810]"></span>
        </button>

    </div>

</nav>

{{-- MOBILE MENU --}}
<div id="mobileMenu"
class="fixed top-0 right-0 w-64 h-full bg-white shadow-2xl
transform translate-x-full transition duration-300 z-50 p-6 flex flex-col gap-6">

    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.katalog') }}">Katalog</a>
    <a href="#">Pesanan</a>
    <a href="#">Laporan</a>
    <a href="{{ route('admin.pelanggan') }}">Pelanggan</a>
    <a href="#">Review</a>
    <a href="{{ route('admin.profile') }}">Profil</a>


</div>

{{-- OVERLAY --}}
<div id="overlay"
class="fixed inset-0 bg-black/30 backdrop-blur-sm opacity-0 pointer-events-none transition duration-300 z-40">
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const btn = document.getElementById('menuBtn');
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('overlay');

    let open = false;

    function openMenu() {
        menu.classList.remove('translate-x-full');
        overlay.classList.remove('opacity-0','pointer-events-none');
        open = true;

        const spans = btn.querySelectorAll('span');
        spans[0].classList.add('rotate-45','translate-y-[6px]');
        spans[1].classList.add('opacity-0');
        spans[2].classList.add('-rotate-45','-translate-y-[6px]');
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

    overlay.addEventListener('click', closeMenu);

});
</script>

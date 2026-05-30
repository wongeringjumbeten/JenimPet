<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - JenimPet</title>
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
        .stat-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px -10px rgba(0, 0, 0, 0.15);
        }
    </style>
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
</script>
<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen relative overflow-x-hidden">

    {{-- BACKGROUND GLOW --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#D4A574]/30 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#B8965A]/30 rounded-full blur-[120px]"></div>

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- CONTENT --}}
    <section class="px-6 md:px-16 py-10 relative z-10">

        <div class="flex justify-between items-center mb-10 animate-fade-slide-up">
            <h1 class="text-4xl md:text-5xl font-bold text-[#2C1810]">
                Profil Admin
            </h1>

            {{-- TOMBOL LOGOUT --}}
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <button type="button" id="logoutBtn"
                    class="group relative px-6 py-3 rounded-2xl font-semibold
                    bg-gradient-to-r from-red-500 to-red-600 text-white
                    shadow-lg hover:shadow-red-500/30 hover:scale-105
                    transition-all duration-300 overflow-hidden">

                    <span class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                    <span class="relative flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </span>
                </button>
            </form>
        </div>

        {{-- PROFILE CARD --}}
        <div class="bg-white/70 backdrop-blur-xl border border-[#E8D5C4]
            rounded-3xl p-8 shadow-lg hover:shadow-2xl transition
            flex flex-col md:flex-row items-center gap-6
            hover:-translate-y-1 duration-300 animate-scale-in">

            <div class="relative group">
                <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/100' }}"
                    class="w-28 h-28 rounded-full border-4 border-[#D4A574] shadow-lg">

                <div class="absolute inset-0 rounded-full bg-[#D4A574]/30 blur-xl opacity-0 group-hover:opacity-100 transition"></div>

                <div class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow">
                    <img src="{{ asset('icons/AdminIcon.svg') }}" class="w-4 h-4">
                </div>
            </div>

            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold text-[#2C1810]">
                    {{ $user->nama_lengkap }}
                </h2>
                <p class="text-[#D4A574] mt-1 font-medium">
                    Member sejak {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}
                </p>
            </div>
        </div>

        {{-- INFO CARD --}}
        <div class="mt-8 bg-white/70 backdrop-blur-xl border border-[#E8D5C4]
            rounded-3xl p-8 shadow-lg hover:shadow-2xl transition animate-scale-in">

            <div class="grid md:grid-cols-2 gap-6">

                {{-- EMAIL --}}
                <div class="flex items-center gap-4 p-4 rounded-xl
                    hover:bg-[#D4A574]/10 transition group">

                    <div class="bg-[#D4A574]/20 p-3 rounded-xl shadow group-hover:scale-110 transition">
                        <img src="{{ asset('icons/EmailIcon.svg') }}" class="w-5 h-5">
                    </div>

                    <div>
                        <p class="text-sm text-[#6B5847]">Alamat Email</p>
                        <p class="font-semibold text-[#2C1810]">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                {{-- PHONE --}}
                <div class="flex items-center justify-between p-4 rounded-xl
                    hover:bg-[#D4A574]/10 transition group">

                    <div class="flex items-center gap-4">
                        <div class="bg-[#D4A574]/20 p-3 rounded-xl shadow group-hover:scale-110 transition">
                            <img src="{{ asset('icons/PhoneIcon.svg') }}" class="w-5 h-5">
                        </div>

                        <div>
                            <p class="text-sm text-[#6B5847]">No HP</p>
                            <p class="font-semibold text-[#2C1810]">
                                {{ $user->no_telp ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.edit.hp') }}"
                        class="p-3 rounded-full bg-white shadow
                        hover:shadow-lg hover:scale-110
                        transition duration-300 group">

                        <img src="{{ asset('icons/EditIcon.svg') }}"
                            class="w-5 h-5 group-hover:rotate-12 transition">
                    </a>
                </div>
            </div>
        </div>

        {{-- STATS REAL DATA --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
            <div class="stat-card bg-white/70 backdrop-blur-xl border border-[#E8D5C4] p-6 rounded-2xl shadow">
                <p class="text-[#6B5847] text-sm">Produk Aktif</p>
                <h3 class="text-2xl font-bold text-[#2C1810] mt-1">{{ number_format($totalProduk) }}</h3>
            </div>
            <div class="stat-card bg-white/70 backdrop-blur-xl border border-[#E8D5C4] p-6 rounded-2xl shadow">
                <p class="text-[#6B5847] text-sm">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-[#2C1810] mt-1">{{ number_format($totalPesanan) }}</h3>
            </div>
            <div class="stat-card bg-white/70 backdrop-blur-xl border border-[#E8D5C4] p-6 rounded-2xl shadow">
                <p class="text-[#6B5847] text-sm">Pendapatan</p>
                <h3 class="text-2xl font-bold text-[#D4A574] mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-card bg-white/70 backdrop-blur-xl border border-[#E8D5C4] p-6 rounded-2xl shadow">
                <p class="text-[#6B5847] text-sm">Pelanggan</p>
                <h3 class="text-2xl font-bold text-[#2C1810] mt-1">{{ number_format($totalUser) }}</h3>
            </div>
        </div>

    </section>

    {{-- SCRIPT KONFIRMASI LOGOUT --}}
    <script>
        document.getElementById('logoutBtn')?.addEventListener('click', function(e) {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);

            const confirmed = confirm('Apakah Anda yakin ingin logout?');
            if (confirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    </script>

</body>
</html>

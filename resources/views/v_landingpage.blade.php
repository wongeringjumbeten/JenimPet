<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JenimPet - Teman Hamster Terbaikmu</title>

    @vite(['resources/css/app.css'])

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-custom font-dm-sans overflow-x-hidden">

    {{-- HAMSTER BERJALAN DI BACKGROUND --}}
    <div class="fixed bottom-10 left-0 z-20 pointer-events-none text-3xl" id="walking-hamster">
        🐹
    </div>
    <div class="fixed bottom-20 left-0 z-20 pointer-events-none opacity-60 text-2xl" id="walking-hamster2">
        🐭
    </div>

    {{-- NAVBAR BACKGROUND COKLAT DENGAN BULAT PADA SETIAP ELEMEN --}}
    <nav class="fixed top-0 left-0 w-full z-50 bg-primary shadow-lg" id="main-nav">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            {{-- Logo JenimPet TERANG --}}
            <a href="/" class="font-playfair text-2xl font-bold text-white group relative z-10">
                Jenim<span class="text-amber-light group-hover:text-amber-200 transition">Pet</span>
            </a>

            {{-- DESKTOP NAVBAR DENGAN BACKGROUND BULAT --}}
            <div class="hidden md:flex gap-2 items-center relative z-10">
                <!-- Katalog -->
                <div class="nav-item-wrapper">
                    <a href="#katalog" class="nav-link-custom">
                        Katalog
                    </a>
                </div>

                <!-- Review -->
                <div class="nav-item-wrapper">
                    <a href="#review" class="nav-link-custom">
                        Review
                    </a>
                </div>

                <!-- Pesanan -->
                <div class="nav-item-wrapper">
                    <a href="#pesanan" class="nav-link-custom">
                        Pesanan
                    </a>
                </div>

                <!-- Keranjang -->
                <div class="nav-item-wrapper">
                    <a href="#keranjang" class="nav-link-custom">
                        Keranjang
                    </a>
                </div>

                {{-- CEK LOGIN UNTUK DESKTOP --}}
                @auth
                    {{-- DASHBOARD --}}
                    <div class="nav-item-wrapper">
                        @if(trim(Auth::user()->is_admin) == '1')
                            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="nav-link-custom">
                                Dashboard
                            </a>
                        @endif
                    </div>

                    {{-- LOGOUT BUTTON --}}
                    <div class="nav-item-wrapper">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link-custom">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    {{-- LOGIN (TANPA HAMSTER) --}}
                    <div class="nav-item-wrapper">
                        <a href="{{ route('login') }}" class="nav-link-custom login-btn">
                            Login
                        </a>
                    </div>
                @endauth
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <button id="mobile-menu-btn" class="md:hidden text-2xl text-white relative z-10">
                ☰
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <div id="mobile-menu" class="hidden md:hidden bg-primary/95 backdrop-blur-md border-t border-amber-light/30 py-4 px-6 flex flex-col gap-4">
            <a href="#katalog" class="text-white/80 hover:text-white transition">Katalog</a>
            <a href="#review" class="text-white/80 hover:text-white transition">Review</a>
            <a href="#pesanan" class="text-white/80 hover:text-white transition">Pesanan</a>
            <a href="#keranjang" class="text-white/80 hover:text-white transition">Keranjang</a>

            @auth
                {{-- DASHBOARD MOBILE --}}
                @if(trim(Auth::user()->is_admin) == '1')
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-amber-light to-amber-dark text-white rounded-full font-semibold text-center hover:shadow-lg transition">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-amber-light to-amber-dark text-white rounded-full font-semibold text-center hover:shadow-lg transition">
                        Dashboard
                    </a>
                @endif

                {{-- LOGOUT MOBILE --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-5 py-2 bg-red-500/80 hover:bg-red-600 text-white rounded-full font-semibold text-center transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 bg-gradient-to-r from-amber-light to-amber-dark text-white rounded-full font-semibold text-center hover:shadow-lg transition">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <main class="pt-24">
        {{-- HERO SECTION --}}
        <section class="relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-20 left-10 text-6xl animate-bounce-slow">🐹</div>
                <div class="absolute bottom-20 right-10 text-5xl animate-bounce-slow delay-100">🐭</div>
                <div class="absolute top-40 right-20 text-4xl animate-pulse-slow">🐹</div>
            </div>

            <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-up">
                    <div class="inline-block px-4 py-1 bg-amber-light/20 rounded-full text-amber-dark text-sm font-semibold mb-4 animate-pulse-slow">
                        ✨ Teman Setiamu ✨
                    </div>

                    <h1 class="hero-title font-playfair text-4xl lg:text-6xl font-bold text-primary leading-tight">
                        Discover your perfect<br>
                        <span class="text-amber-dark relative inline-block hero-highlight">
                            furry companion
                        </span>
                    </h1>

                    <p class="text-secondary text-lg mt-6 leading-relaxed animate-slide-up delay-200">
                        Welcome to JenimPet! We offer a carefully curated selection of healthy, happy hamsters
                        along with everything you need to care for them. Each pet comes with expert guidance
                        and ongoing support.
                    </p>
                    <a href="#katalog" class="inline-block mt-8 px-8 py-3 bg-gradient-to-r from-amber-light to-amber-dark text-white font-semibold rounded-full shadow-md hover:shadow-2xl hover:scale-110 hover:-translate-y-1 transition-all duration-300 group animate-slide-up delay-300">
                        Browse Hamsters
                        <span class="inline-block group-hover:translate-x-1 transition">→</span>
                    </a>
                </div>

                <div class="relative animate-fade-up delay-100 group">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/50 group-hover:shadow-3xl transition-all duration-500">
                        <img src="{{ asset('images/hamster.jpg') }}" alt="Hamster Lucu" class="w-full h-auto object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-amber-light/30 rounded-full blur-2xl -z-10 group-hover:scale-150 transition duration-700"></div>
                    <div class="absolute -top-6 -left-6 w-48 h-48 bg-amber-dark/20 rounded-full blur-2xl -z-10 group-hover:scale-150 transition duration-700 delay-100"></div>

                    <div class="absolute -top-4 -right-4 bg-white rounded-full px-3 py-1 shadow-lg animate-bounce-slow">
                        <span class="text-amber-dark font-bold">🐹 HOT!</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- KATALOG HAMSTER --}}
        <section id="katalog" class="py-20 bg-white/40 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5 pointer-events-none">
                <div class="absolute top-10 left-1/4 text-7xl animate-float">🐹</div>
                <div class="absolute bottom-20 right-1/3 text-6xl animate-float delay-200">🐭</div>
            </div>

            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12 animate-fade-up">
                    <h2 class="font-playfair text-3xl lg:text-4xl font-bold text-primary">🐹 Hamster yang Ada 🐹</h2>
                    <p class="text-secondary mt-2">Pilih teman kecilmu yang menggemaskan</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Card 1: Cinnamon --}}
                    <div class="hamster-card group animate-fade-up delay-100">
                        <div class="overflow-hidden rounded-2xl relative">
                            <img src="https://placehold.co/400x300/F5E6D3/B8956A?text=🐹+Cinnamon" alt="Cinnamon Hamster" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            <div class="absolute top-3 right-3 bg-white/90 rounded-full px-2 py-1 text-xs font-bold text-amber-dark shadow-md">
                                ⭐ Best Seller
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="font-playfair text-2xl font-bold text-primary group-hover:text-amber-dark transition">Cinnamon</h3>
                            <p class="text-tertiary text-sm">Syrian hamster</p>
                            <p class="text-amber-dark font-bold text-xl mt-3">Rp 150.000</p>
                            <button class="buy-btn mt-4 w-full group-hover:shadow-xl">
                                <span class="inline-block group-hover:scale-110 transition">🐹</span> Beli Sekarang
                                <span class="inline-block group-hover:translate-x-1 transition">→</span>
                            </button>
                        </div>
                    </div>

                    {{-- Card 2: Mocha --}}
                    <div class="hamster-card group animate-fade-up delay-200">
                        <div class="overflow-hidden rounded-2xl relative">
                            <img src="https://placehold.co/400x300/E8D5C4/9B6B3F?text=🐹+Mocha" alt="Mocha Hamster" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="font-playfair text-2xl font-bold text-primary group-hover:text-amber-dark transition">Mocha</h3>
                            <p class="text-tertiary text-sm">Roborovski hamster</p>
                            <p class="text-amber-dark font-bold text-xl mt-3">Rp 120.000</p>
                            <button class="buy-btn mt-4 w-full">
                                <span class="inline-block group-hover:scale-110 transition">🐹</span> Beli Sekarang
                                <span class="inline-block group-hover:translate-x-1 transition">→</span>
                            </button>
                        </div>
                    </div>

                    {{-- Card 3: Snowball --}}
                    <div class="hamster-card group animate-fade-up delay-300">
                        <div class="overflow-hidden rounded-2xl relative">
                            <img src="https://placehold.co/400x300/FAF7F2/B8956A?text=🐹+Snowball" alt="Snowball Hamster" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            <div class="absolute top-3 right-3 bg-amber-dark/90 rounded-full px-2 py-1 text-xs font-bold text-white shadow-md">
                                🎁 New
                            </div>
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="font-playfair text-2xl font-bold text-primary group-hover:text-amber-dark transition">Snowball</h3>
                            <p class="text-tertiary text-sm">Winter white hamster</p>
                            <p class="text-amber-dark font-bold text-xl mt-3">Rp 135.000</p>
                            <button class="buy-btn mt-4 w-full">
                                <span class="inline-block group-hover:scale-110 transition">🐹</span> Beli Sekarang
                                <span class="inline-block group-hover:translate-x-1 transition">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION: LOKASI TOKO + MAPS --}}
        <section id="lokasi" class="py-20 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-up">
                        <h2 class="font-playfair text-3xl lg:text-4xl font-bold text-primary">📍 Lokasi Toko</h2>
                        <div class="mt-8 space-y-6">
                            <div class="flex gap-4 items-start group hover:translate-x-2 transition duration-300">
                                <span class="text-2xl group-hover:scale-125 transition">📍</span>
                                <div>
                                    <p class="font-semibold text-primary">Address</p>
                                    <p class="text-secondary">Jl. Merpati No. 123, Jakarta Selatan, DKI Jakarta 12345</p>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start group hover:translate-x-2 transition duration-300 delay-100">
                                <span class="text-2xl group-hover:scale-125 transition">📞</span>
                                <div>
                                    <p class="font-semibold text-primary">Phone</p>
                                    <p class="text-secondary">+62 812-3456-7890</p>
                                </div>
                            </div>
                            <div class="flex gap-4 items-start group hover:translate-x-2 transition duration-300 delay-200">
                                <span class="text-2xl group-hover:scale-125 transition">✉️</span>
                                <div>
                                    <p class="font-semibold text-primary">Email</p>
                                    <p class="text-secondary">hello@jenimpet.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="animate-fade-up delay-100 group">
                        <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white/50 group-hover:shadow-3xl transition duration-500 group-hover:scale-[1.02]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7898.800141188276!2d113.6995634!3d-8.1623861!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695745f57a925%3A0xbf3f0ef2a184a578!2sJenim%20Hamster%20Farm!5e0!3m2!1sid!2sid!4v1776688569039!5m2!1sid!2sid"
                                width="100%"
                                height="350"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-primary/90 text-white py-12 mt-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute -bottom-10 -left-10 text-8xl animate-float">🐹</div>
            <div class="absolute -top-10 -right-10 text-7xl animate-float delay-300">🐭</div>
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <h3 class="font-playfair text-2xl font-bold">Jenim<span class="text-amber-light">Pet</span></h3>
                    <p class="text-white/70 text-sm mt-1">🐹 Teman setia untuk hamster kesayanganmu 🐹</p>
                </div>
                <div class="flex gap-6">
                    <a href="#katalog" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Katalog</a>
                    <a href="#review" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Review</a>
                    <a href="#pesanan" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Pesanan</a>

                    @auth
                        @if(trim(Auth::user()->is_admin) == '1')
                            <a href="{{ route('admin.dashboard') }}" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Dashboard Admin</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Dashboard</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white/80 hover:text-white hover:scale-110 transition inline-block">Login</a>
                    @endauth
                </div>
                <div class="text-white/60 text-sm">
                    © 2026 JenimPet. 🐹 All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    {{-- ALL SCRIPTS --}}
    <script>
        // ==================== HERO TEXT EFEK GERAK ====================
        const heroText = document.querySelector('.hero-highlight');
        if (heroText) {
            setInterval(() => {
                heroText.style.transform = 'scale(1.02)';
                heroText.style.textShadow = '0 0 10px rgba(212,165,116,0.5)';
                setTimeout(() => {
                    heroText.style.transform = 'scale(1)';
                    heroText.style.textShadow = 'none';
                }, 300);
            }, 2000);
        }

        // ==================== HAMSTER JALAN ====================
        let pos = 0;
        let pos2 = 0;
        const hamster = document.getElementById('walking-hamster');
        const hamster2 = document.getElementById('walking-hamster2');

        function walkHamster() {
            if (hamster) {
                pos += 0.5;
                if (pos > window.innerWidth) pos = -50;
                hamster.style.transform = `translateX(${pos}px) scaleX(-1)`;
            }
            if (hamster2) {
                pos2 += 0.3;
                if (pos2 > window.innerWidth) pos2 = -50;
                hamster2.style.transform = `translateX(${pos2}px)`;
            }
            requestAnimationFrame(walkHamster);
        }
        walkHamster();

        // ==================== MOBILE MENU ====================
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // ==================== SMOOTH SCROLL ====================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });

        // ==================== SCROLL REVEAL ====================
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fade-up, .hamster-card, .hero-title').forEach(el => {
            if (!el.classList.contains('hero-title')) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            }
        });
    </script>
</body>
</html>

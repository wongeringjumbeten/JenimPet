<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenim Hamster Farm — Sign in</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('icons/JenimHamsterLogo.png') }}">

    {{-- Vite + Tailwind CSS v4 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased overflow-x-hidden bg-gradient-custom min-h-screen relative">

    {{-- BACKGROUND ANIMASI FLOATING HAMSTER --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-20 left-10 text-7xl animate-float opacity-20">🐹</div>
        <div class="absolute bottom-20 right-10 text-6xl animate-float-delay opacity-20">🐭</div>
        <div class="absolute top-1/2 left-1/4 text-5xl animate-float-slow opacity-10">🐹</div>
        <div class="absolute bottom-1/3 right-1/3 text-8xl animate-pulse-slow opacity-10">🐭</div>
        <div class="absolute top-40 right-20 text-4xl animate-bounce-slow opacity-15">🐹</div>
    </div>

    {{-- DECORATIVE BLUR BACKGROUND --}}
    <div class="fixed -top-40 -right-40 w-96 h-96 bg-amber-light/20 rounded-full blur-[100px] z-0"></div>
    <div class="fixed -bottom-40 -left-40 w-96 h-96 bg-amber-dark/20 rounded-full blur-[100px] z-0"></div>

    <main class="min-h-screen w-full flex items-center justify-center px-6 py-12 relative z-10">
        <div class="max-w-6xl w-full mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- KIRI: Branding dengan Logo Asli --}}
            <div class="space-y-6 animate-fade-up relative">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-amber-light/20 rounded-full blur-3xl -z-10"></div>

                <div class="space-y-4">
                    {{-- LOGO ASLI --}}
                    <div class="flex justify-start">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-amber-light to-amber-dark rounded-2xl blur opacity-0 group-hover:opacity-50 transition duration-500"></div>
                            <img src="{{ asset('icons/JenimHamsterLogo.png') }}"
                                 alt="Jenim Hamster Farm"
                                 class="relative w-20 h-20 md:w-24 md:h-24 object-contain rounded-xl group-hover:scale-105 transition duration-300">
                        </div>
                    </div>

                    <h1 class="font-playfair text-5xl lg:text-7xl font-bold leading-tight tracking-tight">
                        <span class="text-primary relative inline-block">
                            Jenim Hamster
                            <div class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-amber-light to-amber-dark rounded-full"></div>
                        </span>
                        <br>
                        <span class="text-amber-dark relative inline-block group">
                            Farm
                            <span class="absolute -top-5 -right-8 text-3xl group-hover:rotate-12 transition duration-300">🐹</span>
                        </span>
                    </h1>

                    <p class="text-secondary text-lg lg:text-xl max-w-md leading-relaxed">
                        Dapatkan pengalaman menarik dalam mengetahui tentang jenis dan memelihara hamster.
                    </p>
                </div>

                {{-- STATS MINI --}}
                <div class="flex gap-8 pt-6">
                    <div class="text-center group cursor-pointer">
                        <p class="text-2xl font-bold text-primary group-hover:text-amber-dark transition">500+</p>
                        <p class="text-sm text-secondary">Hamster Terjual</p>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <p class="text-2xl font-bold text-primary group-hover:text-amber-dark transition">50+</p>
                        <p class="text-sm text-secondary">Customer Happy</p>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <p class="text-2xl font-bold text-primary group-hover:text-amber-dark transition">4.9⭐</p>
                        <p class="text-sm text-secondary">Rating</p>
                    </div>
                </div>
            </div>

            {{-- KANAN: Panel Login (Glassmorphism Enhanced) --}}
            <div class="animate-fade-up delay-100">
                <div class="login-panel-enhanced group relative overflow-hidden">

                    {{-- Animated gradient border --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-light/30 via-amber-dark/20 to-amber-light/30 opacity-0 group-hover:opacity-100 transition duration-700"></div>

                    {{-- Inner content --}}
                    <div class="relative z-10 space-y-8">
                        {{-- Header Form with Logo --}}
                        <div class="text-center">
                            <div class="inline-block mb-3">
                                <div class="w-16 h-16 bg-gradient-to-br from-amber-light to-amber-dark rounded-2xl flex items-center justify-center shadow-lg mx-auto p-2">
                                    <img src="{{ asset('icons/JenimHamsterLogo.png') }}" alt="JenimPet" class="w-12 h-12 object-contain">
                                </div>
                            </div>
                            <h2 class="font-playfair text-3xl font-bold text-primary">Sign in</h2>
                            <p class="text-secondary mt-2">Access your account with Google</p>
                        </div>

                        {{-- Divider dengan Welcome back yang lebih gacor --}}
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-amber-light/40"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="welcome-back-badge-enhanced">
                                    ✨ Welcome back ✨
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Google --}}
                        <a href="{{ route('google.login') }}" class="google-btn-enhanced group block">
                            <div class="flex items-center justify-center gap-3">
                                <img src="{{ asset('icons/GoogleIcon.png') }}" alt="Google" class="w-5 h-5 object-contain">
                                <span>Continue with Google</span>
                            </div>
                            <div class="absolute inset-0 -z-10 bg-gradient-to-r from-amber-light/0 via-amber-light/20 to-amber-light/0 opacity-0 group-hover:opacity-100 transition duration-500 scale-150 group-hover:scale-100"></div>
                        </a>

                        {{-- Terms & Privacy dengan efek hover --}}
                        <div class="pt-3 text-center">
                            <p class="text-xs text-tertiary leading-relaxed">
                                By continuing, you agree to our
                                <a href="#" class="terms-link-enhanced inline-flex items-center gap-1">
                                    Terms of Service
                                    <span class="text-xs group-hover:translate-x-0.5 transition">→</span>
                                </a>
                                and
                                <a href="#" class="terms-link-enhanced inline-flex items-center gap-1">
                                    Privacy Policy
                                    <span class="text-xs group-hover:translate-x-0.5 transition">→</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- EXTRA CSS UNTUK ENHANCEMENT --}}
    <style>
        /* Login Panel Enhanced */
        .login-panel-enhanced {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.5);
            padding: 2.5rem 2rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @media (min-width: 768px) {
            .login-panel-enhanced {
                padding: 3rem 2.5rem;
            }
        }

        .login-panel-enhanced:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 50px -12px rgba(212, 165, 116, 0.3), 0 0 0 1px rgba(212, 165, 116, 0.3);
            background: rgba(255, 255, 255, 0.85);
        }

        /* Welcome Back Badge Enhanced */
        .welcome-back-badge-enhanced {
            display: inline-block;
            padding: 0.375rem 1.25rem;
            background: linear-gradient(135deg, #D4A574, #B8956A);
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            border-radius: 9999px;
            box-shadow: 0 4px 10px -2px rgba(212, 165, 116, 0.4);
            letter-spacing: 0.5px;
        }

        /* Google Button Enhanced */
        .google-btn-enhanced {
            position: relative;
            width: 100%;
            background: white;
            padding: 0.875rem 1.5rem;
            border-radius: 1rem;
            border: 1px solid #E8D5C4;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            font-weight: 600;
            color: #2C1810;
            cursor: pointer;
            overflow: hidden;
            text-align: center;
        }

        .google-btn-enhanced:hover {
            transform: scale(1.02);
            border-color: #D4A574;
            box-shadow: 0 8px 20px -8px rgba(212, 165, 116, 0.4);
            background: #FAF7F2;
        }

        .google-btn-enhanced:active {
            transform: scale(0.98);
        }

        /* Terms Link Enhanced */
        .terms-link-enhanced {
            color: #D4A574;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.2s ease;
        }

        .terms-link-enhanced::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: linear-gradient(90deg, #D4A574, #B8956A);
            transition: width 0.3s ease;
        }

        .terms-link-enhanced:hover {
            color: #B8956A;
            transform: translateX(2px);
        }

        .terms-link-enhanced:hover::after {
            width: 100%;
        }

        /* Additional animations */
        .animate-float-delay {
            animation: float 6s ease-in-out infinite;
            animation-delay: 1s;
        }

        .animate-float-slow {
            animation: float 8s ease-in-out infinite;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
    </style>
</body>
</html>

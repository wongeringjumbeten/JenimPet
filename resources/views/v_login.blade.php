<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenim Hamster Farm — Sign in</title>

    {{-- Vite + Tailwind CSS v4 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased overflow-x-hidden bg-gradient-custom min-h-screen">

    {{-- Container untuk hujan hamster (diisi oleh JS) --}}
    {{-- <div id="hamster-rain-container"></div> --}}

    <main class="min-h-screen w-full flex items-center justify-center px-6 py-12 relative z-10">
        <div class="max-w-6xl w-full mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- KIRI: Branding --}}
            <div class="space-y-6 animate-fade-up">
                <div class="space-y-4">
                    <h1 class="font-playfair text-5xl lg:text-7xl font-bold text-primary leading-tight tracking-tight">
                        Jenim Hamster<br>
                        <span class="text-amber-dark">Farm</span>
                    </h1>
                    <p class="text-secondary text-lg lg:text-xl max-w-md leading-relaxed">
                        Dapatkan pengalaman menarik dalam mengetahui tentang jenis dan memelihara hamster.
                    </p>
                </div>
            </div>

            {{-- KANAN: Panel Login --}}
            <div class="animate-fade-up delay-100">
                <div class="login-panel">

                    <div class="space-y-7">
                        {{-- Header Form --}}
                        <div class="text-center lg:text-left">
                            <h2 class="font-playfair text-3xl lg:text-4xl font-bold text-primary">Sign in</h2>
                            <p class="text-secondary mt-2">Access your account with Google</p>
                        </div>

                        {{-- Divider dengan Welcome back --}}
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-amber-light/30"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="welcome-back-badge">
                                    Welcome back
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Google --}}
                        <a href="{{ route('google.login') }}" class="google-btn block text-center">
                        Continue with Google
                        </a>

                        {{-- Terms & Privacy --}}
                        <div class="pt-5 text-center">
                            <p class="text-xs text-tertiary leading-relaxed">
                                By continuing, you agree to our
                                <a href="#" class="terms-link">Terms of Service</a>
                                and
                                <a href="#" class="terms-link">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

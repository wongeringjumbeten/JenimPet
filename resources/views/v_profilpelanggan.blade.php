<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pelanggan</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-gradient-to-br from-[#F5E6D3] via-[#E8D5C4] to-[#D9C3A3] min-h-screen">

@include('layouts.navbar_pelanggan')

<section class="px-6 md:px-16 py-10">

    {{-- TITLE --}}
    <h1 class="text-4xl font-bold text-[#2C1810] mb-8">
        Profil Saya
    </h1>

    {{-- CARD PROFIL --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl p-6 flex items-center justify-between mb-6">

        <div class="flex items-center gap-5">

            {{-- AVATAR --}}
            <div class="relative">
                @if($user->avatar)
                    <img src="{{ $user->avatar }}"
                        class="w-24 h-24 rounded-full border-4 border-[#D4A574] shadow">
                @else
                    <div class="w-24 h-24 rounded-full bg-[#E8D5C4]
                        flex items-center justify-center text-4xl">
                        🐹
                    </div>
                @endif

                {{-- ICON KECIL --}}
                <div class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow">
                    <img src="{{ asset('icons/ProfileIcon.svg') }}" class="w-4">
                </div>
            </div>

            {{-- NAMA --}}
            <div>
                <h2 class="text-2xl font-semibold text-[#2C1810]">
                    {{ $user->nama_lengkap }}
                </h2>

                <span class="text-sm text-[#B8965A]">
                    Member sejak {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') }}
                </span>
            </div>

        </div>

        {{-- EDIT --}}
        <a href="{{ route('profile.edit.nama') }}"
        class="bg-[#E8D5C4] p-3 rounded-full hover:scale-110 transition inline-block">
        <img src="{{ asset('icons/EditIcon.svg') }}" class="w-4">
        </a>

    </div>

    {{-- CARD INFO --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl p-6 space-y-5">

        {{-- EMAIL --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-4">
                <div class="bg-[#E8D5C4] p-3 rounded-xl">
                    <img src="{{ asset('icons/EmailIcon.svg') }}" class="w-5 h-5">
                </div>

                <div>
                    <p class="text-sm text-[#6B5847]">Alamat email</p>
                    <p class="font-semibold text-[#2C1810]">
                        {{ $user->email }}
                    </p>
                </div>
            </div>

        </div>

        {{-- NO HP --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-4">
                <div class="bg-[#E8D5C4] p-3 rounded-xl">
                    <img src="{{ asset('icons/PhoneIcon.svg') }}" class="w-5 h-5">
                </div>

                <div>
                    <p class="text-sm text-[#6B5847]">No. HP</p>
                    <p class="font-semibold text-[#2C1810]">
                        {{ $user->no_telp ?? '-' }}
                    </p>
                </div>
            </div>

            <a href="{{ route('profile.edit.hp') }}"
            class="bg-[#E8D5C4] p-3 rounded-full hover:scale-110 transition inline-block">
            <img src="{{ asset('icons/EditIcon.svg') }}" class="w-4">
            </a>

        </div>

        {{-- ALAMAT --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-4">
                <div class="bg-[#E8D5C4] p-3 rounded-xl">
                    <img src="{{ asset('icons/LocationIcon.svg') }}" class="w-5 h-5">
                </div>

                <div>
                    <p class="text-sm text-[#6B5847]">Alamat pengiriman</p>
                    <p class="font-semibold text-[#2C1810]">
                        {{ $user->alamat ?? '-' }}
                    </p>
                </div>
            </div>

            <a href="{{ route('profile.edit.alamat') }}"
            class="bg-[#E8D5C4] p-3 rounded-full hover:scale-110 transition inline-block">
            <img src="{{ asset('icons/EditIcon.svg') }}" class="w-4">
            </a>

        </div>

    </div>

</section>

</body>
</html>

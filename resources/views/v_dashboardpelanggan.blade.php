<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan</title>

    @vite(['resources/css/app.css'])

</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-8 w-full max-w-md text-center">

        {{-- Avatar --}}
        @if($user->avatar)
            <img src="{{ $user->avatar }}"
                 class="w-24 h-24 rounded-full mx-auto mb-4 shadow-lg border-4 border-amber-200">
        @else
            <div class="w-24 h-24 rounded-full bg-amber-200 mx-auto mb-4 flex items-center justify-center text-4xl">
                🐹
            </div>
        @endif

        {{-- Nama --}}
        <h1 class="text-2xl font-bold text-gray-800">
            Halo, {{ $user->nama_lengkap }} 👋
        </h1>

        {{-- Email --}}
        <p class="text-gray-500 mt-1">
            {{ $user->email }}
        </p>

        {{-- Status --}}
        <div class="mt-5 bg-amber-100 text-amber-700 py-2 px-4 rounded-full text-sm inline-block">
            Login sebagai Pelanggan
        </div>

        {{-- Divider --}}
        <div class="border-t my-6"></div>

        {{-- Tombol Logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-xl transition duration-200 shadow-md">
                Logout
            </button>
        </form>

    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Review - Admin Panel</title>
    @vite('resources/css/app.css')
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-[#2C1810] mb-2">Review</h1>
        <p class="text-[#6B5847]">Melihat rating dan review pelanggan</p>
    </div>

    {{-- Widget Elfsight Review (Admin view) --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6">
        <script src="https://elfsightcdn.com/platform.js" async></script>
        <div class="elfsight-app-1b2adfe6-8ccd-47d4-bacc-0e4b8f5d486e" data-elfsight-app-lazy></div>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Nama</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#EFE7DC] min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-[#F7F2EB] border border-[#E0CFC0] p-8 rounded-3xl shadow-xl">

    <h1 class="text-2xl font-bold text-[#2C1810] mb-6 text-center">
        Edit Nama
    </h1>

    {{-- ERROR BACKEND --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg text-sm">
            {{ $errors->first('nama_lengkap') }}
        </div>
    @endif

    <form action="{{ route('profile.update.nama') }}" method="POST" id="formNama">
        @csrf

        {{-- INPUT NAMA --}}
        <div class="mb-4">
            <label class="text-sm text-[#6B5847]">Nama Lengkap</label>

            <input type="text" id="nama" name="nama_lengkap"
                value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}"
                placeholder="Masukkan nama lengkap..."
                class="w-full mt-1 px-4 py-3 rounded-xl border border-[#E0CFC0]
                focus:ring-2 focus:ring-[#D4A574] outline-none">

            <p id="errorNama" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3">

            <a href="{{ route('profile') }}"
            class="w-full text-center py-3 rounded-xl border border-[#D4A574]
            text-[#D4A574] hover:bg-[#D4A574]/10 transition">
                Batal
            </a>

            <button type="submit" id="btnSubmit"
            class="w-full py-3 rounded-xl text-white bg-[#D4A574]
            hover:bg-[#b98c5f] transition flex justify-center items-center gap-2">

                <span id="btnText">Simpan</span>

                <svg id="loadingIcon" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="white"
                        d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>

            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('nama');
    const error = document.getElementById('errorNama');
    const form = document.getElementById('formNama');
    const btn = document.getElementById('btnSubmit');
    const text = document.getElementById('btnText');
    const loading = document.getElementById('loadingIcon');

    // VALIDASI REALTIME
    input.addEventListener('input', function () {

        // hapus angka & simbol
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');

        if (input.value.trim() === '') {
            error.innerText = "Nama wajib diisi";
            error.classList.remove('hidden');
        } else if (input.value.length < 3) {
            error.innerText = "Nama minimal 3 karakter";
            error.classList.remove('hidden');
        } else {
            error.classList.add('hidden');
        }

    });

    // VALIDASI SUBMIT
    form.addEventListener('submit', function (e) {

        if (input.value.trim() === '') {
            e.preventDefault();
            error.innerText = "Nama wajib diisi";
            error.classList.remove('hidden');
            return;
        }

        if (input.value.length < 3) {
            e.preventDefault();
            error.innerText = "Nama minimal 3 karakter";
            error.classList.remove('hidden');
            return;
        }

        // loading
        btn.disabled = true;
        text.innerText = "Menyimpan...";
        loading.classList.remove('hidden');

    });

});
</script>

</body>
</html>

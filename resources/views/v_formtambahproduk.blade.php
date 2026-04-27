<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

@include('layouts.navbar')

<div class="max-w-3xl mx-auto mt-12 bg-white/70 backdrop-blur-xl
rounded-3xl shadow-xl p-8 border border-[#E8D5C4]">

    <h1 class="text-3xl font-bold text-[#2C1810] mb-6">
        Tambah Produk
    </h1>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- FOTO PRODUK --}}
<div class="mb-6">

    <label class="block text-sm mb-2 text-[#6B5847]">
        Foto Produk
    </label>

    {{-- INPUT HIDDEN --}}
    <input type="file" name="foto_produk" id="fotoInput" class="hidden" accept="image/*">

    {{-- CONTAINER --}}
    <div id="uploadBox"
class="w-full h-56 border-2 border-dashed border-[#D4A574]/50
rounded-2xl flex flex-col items-center justify-center
text-[#6B5847] cursor-pointer
hover:bg-[#D4A574]/10 transition relative">

    {{-- TEXT --}}
    <div id="uploadText" class="text-center transition duration-300">
        <p class="font-medium">Klik untuk pilih foto</p>
        <p class="text-sm opacity-70">JPG / PNG max 2MB</p>
    </div>

    {{-- PREVIEW --}}
    <div class="mt-3 flex justify-center">
        <img id="previewImage"
        class="w-32 h-32 object-cover rounded-xl hidden shadow-lg border-2 border-white">
    </div>

</div>

    {{-- BUTTON HAPUS --}}
    <button type="button" id="removeImage"
        class="mt-3 px-4 py-2 text-sm rounded-xl
        bg-red-100 text-red-600 hover:bg-red-200
        hidden transition">
        Hapus Foto
    </button>

</div>

        {{-- NAMA --}}
        <div class="mb-4">
        <input type="text" id="nama_produk" name="nama_produk" placeholder="Nama Produk"
        class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574]">

        <p id="errorNama" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- DESKRIPSI --}}
        <textarea name="deskripsi" placeholder="Deskripsi"
        class="w-full mb-4 p-3 rounded-xl border border-[#D4A574]/50"></textarea>

        {{-- HARGA --}}
        <div class="mb-4">
        <input type="text" id="harga" name="harga" placeholder="Harga"
        class="w-full p-3 rounded-xl border border-[#D4A574]/50">

        <p id="errorHarga" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        {{-- STOK --}}
        <div class="mb-4">
        <input type="text" id="stok" name="stok" placeholder="Stok"
        class="w-full p-3 rounded-xl border border-[#D4A574]/50">

        <p id="errorStok" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-between">

            <a href="{{ route('admin.katalog') }}"
            class="px-6 py-2 border rounded-xl hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
            class="px-6 py-2 rounded-xl text-white
            bg-gradient-to-r from-[#D4A574] to-[#B8965A]
            hover:scale-105 transition">
                Simpan
            </button>

        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('fotoInput');
    const box = document.getElementById('uploadBox');
    const preview = document.getElementById('previewImage');
    const text = document.getElementById('uploadText');
    const removeBtn = document.getElementById('removeImage');

    // klik box = buka file
    box.addEventListener('click', () => {
        input.click();
    });

    // ketika pilih file
    input.addEventListener('change', function () {

        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');

            text.classList.add('hidden');
            removeBtn.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    });

    // hapus foto
    removeBtn.addEventListener('click', () => {

        input.value = '';
        preview.src = '';
        preview.classList.add('hidden');

        text.classList.remove('hidden');
        removeBtn.classList.add('hidden');
    });

});

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    const nama = document.getElementById('nama_produk');
    const harga = document.getElementById('harga');
    const stok = document.getElementById('stok');

    const errNama = document.getElementById('errorNama');
    const errHarga = document.getElementById('errorHarga');
    const errStok = document.getElementById('errorStok');

    // ========================
    // VALIDASI NAMA
    // ========================
    function validateNama() {
        let value = nama.value.trim();

        errNama.classList.add('hidden');

        if (value === '') {
            errNama.innerText = 'produk harus memiliki nama';
            errNama.classList.remove('hidden');
            nama.value = '';
            return false;
        }

        return true;
    }

    // ========================
    // VALIDASI ANGKA
    // ========================
    function validateNumber(input, errorEl) {

        let value = input.value.trim();

        errorEl.classList.add('hidden');

        if (value === '') {
            errorEl.innerText = 'harap isi data ini';
            errorEl.classList.remove('hidden');
            input.value = '';
            return false;
        }

        if (!/^[0-9]+$/.test(value)) {
            errorEl.innerText = 'harus berupa angka';
            errorEl.classList.remove('hidden');
            input.value = '';
            return false;
        }

        return true;
    }

    // realtime blur
    nama.addEventListener('blur', validateNama);
    harga.addEventListener('blur', () => validateNumber(harga, errHarga));
    stok.addEventListener('blur', () => validateNumber(stok, errStok));

    // submit
    form.addEventListener('submit', function (e) {

        let validNama = validateNama();
        let validHarga = validateNumber(harga, errHarga);
        let validStok = validateNumber(stok, errStok);

        if (!validNama || !validHarga || !validStok) {
            e.preventDefault();
        }

    });

});
</script>

</body>
</html>

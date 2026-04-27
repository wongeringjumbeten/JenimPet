<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

@include('layouts.navbar')

<div class="max-w-3xl mx-auto mt-12 bg-white/70 backdrop-blur-xl
rounded-3xl shadow-xl p-8 border border-[#E8D5C4]">

    <h1 class="text-3xl font-bold text-[#2C1810] mb-6">
        Edit Produk
    </h1>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.katalog.update', $produk->id_produk) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- FOTO --}}
        <div class="mb-6">

            <label class="block text-sm mb-2 text-[#6B5847]">
                Foto Produk
            </label>

            <input type="file" name="foto_produk" id="fotoInput" class="hidden" accept="image/*">

            <div id="uploadBox"
                class="w-full h-56 border-2 border-dashed border-[#D4A574]/50
                rounded-2xl flex items-center justify-center
                cursor-pointer relative overflow-hidden
                hover:bg-[#D4A574]/10 transition">

                {{-- PREVIEW --}}
                <img id="previewImage"
                    src="{{ asset('storage/'.$produk->foto_produk) }}"
                    class="max-h-48 object-contain">

                {{-- TEXT --}}
                <div id="uploadText"
                    class="absolute text-center text-[#6B5847] hidden">
                    <p class="font-medium">Klik untuk ganti foto</p>
                </div>

            </div>

            <button type="button" id="removeImage"
                class="mt-3 px-4 py-2 text-sm rounded-xl
                bg-red-100 text-red-600 hover:bg-red-200 transition">
                Hapus Foto
            </button>

        </div>

        {{-- NAMA --}}
        <div class="mb-4">
        <input type="text" id="nama_produk" name="nama_produk"
        value="{{ old('nama_produk', $produk->nama_produk) }}"
        placeholder="Nama Produk"
        class="w-full p-3 rounded-xl border border-[#D4A574]/50">

        <p id="errorNama" class="text-black text-sm mt-1"></p>
        </div>

        {{-- DESKRIPSI --}}
        <textarea name="deskripsi"
        placeholder="Deskripsi"
        class="w-full mb-4 p-3 rounded-xl border border-[#D4A574]/50">{{ old('deskripsi', $produk->deskripsi) }}</textarea>

        {{-- HARGA --}}
        <div class="mb-4">
    <input type="text" name="harga" id="harga"
    value="{{ old('harga', $produk->harga) }}"
    placeholder="Harga"
    class="w-full p-3 rounded-xl border border-[#D4A574]/50">

    <p id="errorHarga" class="text-black text-sm mt-1"></p>
</div>

        {{-- STOK --}}
        <div class="mb-6">
    <input type="text" name="stok" id="stok"
    value="{{ old('stok', $produk->stok) }}"
    placeholder="Stok"
    class="w-full p-3 rounded-xl border border-[#D4A574]/50">

    <p id="errorStok" class="text-black text-sm mt-1"></p>
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
                Update
            </button>

        </div>

    </form>

</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    const nama = document.getElementById('nama_produk');
    const harga = document.getElementById('harga');
    const stok = document.getElementById('stok');

    const errNama = document.getElementById('errorNama');
    const errHarga = document.getElementById('errorHarga');
    const errStok = document.getElementById('errorStok');

    function clearError(el) {
        el.innerText = '';
    }

    function validateNama() {
        clearError(errNama);

        if (nama.value.trim() === '') {
            errNama.innerText = 'produk harus memiliki nama';
            return false;
        }
        return true;
    }

    function validateNumber(input, errorEl) {
        clearError(errorEl);

        let value = input.value.trim();

        if (value === '') {
            errorEl.innerText = 'harap isi data ini';
            return false;
        }

        if (!/^[0-9]+$/.test(value)) {
            errorEl.innerText = 'harus berupa angka';
            return false;
        }

        return true;
    }

    // realtime validasi
    nama.addEventListener('blur', validateNama);
    harga.addEventListener('blur', () => validateNumber(harga, errHarga));
    stok.addEventListener('blur', () => validateNumber(stok, errStok));

    // submit
    form.addEventListener('submit', function (e) {

        let valid =
            validateNama() &&
            validateNumber(harga, errHarga) &&
            validateNumber(stok, errStok);

        if (!valid) e.preventDefault();
    });

});
</script>
</body>
</html>

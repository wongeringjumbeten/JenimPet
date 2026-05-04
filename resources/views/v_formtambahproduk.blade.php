<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk - JenimPet</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

@include('layouts.navbar')

<div class="max-w-3xl mx-auto mt-12 mb-12 bg-white/70 backdrop-blur-xl
rounded-3xl shadow-xl p-8 border border-[#E8D5C4]">

    <h1 class="text-3xl font-bold text-[#2C1810] mb-6">
        ✏️ Edit Produk
    </h1>

    {{-- ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.katalog.update', $produk->id_produk) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ==================== FOTO PRODUK ==================== --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2 text-[#6B5847]">
                📸 Foto Produk
            </label>

            <input type="file" name="foto_produk" id="fotoInput" class="hidden" accept="image/*">

            <div id="uploadBox"
                class="w-full h-56 border-2 border-dashed border-[#D4A574]/50
                rounded-2xl flex flex-col items-center justify-center
                text-[#6B5847] cursor-pointer
                hover:bg-[#D4A574]/10 transition relative">

                {{-- PREVIEW (default dari database) --}}
                <div class="mt-3 flex justify-center">
                    <img id="previewImage"
                        src="{{ asset('storage/'.$produk->foto_produk) }}"
                        class="w-40 h-40 object-cover rounded-xl shadow-lg border-2 border-white">
                </div>

                {{-- TEXT (hidden kalo ada foto) --}}
                <div id="uploadText" class="text-center transition duration-300 mt-2">
                    <p class="font-medium text-sm">Klik untuk ganti foto</p>
                    <p class="text-xs opacity-70">JPG / PNG max 2MB</p>
                </div>
            </div>

            {{-- BUTTON HAPUS FOTO --}}
            <button type="button" id="removeImage"
                class="mt-3 px-4 py-2 text-sm rounded-xl
                bg-red-100 text-red-600 hover:bg-red-200
                transition">
                🗑️ Hapus Foto
            </button>
        </div>

        {{-- ==================== NAMA PRODUK ==================== --}}
        <div class="mb-4">
            <input type="text" id="nama_produk" name="nama_produk"
                value="{{ old('nama_produk', $produk->nama_produk) }}"
                placeholder="Nama Produk"
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none">
            <p id="errorNama" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- ==================== DESKRIPSI ==================== --}}
        <div class="mb-4">
            <textarea name="deskripsi" id="deskripsi"
                placeholder="Deskripsi Produk"
                rows="4"
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            <p class="text-xs text-[#6B5847] mt-1">* Deskripsi bersifat opsional</p>
        </div>

        {{-- ==================== HARGA ==================== --}}
        <div class="mb-4">
            <input type="text" id="harga" name="harga"
                value="{{ old('harga', $produk->harga) }}"
                placeholder="Harga (Rp)"
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none">
            <p id="errorHarga" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- ==================== STOK ==================== --}}
        <div class="mb-6">
            <input type="text" id="stok" name="stok"
                value="{{ old('stok', $produk->stok) }}"
                placeholder="Stok"
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none">
            <p id="errorStok" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- ==================== BUTTON ==================== --}}
        <div class="flex justify-between items-center pt-4 border-t border-[#E8D5C4]">
            <a href="{{ route('admin.katalog') }}"
                class="px-6 py-2 border border-[#D4A574] rounded-xl text-[#D4A574] hover:bg-[#D4A574] hover:text-white transition">
                ← Batal
            </a>

            <button type="submit"
                id="submitBtn"
                class="px-6 py-2 rounded-xl text-white
                bg-gradient-to-r from-[#D4A574] to-[#B8965A]
                hover:scale-105 hover:shadow-lg transition">
                💾 Update Produk
            </button>
        </div>

    </form>

</div>

{{-- ==================== SCRIPT ==================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==================== UPLOAD FOTO ====================
    const input = document.getElementById('fotoInput');
    const box = document.getElementById('uploadBox');
    const preview = document.getElementById('previewImage');
    const text = document.getElementById('uploadText');
    const removeBtn = document.getElementById('removeImage');

    // Simpan URL lama buat fallback
    let oldImageSrc = preview.src;

    // klik box = buka file
    if (box) {
        box.addEventListener('click', () => {
            input.click();
        });
    }

    // ketika pilih file
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validasi tipe file
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (JPG/PNG)');
            this.value = '';
            return;
        }

        // Validasi ukuran (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            this.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            text.classList.add('hidden');
            removeBtn.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    });

    // hapus foto (pake foto default)
    removeBtn.addEventListener('click', () => {
        input.value = '';
        preview.src = oldImageSrc;
        text.classList.remove('hidden');
        removeBtn.classList.add('hidden');
    });

    // ==================== VALIDASI FORM ====================
    const form = document.querySelector('form');
    const nama = document.getElementById('nama_produk');
    const harga = document.getElementById('harga');
    const stok = document.getElementById('stok');
    const submitBtn = document.getElementById('submitBtn');

    const errNama = document.getElementById('errorNama');
    const errHarga = document.getElementById('errorHarga');
    const errStok = document.getElementById('errorStok');

    function showError(element, message) {
        element.innerText = message;
        element.classList.remove('hidden');
    }

    function hideError(element) {
        element.innerText = '';
        element.classList.add('hidden');
    }

    // Validasi Nama
    function validateNama() {
        let value = nama.value.trim();
        hideError(errNama);

        if (value === '') {
            showError(errNama, '❌ Produk harus memiliki nama');
            return false;
        }

        if (value.length < 3) {
            showError(errNama, '❌ Nama produk minimal 3 karakter');
            return false;
        }

        return true;
    }

    // Validasi Angka (Harga & Stok)
    function validateNumber(input, errorEl, fieldName) {
        let value = input.value.trim();
        hideError(errorEl);

        if (value === '') {
            showError(errorEl, `❌ ${fieldName} harus diisi`);
            return false;
        }

        if (!/^[0-9]+$/.test(value)) {
            showError(errorEl, `❌ ${fieldName} harus berupa angka`);
            return false;
        }

        let numValue = parseInt(value);
        if (fieldName === 'Harga' && numValue <= 0) {
            showError(errorEl, '❌ Harga harus lebih dari 0');
            return false;
        }

        if (fieldName === 'Stok' && numValue < 0) {
            showError(errorEl, '❌ Stok tidak boleh negatif');
            return false;
        }

        return true;
    }

    // Real-time validation (on blur)
    nama.addEventListener('blur', validateNama);
    harga.addEventListener('blur', () => validateNumber(harga, errHarga, 'Harga'));
    stok.addEventListener('blur', () => validateNumber(stok, errStok, 'Stok'));

    // Real-time clear error on input
    nama.addEventListener('input', () => hideError(errNama));
    harga.addEventListener('input', () => hideError(errHarga));
    stok.addEventListener('input', () => hideError(errStok));

    // Submit validation
    form.addEventListener('submit', function (e) {
        let isValid = true;

        if (!validateNama()) isValid = false;
        if (!validateNumber(harga, errHarga, 'Harga')) isValid = false;
        if (!validateNumber(stok, errStok, 'Stok')) isValid = false;

        if (!isValid) {
            e.preventDefault();
            // Scroll ke error pertama
            const firstError = document.querySelector('.text-red-500:not(.hidden)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            // Loading state
            submitBtn.innerHTML = '⏳ Menyimpan...';
            submitBtn.disabled = true;
        }
    });

});
</script>

</body>
</html>

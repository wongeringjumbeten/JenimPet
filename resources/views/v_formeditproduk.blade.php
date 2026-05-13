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
        Edit Produk
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
                Foto Produk
            </label>

            <input type="file" name="foto_produk" id="fotoInput" class="hidden" accept="image/*">

            <div id="uploadBox"
                class="w-full h-56 border-2 border-dashed border-[#D4A574]/50
                rounded-2xl flex flex-col items-center justify-center
                text-[#6B5847] cursor-pointer
                hover:bg-[#D4A574]/10 transition relative">

                <div id="uploadText" class="text-center transition duration-300">
                    <p class="font-medium">Klik untuk ganti foto</p>
                    <p class="text-sm opacity-70">JPG / PNG max 2MB</p>
                </div>

                <div class="mt-3 flex justify-center">
                    <img id="previewImage"
                        src="{{ asset('storage/'.$produk->foto_produk) }}"
                        class="w-32 h-32 object-cover rounded-xl shadow-lg border-2 border-white">
                </div>
            </div>

            <button type="button" id="removeImage"
                class="mt-3 px-4 py-2 text-sm rounded-xl
                bg-red-100 text-red-600 hover:bg-red-200
                transition">
                Hapus Foto
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
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none"
                inputmode="numeric">
            <p id="errorHarga" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- ==================== STOK ==================== --}}
        <div class="mb-6">
            <input type="text" id="stok" name="stok"
                value="{{ old('stok', $produk->stok) }}"
                placeholder="Stok"
                class="w-full p-3 rounded-xl border border-[#D4A574]/50 focus:ring-2 focus:ring-[#D4A574] focus:outline-none"
                inputmode="numeric">
            <p id="errorStok" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- ==================== BUTTON ==================== --}}
        <div class="flex justify-between items-center pt-4 border-t border-[#E8D5C4]">
            <a href="{{ route('admin.katalog') }}"
                class="px-6 py-2 border border-[#D4A574] rounded-xl text-[#D4A574] hover:bg-[#D4A574] hover:text-white transition">
                Batal
            </a>

            <button type="submit" id="submitBtn"
                class="px-6 py-2 rounded-xl text-white
                bg-gradient-to-r from-[#D4A574] to-[#B8965A]
                hover:scale-105 hover:shadow-lg transition">
                Update Produk
            </button>
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==================== UPLOAD FOTO ====================
    const input = document.getElementById('fotoInput');
    const box = document.getElementById('uploadBox');
    const preview = document.getElementById('previewImage');
    const text = document.getElementById('uploadText');
    const removeBtn = document.getElementById('removeImage');

    // Simpan URL lama
    let oldImageSrc = preview.src;

    if (box) {
        box.addEventListener('click', () => {
            input.click();
        });
    }

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (JPG/PNG)');
            this.value = '';
            return;
        }

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
            showError(errNama, 'Produk harus memiliki nama');
            return false;
        }

        if (value.length < 3) {
            showError(errNama, 'Nama produk minimal 3 karakter');
            return false;
        }

        return true;
    }

    // Fungsi untuk mencegah input karakter minus dan non-digit
    function preventNegativeAndNonDigit(event, input) {
        if (event.key === '-' || event.key === 'e' || event.key === 'E') {
            event.preventDefault();
            return false;
        }

        setTimeout(() => {
            let value = input.value;
            value = value.replace(/[^0-9]/g, '');
            if (input.value !== value) {
                input.value = value;
            }
        }, 10);
    }

    // Validasi Angka (Harga & Stok)
    function validateNumber(input, errorEl, fieldName) {
        let value = input.value.trim();
        hideError(errorEl);

        if (value === '') {
            showError(errorEl, `${fieldName} harus diisi`);
            return false;
        }

        if (!/^[0-9]+$/.test(value)) {
            showError(errorEl, `${fieldName} harus berupa angka (0-9)`);
            return false;
        }

        let numValue = parseInt(value, 10);

        if (fieldName === 'Harga') {
            if (numValue <= 0) {
                showError(errorEl, 'Harga harus lebih dari 0');
                return false;
            }
            if (numValue > 999999999) {
                showError(errorEl, 'Harga terlalu besar, maksimal 999.999.999');
                return false;
            }
        }

        if (fieldName === 'Stok') {
            if (numValue < 0) {
                showError(errorEl, 'Stok tidak boleh negatif');
                return false;
            }
            if (numValue > 999999) {
                showError(errorEl, 'Stok terlalu besar, maksimal 999.999');
                return false;
            }
        }

        return true;
    }

    // Event untuk mencegah karakter minus dan non-digit
    harga.addEventListener('keydown', (e) => preventNegativeAndNonDigit(e, harga));
    stok.addEventListener('keydown', (e) => preventNegativeAndNonDigit(e, stok));

    // Filter paste
    harga.addEventListener('paste', (e) => {
        setTimeout(() => {
            let value = harga.value;
            value = value.replace(/[^0-9]/g, '');
            harga.value = value;
            validateNumber(harga, errHarga, 'Harga');
        }, 10);
    });

    stok.addEventListener('paste', (e) => {
        setTimeout(() => {
            let value = stok.value;
            value = value.replace(/[^0-9]/g, '');
            stok.value = value;
            validateNumber(stok, errStok, 'Stok');
        }, 10);
    });

    // Real-time validation
    nama.addEventListener('blur', validateNama);
    harga.addEventListener('blur', () => validateNumber(harga, errHarga, 'Harga'));
    stok.addEventListener('blur', () => validateNumber(stok, errStok, 'Stok'));

    // Real-time clear error on input
    nama.addEventListener('input', () => hideError(errNama));
    harga.addEventListener('input', () => {
        hideError(errHarga);
        let value = harga.value;
        value = value.replace(/[^0-9]/g, '');
        if (harga.value !== value) {
            harga.value = value;
        }
    });
    stok.addEventListener('input', () => {
        hideError(errStok);
        let value = stok.value;
        value = value.replace(/[^0-9]/g, '');
        if (stok.value !== value) {
            stok.value = value;
        }
    });

    // Submit validation
    form.addEventListener('submit', function (e) {
        let isValid = true;

        if (!validateNama()) isValid = false;
        if (!validateNumber(harga, errHarga, 'Harga')) isValid = false;
        if (!validateNumber(stok, errStok, 'Stok')) isValid = false;

        if (!isValid) {
            e.preventDefault();
            const firstError = document.querySelector('.text-red-500:not(.hidden)');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            submitBtn.innerHTML = 'Menyimpan...';
            submitBtn.disabled = true;
        }
    });

});
</script>
</body>
</html>

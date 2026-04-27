<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alamat</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#EFE7DC] min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-[#F7F2EB] border border-[#E0CFC0] p-8 rounded-3xl shadow-xl">

    <h1 class="text-2xl font-bold text-[#2C1810] mb-6 text-center">
        Edit Alamat
    </h1>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('profile.update.alamat') }}" method="POST" id="formAlamat">
        @csrf

        {{-- PROVINSI --}}
<div class="mb-3">
    <input type="text" id="provinsi" name="provinsi"
        placeholder="Provinsi"
        class="w-full p-3 rounded-xl border border-[#E0CFC0]"
        autocomplete="off">

    <p id="errorProv" class="text-red-500 text-sm mt-1 hidden"></p>
</div>

{{-- KOTA --}}
<div class="mb-3">
    <input type="text" id="kota" name="kota"
        placeholder="Kota / Kabupaten"
        class="w-full p-3 rounded-xl border border-[#E0CFC0]"
        autocomplete="off">

    <p id="errorKota" class="text-red-500 text-sm mt-1 hidden"></p>
</div>

{{-- KECAMATAN --}}
<div class="mb-6">
    <input type="text" id="kecamatan" name="kecamatan"
        placeholder="Kecamatan"
        class="w-full p-3 rounded-xl border border-[#E0CFC0]"
        autocomplete="off">

    <p id="errorKecamatan" class="text-red-500 text-sm mt-1 hidden"></p>
</div>

        <div class="flex gap-3">

            <a href="{{ route('profile') }}"
            class="w-full text-center py-3 rounded-xl border border-[#D4A574] text-[#D4A574]">
                Batal
            </a>

            <button type="submit" id="btnSubmit"
            class="w-full py-3 rounded-xl text-white bg-[#D4A574] flex justify-center items-center gap-2">

                <span id="btnText">Simpan</span>

                <svg id="loadingIcon" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>

            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formAlamat');
    const btn = document.getElementById('btnSubmit');
    const text = document.getElementById('btnText');
    const loading = document.getElementById('loadingIcon');

    function validateTextOnly(inputId, errorId, emptyMessage, numberMessage) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);

        input.addEventListener('input', function () {
            if (/[0-9]/.test(input.value)) {
                input.value = '';
                error.innerText = numberMessage;
                error.classList.remove('hidden');
                return;
            }

            if (input.value.trim() === '') {
                error.innerText = emptyMessage;
                error.classList.remove('hidden');
                return;
            }

            error.innerText = '';
            error.classList.add('hidden');
        });
    }

    validateTextOnly('provinsi', 'errorProv', 'Provinsi wajib diisi', 'Provinsi harus berupa huruf');
    validateTextOnly('kota', 'errorKota', 'Kota/Kabupaten wajib diisi', 'Kota/Kabupaten harus berupa huruf');
    validateTextOnly('kecamatan', 'errorKecamatan', 'Kecamatan wajib diisi', 'Kecamatan harus berupa huruf');

    form.addEventListener('submit', function (e) {
        let valid = true;

        const fields = [
            ['provinsi', 'errorProv', 'Provinsi wajib diisi'],
            ['kota', 'errorKota', 'Kota/Kabupaten wajib diisi'],
            ['kecamatan', 'errorKecamatan', 'Kecamatan wajib diisi'],
        ];

        fields.forEach(([inputId, errorId, message]) => {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);

            if (input.value.trim() === '') {
                error.innerText = message;
                error.classList.remove('hidden');
                input.value = '';
                valid = false;
            }

            if (/[0-9]/.test(input.value)) {
                error.innerText = 'Harap isi dengan huruf';
                error.classList.remove('hidden');
                input.value = '';
                valid = false;
            }
        });

        if (!valid) {
            e.preventDefault();
            return;
        }

        btn.disabled = true;
        text.innerText = "Menyimpan...";
        loading.classList.remove('hidden');
    });
});
</script>

</body>
</html>

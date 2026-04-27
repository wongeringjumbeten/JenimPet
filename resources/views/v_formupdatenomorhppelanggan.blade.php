<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nomor HP</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#EFE7DC] min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-[#F7F2EB] border border-[#E0CFC0] p-8 rounded-3xl shadow-xl">

        <h1 class="text-2xl font-bold text-[#2C1810] mb-6 text-center">
            Edit Nomor HP
        </h1>

        {{-- ERROR --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg text-sm">
                {{ $errors->first('no_telp') }}
            </div>
        @endif

        <form action="{{ route('profile.update.hp') }}" method="POST" id="formHP">
            @csrf

            <div>
                <label class="text-sm text-[#6B5847]">Nomor HP</label>

                <input type="text" name="no_telp" id="no_telp"
                    value="{{ $errors->any() ? '' : old('no_telp', auth()->user()->no_telp) }}"
                    placeholder="Masukkan nomor HP..."
                    class="w-full mt-1 px-4 py-3 rounded-xl border border-[#E0CFC0]
                            focus:ring-2 focus:ring-[#D4A574] focus:outline-none">
            </div>

            <div class="flex gap-3 mt-6">

                {{-- BATAL --}}
                <a href="{{ route('profile') }}"
                class="w-full text-center py-3 rounded-xl border border-[#D4A574]
                text-[#D4A574] hover:bg-[#D4A574]/10 transition">
                    Batal
                </a>

                {{-- SUBMIT --}}
                <button type="submit" id="btnSubmit"
                        class="w-full py-3 rounded-xl text-white
                        bg-[#D4A574] hover:bg-[#b98c5f] transition flex justify-center items-center gap-2">

                    <span id="btnText">Simpan</span>

                    {{-- loading --}}
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

    {{-- SCRIPT --}}
    <script>
const inputHp = document.getElementById('no_telp');
const errorHp = document.getElementById('errorHp');

// realtime input
inputHp.addEventListener('input', () => {

    // kalau ada huruf → hapus
    inputHp.value = inputHp.value.replace(/[^0-9]/g, '');

    // validasi panjang
    if (inputHp.value.length > 0 && inputHp.value.length < 10) {
        errorHp.innerText = "Nomor minimal 10 digit";
        errorHp.classList.remove('hidden');
    } else if (inputHp.value.length > 13) {
        errorHp.innerText = "Nomor maksimal 13 digit";
        errorHp.classList.remove('hidden');
    } else {
        errorHp.classList.add('hidden');
    }

});

// validasi saat submit
document.getElementById('formHP').addEventListener('submit', function(e){

    if(inputHp.value === ""){
        e.preventDefault();
        errorHp.innerText = "Nomor HP wajib diisi";
        errorHp.classList.remove('hidden');
        return;
    }

});
</script>
    </script>

</body>
</html>

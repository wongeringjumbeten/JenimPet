<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alamat</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#EFE7DC] min-h-screen flex items-center justify-center">

<div class="w-full max-w-md bg-[#F7F2EB] border border-[#E0CFC0] p-8 rounded-3xl shadow-xl">

    <h1 class="text-2xl font-bold text-[#2C1810] mb-6 text-center">
        Edit Alamat
    </h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('profile.update.alamat') }}" method="POST" id="formAlamat">
        @csrf

        {{-- DETAIL ALAMAT (JALAN, RT/RW, DLL) --}}
        <div class="mb-4">
            <textarea id="detail_alamat" name="detail_alamat"
                rows="3"
                placeholder="Detail alamat (contoh: Jl. Mawar No. 12, RT 01 RW 02)"
                class="w-full p-3 rounded-xl border border-[#E0CFC0] focus:outline-none focus:border-[#D4A574]">{{ old('detail_alamat', $user->detail_alamat ?? '') }}</textarea>
        </div>

        {{-- HIDDEN FIELDS UNTUK KODE WILAYAH --}}
        <input type="hidden" id="provinsi_kode" name="provinsi_kode">
        <input type="hidden" id="kota_kode" name="kota_kode">
        <input type="hidden" id="kecamatan_kode" name="kecamatan_kode">

        {{-- PROVINSI (DROPDOWN) --}}
        <div class="mb-3">
            <select id="provinsi" name="provinsi"
                class="w-full p-3 rounded-xl border border-[#E0CFC0] focus:outline-none focus:border-[#D4A574] bg-white">
                <option value="">-- Pilih Provinsi --</option>
            </select>
            <p id="errorProv" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- KOTA (DROPDOWN) --}}
        <div class="mb-3">
            <select id="kota" name="kota"
                class="w-full p-3 rounded-xl border border-[#E0CFC0] focus:outline-none focus:border-[#D4A574] bg-white" disabled>
                <option value="">-- Pilih Kabupaten/Kota --</option>
            </select>
            <p id="errorKota" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- KECAMATAN (DROPDOWN) --}}
        <div class="mb-6">
            <select id="kecamatan" name="kecamatan"
                class="w-full p-3 rounded-xl border border-[#E0CFC0] focus:outline-none focus:border-[#D4A574] bg-white" disabled>
                <option value="">-- Pilih Kecamatan --</option>
            </select>
            <p id="errorKecamatan" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('profile') }}"
                class="w-full text-center py-3 rounded-xl border border-[#D4A574] text-[#D4A574] hover:bg-[#D4A574]/10 transition">
                Batal
            </a>

            <button type="submit" id="btnSubmit"
                class="w-full py-3 rounded-xl text-white bg-[#D4A574] hover:bg-[#B8965A] transition flex justify-center items-center gap-2">
                <span id="btnText">Simpan</span>
                <svg id="loadingIcon" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // LOAD PROVINSI (pake proxy Laravel)
    $.ajax({
        url: '/api/wilayah/provinces',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#provinsi').empty();
            $('#provinsi').append('<option value="">-- Pilih Provinsi --</option>');
            $.each(response.data, function(key, provinsi) {
                $('#provinsi').append('<option value="' + provinsi.name + '" data-code="' + provinsi.code + '">' + provinsi.name + '</option>');
            });
        },
        error: function(xhr) {
            console.log('Error:', xhr);
            $('#provinsi').append('<option value="">Gagal load provinsi</option>');
        }
    });

    // SAAT PROVINSI BERUBAH -> LOAD KABUPATEN
    $('#provinsi').change(function() {
        var selectedOption = $(this).find('option:selected');
        var provinsiName = selectedOption.val();
        var provinsiCode = selectedOption.data('code');

        // Simpan kode provinsi ke hidden field
        $('#provinsi_kode').val(provinsiCode);

        if (provinsiCode) {
            $('#kota').prop('disabled', false);
            $('#kota').empty();
            $('#kota').append('<option value="">Loading...</option>');
            $('#kecamatan').prop('disabled', true);
            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');

            // Reset hidden fields
            $('#kota_kode').val('');
            $('#kecamatan_kode').val('');

            $.ajax({
                url: '/api/wilayah/regencies/' + provinsiCode,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#kota').empty();
                    $('#kota').append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                    $.each(response.data, function(key, kota) {
                        $('#kota').append('<option value="' + kota.name + '" data-code="' + kota.code + '">' + kota.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#kota').empty();
                    $('#kota').append('<option value="">Gagal load kabupaten</option>');
                }
            });
        } else {
            $('#kota').prop('disabled', true);
            $('#kecamatan').prop('disabled', true);
            $('#kota').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
        }
    });

    // SAAT KOTA BERUBAH -> LOAD KECAMATAN
    $('#kota').change(function() {
        var selectedOption = $(this).find('option:selected');
        var kotaName = selectedOption.val();
        var kotaCode = selectedOption.data('code');

        // Simpan kode kota ke hidden field
        $('#kota_kode').val(kotaCode);

        if (kotaCode && kotaCode !== '') {
            $('#kecamatan').prop('disabled', false);
            $('#kecamatan').empty();
            $('#kecamatan').append('<option value="">Loading...</option>');

            // Reset hidden field kecamatan
            $('#kecamatan_kode').val('');

            $.ajax({
                url: '/api/wilayah/districts/' + kotaCode,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">-- Pilih Kecamatan --</option>');
                    $.each(response.data, function(key, kecamatan) {
                        $('#kecamatan').append('<option value="' + kecamatan.name + '" data-code="' + kecamatan.code + '">' + kecamatan.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option value="">Gagal load kecamatan</option>');
                }
            });
        } else {
            $('#kecamatan').prop('disabled', true);
            $('#kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
        }
    });

    // SAAT KECAMATAN BERUBAH -> SIMPAN KODE KE HIDDEN FIELD
    $('#kecamatan').change(function() {
        var selectedOption = $(this).find('option:selected');
        var kecamatanCode = selectedOption.data('code');
        $('#kecamatan_kode').val(kecamatanCode);
    });

    // VALIDASI SEBELUM SUBMIT
    $('#formAlamat').submit(function(e) {
        var provinsi = $('#provinsi').val();
        var kota = $('#kota').val();
        var kecamatan = $('#kecamatan').val();
        var kecamatanKode = $('#kecamatan_kode').val();

        if (!provinsi || !kota || !kecamatan) {
            e.preventDefault();
            alert('Harap lengkapi semua data wilayah!');
            return false;
        }

        if (!kecamatanKode) {
            e.preventDefault();
            alert('Data wilayah tidak valid, silakan pilih ulang!');
            return false;
        }

        // Animasi loading
        $('#btnSubmit').prop('disabled', true);
        $('#btnText').text('Menyimpan...');
        $('#loadingIcon').removeClass('hidden');
    });
});
</script>

</body>
</html>

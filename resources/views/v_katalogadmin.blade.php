<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Admin</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen font-dm-sans
bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

{{-- NAVBAR --}}
@include('layouts.navbar')

{{-- FLOAT BUTTON --}}
<a href="{{ route('admin.katalog.create') }}"
class="fixed top-24 right-10 z-50
px-5 py-3 rounded-full flex items-center gap-2
bg-gradient-to-r from-[#D4A574] to-[#B8965A]
text-white text-lg font-medium
shadow-xl hover:scale-110 hover:rotate-6
transition duration-300 group">

    <span class="text-2xl group-hover:rotate-180 transition duration-500">+</span>

    <span class="hidden sm:block">Tambah Produk</span>

</a>

{{-- CONTENT --}}
<section class="px-6 md:px-16 py-10">

<h1 class="text-5xl font-bold text-[#2C1810] mb-10">
Katalog Produk
</h1>

{{-- EMPTY STATE --}}
@if($produk->isEmpty())

<div class="text-center py-20 text-[#6B5847] animate-fade-in">

    <div class="text-6xl mb-4 animate-bounce">📦</div>

    <p class="text-xl font-semibold">
        Belum terdapat katalog produk yang tersedia.
    </p>

    <p class="mt-2 opacity-70">
        Silakan tambahkan produk baru dengan menekan tombol tambah (+)
        untuk mulai membangun katalog Anda.
    </p>

</div>

@else

{{-- GRID --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

@foreach($produk as $p)

<div class="relative bg-white/70 backdrop-blur-xl rounded-2xl
shadow-lg border border-[#E8D5C4]
overflow-hidden group hover:shadow-2xl transition">

    {{-- TITIK 3 --}}
    <div class="absolute top-3 right-3 z-20">

        <button onclick="toggleMenu({{ $p->id_produk }})"
            class="text-white text-xl bg-black/40 px-2 rounded-full hover:bg-black/70">
            ⋮
        </button>

        {{-- DROPDOWN --}}
        <div id="menu-{{ $p->id_produk }}"
            class="hidden absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-lg overflow-hidden">

            <a href="{{ route('admin.katalog.edit', $p->id_produk) }}"
                class="block px-4 py-2 text-sm hover:bg-[#F5E6D3]">
                Edit
            </a>

            <button onclick="openDeleteModal({{ $p->id_produk }})"
                class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                Hapus
            </button>

        </div>

    </div>

    {{-- FOTO --}}
    <div class="aspect-square overflow-hidden">
        <img src="{{ asset('storage/'.$p->foto_produk) }}"
            class="w-full h-full object-cover">
    </div>

    {{-- OVERLAY --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

    {{-- TEXT --}}
    <div class="absolute bottom-0 p-4 text-white w-full">
        <h3 class="font-bold text-lg">{{ $p->nama_produk }}</h3>
        <p class="text-sm">{{ $p->deskripsi }}</p>

        <div class="flex justify-between mt-2">
            <span>Rp {{ number_format($p->harga) }}</span>
            <span class="text-xs">Stok {{ $p->stok }}</span>
        </div>
    </div>

</div>

@endforeach

</div>

@endif

</section>

{{-- MODAL TAMBAH --}}
<div id="modal"
class="fixed inset-0 bg-black/40 backdrop-blur-sm
flex items-center justify-center
opacity-0 pointer-events-none transition duration-300 z-50">

<div class="bg-white rounded-3xl p-8 w-full max-w-lg
shadow-2xl animate-scale">

<h2 class="text-xl font-bold mb-4">Tambah Produk</h2>

<form action="{{ route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- FOTO --}}
<div class="mb-4">
<label class="text-sm">Foto Produk</label>

<input type="file" name="foto_produk" id="foto"
class="w-full mt-2">

<img id="preview" class="mt-3 rounded-xl hidden">
</div>

{{-- NAMA --}}
<input type="text" name="nama_produk" placeholder="Nama Produk"
class="w-full mb-3 p-3 border rounded-xl">

{{-- DESKRIPSI --}}
<textarea name="deskripsi" placeholder="Deskripsi"
class="w-full mb-3 p-3 border rounded-xl"></textarea>

{{-- HARGA --}}
<input type="number" name="harga" placeholder="Harga"
class="w-full mb-3 p-3 border rounded-xl">

{{-- STOK --}}
<input type="number" name="stok" placeholder="Stok"
class="w-full mb-3 p-3 border rounded-xl">

<div class="flex justify-between mt-4">

<button type="button" id="closeModal"
class="px-4 py-2 border rounded-xl">
Batal
</button>

<button type="submit"
class="px-4 py-2 bg-[#D4A574] text-white rounded-xl">
Simpan
</button>

</div>

</form>

</div>
</div>

<div id="deleteModal"
class="fixed inset-0 z-[999] flex items-center justify-center
bg-black/30 backdrop-blur-sm
opacity-0 pointer-events-none transition duration-300">

    <div id="deleteBox"
    class="bg-white/90 backdrop-blur-xl
    p-6 rounded-2xl text-center shadow-2xl w-80
    scale-90 opacity-0 transition duration-300">

        <p class="mb-4 text-[#2C1810] font-medium">
            Yakin ingin menghapus katalog ini?
        </p>

        <div class="flex justify-center gap-4">

            <button onclick="closeDeleteModal()"
            class="px-4 py-2 bg-gray-200 rounded-lg hover:scale-105 transition">
                Batal
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:scale-105 transition">
                    Hapus
                </button>
            </form>

        </div>

    </div>
</div>

{{-- SCRIPT --}}
<script>

const modal = document.getElementById('modal');
const openBtn = document.getElementById('openModal');
const closeBtn = document.getElementById('closeModal');

openBtn.onclick = () => {
    modal.classList.remove('opacity-0','pointer-events-none');
}

closeBtn.onclick = () => {
    modal.classList.add('opacity-0','pointer-events-none');
}

window.onclick = (e) => {
    if(e.target === modal){
        modal.classList.add('opacity-0','pointer-events-none');
    }
}

// PREVIEW FOTO
document.getElementById('foto').addEventListener('change', function(e){
    const file = e.target.files[0];
    const preview = document.getElementById('preview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
}

function toggleMenu(id) {
    const menu = document.getElementById('menu-' + id);
    menu.classList.toggle('hidden');
}

function openDeleteModal(id) {
    document.getElementById('deleteModal').classList.remove('hidden');

    const form = document.getElementById('deleteForm');
    form.action = `/admin/katalog/${id}`;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// klik luar nutup dropdown
document.addEventListener('click', function(e){
    document.querySelectorAll('[id^="menu-"]').forEach(menu => {
        if (!menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
});
});
// PREVIEW FOTO
document.getElementById('foto').addEventListener('change', function(e){
    const file = e.target.files[0];
    const preview = document.getElementById('preview');

    if(file){
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});


// =======================
// DROPDOWN TITIK 3
// =======================
function toggleMenu(id) {
    const menu = document.getElementById('menu-' + id);
    menu.classList.toggle('hidden');
}


// =======================
// DELETE MODAL
// =======================
function openDeleteModal(id) {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');

    modal.classList.remove('opacity-0','pointer-events-none');

    setTimeout(() => {
        box.classList.remove('scale-90','opacity-0');
        box.classList.add('scale-100','opacity-100');
    }, 10);

    document.getElementById('deleteForm').action = `/admin/katalog/${id}`;
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');

    box.classList.add('scale-90','opacity-0');

    setTimeout(() => {
        modal.classList.add('opacity-0','pointer-events-none');
    }, 200);
}


// =======================
// CLICK OUTSIDE
// =======================
document.addEventListener('click', function(e){

    document.querySelectorAll('[id^="menu-"]').forEach(menu => {

        if (!menu.contains(e.target) && !e.target.closest('button')) {
            menu.classList.add('hidden');
        }

    });

});

</script>

</body>
</html>

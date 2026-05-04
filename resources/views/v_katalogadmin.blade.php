<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog Admin - JenimPet</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen font-dm-sans bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A]">

{{-- NAVBAR --}}
@include('layouts.navbar')

{{-- FLOAT BUTTON TAMBAH PRODUK --}}
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

    <h1 class="text-5xl font-bold text-[#2C1810] mb-4">
        Katalog Produk
    </h1>
    <p class="text-[#6B5847] mb-10 max-w-2xl">
        Kelola produk yang ditampilkan dan disembunyikan dari katalog pelanggan.
    </p>

    {{-- ==================== SECTION 1: PRODUK DITAMPILKAN ==================== --}}
    <div class="mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-green-500 rounded-full"></div>
            <h2 class="text-2xl font-bold text-[#2C1810]">Produk Ditampilkan</h2>
            <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">
                {{ $produkTampil->count() }} produk
            </span>
        </div>

        @if($produkTampil->isEmpty())
            <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-12 text-center border border-dashed border-[#B8965A]">
                <div class="text-5xl mb-3">📦</div>
                <p class="text-lg font-medium text-[#6B5847]">Belum ada produk yang ditampilkan</p>
                <p class="text-sm text-[#8B7355] mt-1">Tambahkan produk baru untuk mulai menampilkan katalog</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($produkTampil as $p)
                <div class="relative bg-white rounded-2xl shadow-lg border border-[#E8D5C4] overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col h-full">

                    {{-- FOTO --}}
                    <div class="relative aspect-square overflow-hidden bg-[#F5E6D3]">
                        <img src="{{ asset('storage/'.$p->foto_produk) }}"
                            alt="{{ $p->nama_produk }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                        {{-- BADGE AKTIF --}}
                        <div class="absolute top-3 left-3 z-20">
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                        </div>

                        {{-- TITIK 3 MENU --}}
                        <div class="absolute top-3 right-3 z-20">
                            <button onclick="toggleMenu({{ $p->id_produk }})"
                                class="bg-black/50 text-white text-xl w-8 h-8 rounded-full hover:bg-black/70 flex items-center justify-center backdrop-blur-sm">
                                ⋮
                            </button>
                            <div id="menu-{{ $p->id_produk }}"
                                class="hidden absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-30">
                                <a href="{{ route('admin.katalog.edit', $p->id_produk) }}"
                                    class="block px-4 py-2 text-sm text-[#2C1810] hover:bg-[#F5E6D3] transition">
                                    Edit
                                </a>
                                <button onclick="toggleShow({{ $p->id_produk }}, 1)"
                                    class="w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-orange-50 transition">
                                    Jangan Tampilkan
                                </button>
                                <button onclick="openDeleteModal({{ $p->id_produk }})"
                                    class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- INFO PRODUK --}}
                    <div class="p-4 space-y-2 flex-1 flex flex-col bg-white">
                        <h3 class="font-bold text-lg text-[#2C1810] line-clamp-1">
                            {{ $p->nama_produk }}
                        </h3>
                        <p class="text-sm text-[#6B5847] line-clamp-2 leading-relaxed">
                            {{ $p->deskripsi }}
                        </p>
                        <div class="flex justify-between items-center pt-3 mt-auto border-t border-[#E8D5C4]">
                            <span class="text-lg font-bold text-[#D4A574]">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-[#6B5847] bg-[#F5E6D3] px-2 py-1 rounded-full">
                                🐹 Stok: {{ $p->stok }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ==================== SECTION 2: PRODUK TIDAK DITAMPILKAN ==================== --}}
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-orange-500 rounded-full"></div>
            <h2 class="text-2xl font-bold text-[#2C1810]">Produk Tidak Ditampilkan</h2>
            <span class="text-sm text-orange-600 bg-orange-100 px-3 py-1 rounded-full">
                {{ $produkTidakTampil->count() }} produk
            </span>
        </div>

        @if($produkTidakTampil->isEmpty())
            <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-12 text-center border border-dashed border-[#B8965A]">
                <div class="text-5xl mb-3">✅</div>
                <p class="text-lg font-medium text-[#6B5847]">Semua produk sedang ditampilkan</p>
                <p class="text-sm text-[#8B7355] mt-1">Tidak ada produk yang disembunyikan dari katalog pelanggan</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 opacity-80">
                @foreach($produkTidakTampil as $p)
                <div class="relative bg-white/70 backdrop-blur-sm rounded-2xl shadow-lg border border-[#E8D5C4] overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-300 flex flex-col h-full">

                    {{-- FOTO --}}
                    <div class="relative aspect-square overflow-hidden bg-[#F5E6D3] grayscale-[0.3]">
                        <img src="{{ asset('storage/'.$p->foto_produk) }}"
                            alt="{{ $p->nama_produk }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500 opacity-70">

                        {{-- BADGE TIDAK AKTIF --}}
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="bg-black/70 text-white text-sm px-3 py-1 rounded-full backdrop-blur-sm">
                                Tidak Ditampilkan
                            </span>
                        </div>

                        <div class="absolute top-3 left-3 z-20">
                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                                Tersembunyi
                            </span>
                        </div>

                        {{-- TITIK 3 MENU --}}
                        <div class="absolute top-3 right-3 z-20">
                            <button onclick="toggleMenu({{ $p->id_produk }})"
                                class="bg-black/50 text-white text-xl w-8 h-8 rounded-full hover:bg-black/70 flex items-center justify-center backdrop-blur-sm">
                                ⋮
                            </button>
                            <div id="menu-{{ $p->id_produk }}"
                                class="hidden absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg overflow-hidden z-30">
                                <a href="{{ route('admin.katalog.edit', $p->id_produk) }}"
                                    class="block px-4 py-2 text-sm text-[#2C1810] hover:bg-[#F5E6D3] transition">
                                    Edit
                                </a>
                                <button onclick="toggleShow({{ $p->id_produk }}, 0)"
                                    class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 transition">
                                    Tampilkan
                                </button>
                                <button onclick="openDeleteModal({{ $p->id_produk }})"
                                    class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- INFO PRODUK --}}
                    <div class="p-4 space-y-2 flex-1 flex flex-col bg-white/80">
                        <h3 class="font-bold text-lg text-[#2C1810] line-clamp-1">
                            {{ $p->nama_produk }}
                        </h3>
                        <p class="text-sm text-[#6B5847] line-clamp-2 leading-relaxed">
                            {{ $p->deskripsi }}
                        </p>
                        <div class="flex justify-between items-center pt-3 mt-auto border-t border-[#E8D5C4]">
                            <span class="text-lg font-bold text-[#D4A574]">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-[#6B5847] bg-[#F5E6D3] px-2 py-1 rounded-full">
                                🐹 Stok: {{ $p->stok }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</section>

{{-- DELETE MODAL --}}
<div id="deleteModal"
class="fixed inset-0 z-[999] flex items-center justify-center
bg-black/30 backdrop-blur-sm
opacity-0 pointer-events-none transition duration-300">

    <div id="deleteBox"
    class="bg-white/90 backdrop-blur-xl
    p-6 rounded-2xl text-center shadow-2xl w-80
    scale-90 opacity-0 transition duration-300">

        <div class="text-5xl mb-3"></div>
        <p class="mb-4 text-[#2C1810] font-medium">
            Yakin ingin menghapus katalog ini?
        </p>
        <p class="text-sm text-red-500 mb-4">Tindakan ini tidak dapat dibatalkan!</p>

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
// =======================
// DROPDOWN TITIK 3
// =======================
function toggleMenu(id) {
    const menu = document.getElementById('menu-' + id);
    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        if (m.id !== 'menu-' + id) {
            m.classList.add('hidden');
        }
    });
    menu.classList.toggle('hidden');
}

// =======================
// TOGGLE TAMPIL / HIDE
// =======================
function toggleShow(id, status) {
    const action = status == 1 ? 'sembunyikan' : 'tampilkan';
    if (!confirm(`Yakin ingin ${action} produk ini ${status == 1 ? 'dari katalog pelanggan' : 'kembali ke katalog pelanggan'}?`)) {
        return;
    }

    fetch(`/admin/katalog/${id}/toggle-show`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ is_deleted: status.toString() })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengubah status produk');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

// =======================
// DELETE MODAL
// =======================
function openDeleteModal(id) {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');

    modal.classList.remove('opacity-0', 'pointer-events-none');

    setTimeout(() => {
        box.classList.remove('scale-90', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);

    document.getElementById('deleteForm').action = `/admin/katalog/${id}`;
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const box = document.getElementById('deleteBox');

    box.classList.add('scale-90', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
    }, 200);
}

// =======================
// CLICK OUTSIDE (tutup dropdown)
// =======================
document.addEventListener('click', function(e) {
    const menus = document.querySelectorAll('[id^="menu-"]');
    menus.forEach(menu => {
        const button = menu.previousElementSibling;
        if (!menu.contains(e.target) && (!button || !button.contains(e.target))) {
            menu.classList.add('hidden');
        }
    });
});
</script>

</body>
</html>

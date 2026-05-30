<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Omset - Admin Panel</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-slide-up {
            animation: fadeSlideUp 0.5s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.4s ease-out forwards;
        }
        .stat-card {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }
        .filter-btn {
            transition: all 0.2s ease;
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #D4A574, #B8965A);
            color: white;
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-[#EADBC8] via-[#D6BFA6] to-[#B8965A] min-h-screen">

@include('layouts.navbar')

<div class="px-6 md:px-16 py-10 animate-fade-slide-up">
    {{-- Header --}}
    <div class="mb-8 relative">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-[#D4A574]/20 rounded-full blur-2xl"></div>
        <h1 class="text-3xl md:text-5xl font-bold text-[#2C1810] mb-2 relative inline-block">
            Laporan Omset
            <div class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-[#D4A574] to-[#B8965A] rounded-full"></div>
        </h1>
        <p class="text-[#6B5847] mt-4">Analisis penjualan dan pesanan toko</p>
    </div>

    {{-- Filter Periode --}}
    <div class="mb-8 flex flex-wrap gap-3 animate-scale-in">
        <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white/50 text-[#6B5847] hover:bg-white/70" data-period="day">
            Hari Ini
        </button>
        <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white/50 text-[#6B5847] hover:bg-white/70" data-period="week">
            Minggu Ini
        </button>
        <button class="filter-btn px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-white/50 text-[#6B5847] hover:bg-white/70" data-period="month">
            Bulan Ini
        </button>
        <button class="filter-btn active px-5 py-2 rounded-full text-sm font-medium transition-all duration-200" data-period="year">
            Tahun Ini
        </button>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in" style="animation-delay: 0.05s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#6B5847]">Total Omset (Pesanan Selesai)</p>
                    <p id="totalOmset" class="text-3xl font-bold text-[#D4A574] mt-1">Rp 0</p>
                </div>
                <div class="w-12 h-12 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#6B5847]">Total Pesanan Selesai</p>
                    <p id="totalPesanan" class="text-3xl font-bold text-[#2C1810] mt-1">0</p>
                </div>
                <div class="w-12 h-12 bg-[#D4A574]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#2C1810]">Grafik Penjualan (Tahun {{ date('Y') }})</h2>
        </div>
        <div class="relative" style="height: 400px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- Produk Terlaris --}}
    <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in" style="animation-delay: 0.2s">
        <h3 class="font-semibold text-xl text-[#2C1810] mb-4">Produk Terlaris</h3>
        <div id="produkTerlarisList" class="space-y-3">
            <div class="animate-pulse flex justify-between items-center p-3">
                <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                <div class="h-4 bg-gray-200 rounded w-20"></div>
            </div>
        </div>
    </div>
</div>

{{-- Detail Transaksi --}}
<div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-[#E8D5C4] p-6 animate-scale-in mt-8" style="animation-delay: 0.25s">
    <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
        <h3 class="font-semibold text-xl text-[#2C1810]">Detail Transaksi</h3>
        <div class="flex gap-3">
            <input type="text" id="searchTransaksi" placeholder="Cari nama atau produk..."
                   class="px-4 py-2 rounded-xl border border-[#D4A574]/50 bg-white/80 text-sm focus:outline-none focus:ring-2 focus:ring-[#D4A574]">
            <select id="filterMetode" class="px-4 py-2 rounded-xl border border-[#D4A574]/50 bg-white/80 text-sm focus:outline-none">
                <option value="">Semua Metode</option>
                <option value="dana">Dana</option>
                <option value="gopay">GoPay</option>
                <option value="shopeepay">ShopeePay</option>
                <option value="bri">Bank BRI</option>
                <option value="mandiri">Bank Mandiri</option>
                <option value="bca">Bank BCA</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-[#D4A574] to-[#B8965A] text-white rounded-xl">
                <tr>
                    <th class="p-3 text-left rounded-l-xl">Nama Pelanggan</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Metode Pembayaran</th>
                    <th class="p-3 text-left">Nama Produk</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-right rounded-r-xl">Total</th>
                </tr>
            </thead>
            <tbody id="transaksiTableBody">
                <tr><td colspan="6" class="text-center py-8 text-[#6B5847]">Loading...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-4 pt-4 border-t border-[#E8D5C4]">
        <div class="text-sm text-[#6B5847]">
            Menampilkan <span id="transaksiCount">0</span> transaksi
        </div>
        <div class="text-lg font-bold text-[#2C1810]">
            Total Pendapatan: <span id="totalPendapatan" class="text-[#D4A574]">Rp 0</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

    let chart;
    let currentPeriod = 'year';

    const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    function loadData(period) {
        fetch(`/admin/laporan/data?period=${period}`)
            .then(res => res.json())
            .then(data => {
                // Update stat cards
                animateValue(document.getElementById('totalOmset'), 0, data.total_omset, 800, true);
                animateValue(document.getElementById('totalPesanan'), 0, data.total_pesanan, 800, false);

                // Update chart
                const monthlyData = [];
                for (let i = 1; i <= 12; i++) {
                    monthlyData.push(data.monthly_data[i] || 0);
                }

                if (chart) {
                    chart.data.datasets[0].data = monthlyData;
                    chart.update();
                } else {
                    const ctx = document.getElementById('salesChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: bulanLabels,
                            datasets: [{
                                label: 'Omset (Rp)',
                                data: monthlyData,
                                borderColor: '#D4A574',
                                backgroundColor: 'rgba(212, 165, 116, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#D4A574',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Update produk terlaris
                const produkList = document.getElementById('produkTerlarisList');
                if (data.produk_terlaris.length === 0) {
                    produkList.innerHTML = '<div class="text-center text-[#6B5847] py-6">Belum ada data produk terjual</div>';
                } else {
                    produkList.innerHTML = data.produk_terlaris.map(item => `
                        <div class="flex justify-between items-center p-3 hover:bg-[#F5E6D3]/30 rounded-lg transition">
                            <span class="text-[#2C1810] font-medium">${item.produk?.nama_produk ?? 'Produk tidak ditemukan'}</span>
                            <span class="font-semibold text-[#D4A574]">${item.total_terjual} unit</span>
                        </div>
                    `).join('');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                document.getElementById('produkTerlarisList').innerHTML = '<div class="text-center text-red-500 py-6">Gagal memuat data</div>';
            });

            // Update tabel transaksi
fetch(`/admin/laporan/transaksi?period=${period}`)
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('transaksiTableBody');
        const searchInput = document.getElementById('searchTransaksi');
        const filterMetode = document.getElementById('filterMetode');

        let transaksiData = data.transaksi;

        function renderTable() {
            const search = searchInput?.value.toLowerCase() || '';
            const metode = filterMetode?.value || '';

            let filtered = transaksiData;
            if (search) {
                filtered = filtered.filter(t =>
                    t.nama_pelanggan.toLowerCase().includes(search) ||
                    t.nama_produk.toLowerCase().includes(search)
                );
            }
            if (metode) {
                filtered = filtered.filter(t => t.metode_pembayaran === metode);
            }

            const totalPendapatan = filtered.reduce((sum, t) => sum + t.total, 0);
            document.getElementById('totalPendapatan').innerText = 'Rp ' + totalPendapatan.toLocaleString('id-ID');
            document.getElementById('transaksiCount').innerText = filtered.length;

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-[#6B5847]">Tidak ada transaksi</td></tr>';
                return;
            }

            tbody.innerHTML = filtered.map(t => `
                <tr class="border-b border-[#E8D5C4] hover:bg-[#F5E6D3]/30 transition">
                    <td class="p-3 font-medium text-[#2C1810]">${escapeHtml(t.nama_pelanggan)}</td>
                    <td class="p-3 text-sm text-[#6B5847]">${t.tanggal}</td>
                    <td class="p-3 text-sm">${t.metode_pembayaran_label}</td>
                    <td class="p-3 text-sm text-[#2C1810]">${escapeHtml(t.nama_produk)}</td>
                    <td class="p-3 text-center text-sm">${t.jumlah}x</td>
                    <td class="p-3 text-right font-semibold text-[#D4A574]">Rp ${t.total.toLocaleString('id-ID')}</td>
                </tr>
            `).join('');
        }

        renderTable();
        if (searchInput) searchInput.addEventListener('input', renderTable);
        if (filterMetode) filterMetode.addEventListener('change', renderTable);
    })
    .catch(err => {
        console.error('Error loading transaksi:', err);
        document.getElementById('transaksiTableBody').innerHTML = '<tr><td colspan="6" class="text-center py-8 text-red-500">Gagal memuat data</td></tr>';
    });
    }

    function animateValue(element, start, end, duration, isRupiah = false) {
        if (!element) return;
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            if (isRupiah) {
                element.innerHTML = 'Rp ' + value.toLocaleString('id-ID');
            } else {
                element.innerHTML = value.toLocaleString('id-ID');
            }
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentPeriod = this.dataset.period;
            loadData(currentPeriod);
        });
    });

    // Load initial data
    loadData('year');
});
</script>

</body>
</html>

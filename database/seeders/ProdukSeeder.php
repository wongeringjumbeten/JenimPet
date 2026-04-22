<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produkData = [
            [
                'nama_produk' => 'Syrian Hamster',
                'deskripsi' => 'Syrian hamster (Mesocricetus auratus) adalah spesies hamster terbesar dan paling populer sebagai hewan peliharaan, berukuran 12–18 cm dengan umur 2–3 tahun. Mereka dikenal jinak, mudah dijinakkan, soliter (harus hidup sendiri), teritorial, dan nokturnal. Hamster ini juga dikenal sebagai hamster emas atau teddy bear hamster.',
                'harga' => 100000,
                'stok' => 50,
                'foto_produk' => null, // Nanti diisi path foto
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Winter White',
                'deskripsi' => 'Hamster Winter White (Phodopus sungorus) adalah jenis hamster kerdil Siberia yang terkenal jinak, berukuran kecil (8–10 cm), dan memiliki keunikan bulu yang dapat berubah warna menjadi lebih putih/terang saat musim dingin (atau suhu dingin) sebagai kamuflase. Mereka ramah, vokal, dan cocok untuk pemula.',
                'harga' => 50000,
                'stok' => 50,
                'foto_produk' => null, // Nanti diisi path foto
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Roborovski',
                'deskripsi' => 'Hamster Roborovski (Phodopus roborovskii) adalah jenis hamster kerdil terkecil, berukuran sekitar 5 cm, dan dikenal karena kecepatan dan kelincahannya. Mereka memiliki bulu coklat keemasan dengan perut putih, dan meskipun jinak, mereka sangat aktif dan sulit dijinakkan, sehingga lebih cocok untuk pengamat daripada interaksi langsung.',
                'harga' => 75000,
                'stok' => 50,
                'foto_produk' => null, // Nanti diisi path foto
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Campbell\'s Dwarf',
                'deskripsi' => 'Hamster Campbell\'s Dwarf (Phodopus campbelli) adalah jenis hamster kerdil yang berukuran sekitar 8 hingga 10 cm, dengan bulu abu-abu kecoklatan dan perut putih. Mereka dikenal agresif terhadap sesama, sehingga harus dipelihara sendiri atau dengan pasangan yang sudah terbiasa. Mereka aktif, vokal, dan memiliki umur sekitar 1,5 hingga 2 tahun.',
                'harga' => 60000,
                'stok' => 50,
                'foto_produk' => null, // Nanti diisi path foto
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert data ke tabel produk
        DB::table('produk')->insert($produkData);

        // Optional: Tampilkan pesan sukses di terminal
        $this->command->info('✅ Produk berhasil di-seed: Syrian Hamster & Winter White!');
    }
}

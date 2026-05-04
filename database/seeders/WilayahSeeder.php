<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\m_provinsi;
use App\Models\m_kabupaten;
use App\Models\m_kecamatan;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Mengambil data provinsi...');

        // 1. Ambil data provinsi dari API
        $response = Http::get('https://wilayah.id/api/provinces.json');
        $provinces = $response->json()['data'];

        foreach ($provinces as $prov) {
            $provinsi = m_provinsi::updateOrCreate(
                ['kode' => $prov['code']],  // cari berdasarkan kode
                ['nama_provinsi' => $prov['name']]
            );

            $this->command->info("Provinsi: {$prov['name']}");

            // 2. Ambil data kabupaten per provinsi
            $responseKab = Http::get("https://wilayah.id/api/regencies/{$prov['code']}.json");
            $regencies = $responseKab->json()['data'] ?? [];

            foreach ($regencies as $kab) {
                $kabupaten = m_kabupaten::updateOrCreate(
                    ['kode' => $kab['code']],
                    [
                        'nama_kabupaten' => $kab['name'],
                        'provinsi_id' => $provinsi->id_provinsi  // pake ID auto-increment
                    ]
                );

                // 3. Ambil data kecamatan per kabupaten
                $responseKec = Http::get("https://wilayah.id/api/districts/{$kab['code']}.json");
                $districts = $responseKec->json()['data'] ?? [];

                foreach ($districts as $kec) {
                    m_kecamatan::updateOrCreate(
                        ['kode' => $kec['code']],
                        [
                            'nama_kecamatan' => $kec['name'],
                            'kabupaten_id' => $kabupaten->id_kabupaten  // pake ID auto-increment
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Data wilayah berhasil diimport!');
    }
}

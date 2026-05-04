<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class c_apiwilayah extends Controller
{
    public function getProvinces()
    {
        try {
            $response = Http::get('https://wilayah.id/api/provinces.json');
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data provinsi'], 500);
        }
    }

    public function getRegencies($provinceCode)
    {
        try {
            $response = Http::get("https://wilayah.id/api/regencies/{$provinceCode}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data kabupaten'], 500);
        }
    }

    public function getDistricts($regencyCode)
    {
        try {
            $response = Http::get("https://wilayah.id/api/districts/{$regencyCode}.json");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data kecamatan'], 500);
        }
    }
}

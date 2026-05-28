<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = env('RAJAONGKIR_BASE_URL');
    }

    public function searchDestination($search)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/domestic-destination', [
            'search' => $search,
            'limit' => 10
        ]);

        return $response->json();
    }

    public function calculateCost($origin, $destination, $weight, $courier)
{
    $response = Http::withHeaders([
        'key' => $this->apiKey
    ])->asForm()->post($this->baseUrl . '/calculate/domestic-cost', [
        'origin' => $origin,
        'destination' => $destination,
        'weight' => $weight,
        'courier' => $courier
    ]);

    return $response->json();
}
}

<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

class c_apiongkir extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    // Cari kota tujuan berdasarkan keyword
    public function searchDestination(Request $request)
    {
        $search = $request->get('q');
        $result = $this->rajaOngkir->searchDestination($search);

        // Format ulang agar mudah dipakai di frontend
        $options = [];
        foreach ($result['data'] as $item) {
            $options[] = [
                'id' => $item['id'],
                'text' => $item['label']
            ];
        }

        return response()->json($options);
    }

    // Hitung ongkir
    public function calculateCost(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|in:jne,tiki,pos'
        ]);

        $result = $this->rajaOngkir->calculateCost(
            $request->origin,
            $request->destination,
            $request->weight,
            $request->courier
        );

        // Format ulang hasil ongkir
        $costs = [];
        if (isset($result['data']['results'][0]['costs'])) {
            foreach ($result['data']['results'][0]['costs'] as $cost) {
                $costs[] = [
                    'service' => $cost['service'],
                    'description' => $cost['description'],
                    'cost' => $cost['cost'][0]['value'],
                    'etd' => $cost['cost'][0]['etd']
                ];
            }
        }

        return response()->json($costs);
    }
}

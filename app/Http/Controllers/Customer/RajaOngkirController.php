<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function searchDestination(Request $request)
    {
        $search = $request->input('search', '');

        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
            'search' => $search,
            'limit' => 50,
            'offset' => 0
        ]);

        return response()->json($response['data']);
    }



    public function cekOngkir(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|numeric',
            'weight' => 'required|numeric',
            'courier' => 'required|string',
        ]);


        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
        ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => 26041, // ID toko kamu
            'destination' => $validated['destination_id'],
            'weight' => $validated['weight'],
            'courier' => $validated['courier'],
        ]);

        return response()->json($response['data']);
    }
}

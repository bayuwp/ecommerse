<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\RajaOngkirService;

class RajaOngkirController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function create()
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = [];
        $errorMessage = null;

        if ($response->successful()) {
            $cities = $response->json()['rajaongkir']['results'];
        } else {
            $errorMessage = "Terjadi kesalahan dalam mengambil data kota.";
        }

        return view('produk.create', compact('cities', 'errorMessage'));
    }

    public function getProvinces()
    {
        $client = new Client();
        $response = $client->get('https://api.rajaongkir.com/starter/province', [
            'headers' => [
                'key' => env('RAJAONGKIR_API_KEY')
            ]
        ]);

        return response()->json(json_decode($response->getBody()->getContents(), true));
    }

    public function getCities($provinceId)
    {
        try {
            $response = $this->rajaOngkirService->getCitiesByProvince($provinceId);

            \Log::info('API Response:', $response);

            if (isset($response['rajaongkir']['results']) && count($response['rajaongkir']['results']) > 0) {
                return response()->json([
                    'rajaongkir' => [
                        'results' => $response['rajaongkir']['results']
                    ]
                ]);
            } else {
                return response()->json(['error' => 'Data kota tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string',
        ]);

        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $request->input('origin'),
                'destination' => $request->input('destination'),
                'weight' => $request->input('weight'),
                'courier' => $request->input('courier')
            ]);

            // Potongan kode yang Anda berikan
            if ($response->successful()) {
                $shippingCost = $response->json()['rajaongkir']['results'];
                return response()->json([
                    'status' => 'success',
                    'data' => $shippingCost
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak dapat menghitung ongkir. Cek API key atau data input.',
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Error calculating shipping cost: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


}

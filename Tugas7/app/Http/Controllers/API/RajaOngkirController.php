<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    // Ambil daftar kota
    public function create()
    {
        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/city');

            if ($response->successful()) {
                $cities = $response->json('rajaongkir.results'); // Lebih spesifik
                return view('produk.create', compact('cities'));
            } else {
                throw new \Exception('Gagal mengambil data kota dari API.');
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching cities: ' . $e->getMessage());
            return view('produk.create')->with('errorMessage', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Ambil daftar provinsi
    public function getProvinces()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.rajaongkir.com/starter/province', [
                'headers' => [
                    'key' => env('RAJAONGKIR_API_KEY')
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data['rajaongkir']['results'])) {
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Data provinsi tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // Ambil daftar kota berdasarkan provinsi
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->get('https://api.rajaongkir.com/starter/city', [
                'province' => $provinceId
            ]);

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                return response()->json([
                    'status' => 'success',
                    'results' => $response['rajaongkir']['results']
                ]);
            } else {
                return response()->json(['error' => 'Data kota tidak ditemukan.'], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // Hitung ongkos kirim
    public function calculateShipping(Request $request)
    {
        $validatedData = $request->validate([
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'weight' => 'required|integer|min:1',
            'courier' => 'required|string',
        ]);

        try {
            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])->post('https://api.rajaongkir.com/starter/cost', $validatedData);

            if ($response->successful() && isset($response['rajaongkir']['results'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => $response['rajaongkir']['results']
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak dapat menghitung ongkir. Cek data input atau API key.',
                ], $response->status());
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

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.api_key');
        $this->baseUrl = config('services.rajaongkir.base_url');
    }

    /**
     * Ambil daftar provinsi dari API RajaOngkir
     */
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}province");

            if ($response->successful()) {
                return $response->json();
            }

            // Log jika respons gagal
            Log::error('Error fetching provinces', ['response' => $response->body()]);
            return ['error' => 'Gagal mengambil data provinsi.'];
        } catch (\Exception $e) {
            Log::error('Exception fetching provinces', ['error' => $e->getMessage()]);
            return ['error' => 'Terjadi kesalahan saat mengambil data provinsi.'];
        }
    }

    /**
     * Ambil daftar kota berdasarkan id provinsi dari API RajaOngkir
     */
    public function getCitiesByProvince($provinceId)
{
    $response = Http::withHeaders([
        'key' => env('RAJAONGKIR_API_KEY')
    ])->get("https://api.rajaongkir.com/starter/city?province={$provinceId}");

    if ($response->successful()) {
        return $response->json();
    }

    throw new \Exception('Gagal mengambil data kota: ' . $response->body());
}


    /**
     * Hitung ongkir dari API RajaOngkir
     */
    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->post("{$this->baseUrl}cost", [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error fetching shipping cost', ['response' => $response->body()]);
            return ['error' => 'Gagal mengambil data ongkir.'];
        } catch (\Exception $e) {
            Log::error('Exception fetching shipping cost', ['error' => $e->getMessage()]);
            return ['error' => 'Terjadi kesalahan saat menghitung ongkir.'];
        }
    }
}


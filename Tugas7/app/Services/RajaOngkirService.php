<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;

        public function __construct()
        {
            $this->apiKey = config('services.rajaongkir.api_key');
            $this->baseUrl = config('services.rajaongkir.base_url');
        }

        public function getProvinces()
        {
            try {
                $cache = Cache::get('raja_ongkir_provinces');
                if (!$cache) {
                    $response = Http::withHeaders([
                        'key' => $this->apiKey,
                    ])->get("{$this->baseUrl}province");

                    if ($response->successful()) {
                        $json = $response->json();
                        Cache::put('raja_ongkir_provinces', json_encode($json), now()->addDay());
                        return $json;
                    }
                }

                return json_decode($cache);

                Log::error('Error fetching provinces', ['response' => $response->body()]);
                return ['error' => 'Gagal mengambil data provinsi.'];
            } catch (\Exception $e) {
                Log::error('Exception fetching provinces', ['error' => $e->getMessage()]);
                return ['error' => 'Terjadi kesalahan saat mengambil data provinsi.'];
            }
        }

        public function getCitiesByProvince($provinceId)
        {
            try {
                $cacheKey = 'raja_ongkir_cities_' . $provinceId;

                // Ambil dari cache jika tersedia
                if (Cache::has($cacheKey)) {
                    $cachedData = Cache::get($cacheKey);
                    return $cachedData;
                }

                // Ambil data dari API jika tidak ada di cache
                $response = Http::withHeaders([
                    'key' => env('RAJAONGKIR_API_KEY')
                ])->get(env('RAJAONGKIR_BASE_URL') . 'city', [
                    'province' => $provinceId
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Cache::put($cacheKey, $data, now()->addDay());
                    return $data;
                }

                throw new \Exception('Gagal mengambil data kota: ' . $response->body());
            } catch (\Exception $e) {
                Log::error('Error fetching cities', [
                    'provinceId' => $provinceId,
                    'error' => $e->getMessage()
                ]);

                return ['error' => 'Terjadi kesalahan saat mengambil data kota.'];
            }
        }



        public function getShippingCost($origin, $destination, $weight, $courier)
        {
            try {
                $cacheKey = "shipping_cost_{$origin}_{$destination}_{$weight}_{$courier}";

                $cache = Cache::get($cacheKey);
                if (!$cache) {
                    $response = Http::withHeaders([
                        'key' => $this->apiKey,
                    ])->post("{$this->baseUrl}cost", [
                        'origin' => $origin,
                        'destination' => $destination,
                        'weight' => $weight,
                        'courier' => $courier
                    ]);

                    if ($response->successful()) {
                        $json = $response->json();
                        Cache::put($cacheKey, json_encode($json), now()->addDay());
                        return $json;
                    }

                    throw new \Exception('Gagal mengambil data ongkir: ' . $response->body());
                }

                return json_decode($cache);

            } catch (\Exception $e) {
                Log::error('Exception fetching shipping cost', ['error' => $e->getMessage()]);
                return ['error' => 'Terjadi kesalahan saat menghitung ongkir.'];
            }
        }

}


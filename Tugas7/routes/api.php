<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\PelangganController;
use App\Http\Controllers\API\RajaOngkirController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::apiResource('kategoris', KategoriController::class);
Route::get('produk/total-transaksi', [ProdukController::class, 'totalTransaksi']);
Route::get('kategori/total-produk', [KategoriController::class, 'totalProduk']);
Route::get('pelanggan/total-transaksi', [PelangganController::class, 'totalTransaksi']);

Route::prefix('rajaongkir')->group(function () {
    Route::get('/create', [RajaOngkirController::class, 'create']);
    Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
    Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
    Route::post('/calculate-shipping', [RajaOngkirController::class, 'calculateShipping'])->name('calculateShipping');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

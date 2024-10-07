<?php

use App\Http\Controllers\ParsingDataController;
use app\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');

// Route::get('/products', function () {
//     return view('dashboard.product.index');
// })->name('product.index');

// Route::resource('products', ProductController::class)->only([
//     'index', 'store', 'destory'
// ])->names('produk');

Route::resource('home', App\Http\Controllers\HomeController::class);
Route::resource('products', App\Http\Controllers\ProductController::class);
Route::resource('contact', App\Http\Controllers\ContactController::class);

Route::prefix('admin')->group(function () {
    Route::resource('home', App\Http\Controllers\HomeController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('contact', App\Http\Controllers\ContactController::class);
});

Route::get('/parse-data/{nama_lengkap}/{email}/{jenis_kelamin}',
    [App\Http\Controllers\ParsingDataController::class, 'parseData']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

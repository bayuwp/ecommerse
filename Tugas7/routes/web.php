<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParsingDataController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Models\Kategori;



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
    return view('dashboard.index', ['title' => 'Dasboard']);
})->name('dashboard');

// Route::get('/products', function () {
//     return view('dashboard.product.index');
// })->name('product.index');

Route::resource('products', ProductController::class)->only([
    'index', 'store', 'destroy'
])->names('products');

Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function () {
    Route::resource('products', ProductController::class)->only([
        'index', 'store','destroy'
    ])->names('products');

    Route::redirect('/test', '/dashboard/products');
});

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('produk', [ProductController::class, 'index'])->name('produk.index');
});


// Route::prefix('admin')->middleware(['app'])->group(function () {
//     Route::resource('products', ProductController::class)->only([
//         'index', 'store', 'destroy'
//     ])->names('products');
// });

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

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');


Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');

Route::get('/app', function () {
    return view('layouts.app'); // Ganti dengan tampilan yang sesuai
})->name('app');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Route untuk menampilkan halaman login
// Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/', [LoginController::class, 'authenticate']);

// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', function () {
    Auth::logout(); // Logout user
    return redirect('/login')->with('status', 'You have been logged out.'); // Redirect ke halaman login
})->name('logout');

// Halaman produk dengan proteksi login
Route::middleware(['auth'])->group(function () {
    Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
});

Route::resource('products', ProductController::class);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::resource('produk', ProductController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('transaksi', TransaksiController::class);

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

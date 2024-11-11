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
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\CheckoutController;
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

Route::middleware(['check.auth'])->group(function () {

    // Rute untuk admin
    Route::prefix('admin')->group(function () {
        Route::get('/produk', [ProductController::class, 'index'])->name('admin.produk.index');
        Route::post('/produk', [ProductController::class, 'store'])->name('admin.produk.store');
        Route::get('/produk/{id}', [ProductController::class, 'show'])->name('admin.produk.show');

        Route::get('/kategori', [CategoryController::class, 'index'])->name('admin.kategori.index');
        Route::post('/kategori', [CategoryController::class, 'store'])->name('admin.kategori.store');
        Route::get('/kategori/{id}', [CategoryController::class, 'show'])->name('admin.kategori.show');

        Route::get('/transaksi', [TransactionController::class, 'index'])->name('admin.transaksi.index');
        Route::post('/transaksi', [TransactionController::class, 'store'])->name('admin.transaksi.store');
        Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->name('admin.transaksi.show');
    });
});

Route::post('/checkout/get-token', [CheckoutController::class, 'getToken'])->name('checkout.getToken');
Route::get('/admin/transaksi', [TransactionController::class, 'index'])->name('transaction.page');
Route::post('/checkout/save', [CheckoutController::class, 'save'])->name('checkout.save');
Route::post('/checkout/save', [TransaksiController::class, 'store'])->name('checkout.save');
Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
Route::post('/checkout/save-transaction', [CheckoutController::class, 'saveTransaction'])->name('checkout.saveTransaction');
Route::post('/create-transaction', [TransactionController::class, 'createTransaction']);
Route::delete('/transactions/{orderId}', [TransactionController::class, 'deleteTransaction'])->name('transactions.delete');
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');


// Rute Dashboard
Route::middleware(['check.auth'])->get('/', function () {
    return view('dashboard.index', ['title' => 'Dasboard']);
})->name('dashboard');
Route::get('/', function () {
    return view('dashboard.index', ['title' => 'Dasboard']);
})->name('dashboard')->middleware('checkregistration');;

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

Route::get('/home', function () {
    return redirect()->route('admin.produk.index'); // Mengarahkan ke halaman produk
})->name('home');

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
Route::get('/admin/produk', [ProductController::class, 'index'])->name('admin.produk');
Route::get('/admin/transaksi', [TransactionController::class, 'index'])->name('admin.transaksi');


Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
Route::get('/categories', [KategoriController::class, 'index'])->name('categories.index');

Route::get('/app', function () {
    return view('layouts.app');
})->name('app');

Route::middleware(['check.auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    // Route::post('/', [LoginController::class, 'authenticate']);
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('status', 'You have been logged out.');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
});

Route::resource('products', ProductController::class);



Route::resource('produk', ProductController::class);
Route::resource('categories', KategoriController::class);
Route::resource('transaksi', TransaksiController::class);


Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/categories', [KategoriController::class, 'index'])->name('categories.index');
Route::post('/categories', [KategoriController::class, 'store'])->name('categories.store');
Route::get('categories/{id}/edit', [KategoriController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [KategoriController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [KategoriController::class, 'destroy'])->name('categories.destroy');
Route::resource('categories', KategoriController::class)->except(['show']);

Route::middleware(['check.auth'])->group(function () {
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::post('/admin/pelanggan', [PelangganController::class, 'store'])->name('admin.pelanggan.store');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/admin/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/admin/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('admin.pelanggan.update');
    Route::delete('/admin/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
});


// Route::resource('admin/pelanggan', PelangganController::class);


Route::get('/home', function () {
    return view('layouts.app');
})->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

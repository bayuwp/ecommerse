<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function kategori()
    {
    $categories = Kategori::all(); // Ambil semua kategori
    return view('pages.admin.kategori', compact('categories')); // Kirim variabel ke view
    }


    public function produk()
    {
    //     $products = Produk::all();
    //     $kategoris = Kategori::all();

    // // Mengembalikan view dengan variabel yang tepat
    // return view('pages.admin.produk', [
    //     'products' => $products,
    //     'kategoris' => $kategoris, // Pastikan nama variabel konsisten
    // ]);
    }

    public function transaksi()
    {
        return view('pages.admin.transaksi');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;

class UserControllerProduct extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('home', compact('produk'));
    }

    /**
     * Menampilkan produk berdasarkan kategori
     */
    public function byKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $produk = $kategori->produk;

        // Kirim data kategori dan produk ke view
        return view('user.kategori', compact('kategori', 'produk'));
    }

    /**
     * Menampilkan detail produk
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }


    public function detail($id)
    {
        $produk = Produk::findOrFail($id);
        return view('user.navbar', compact('produk'));
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoriUserController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('pages.cart.index', compact('kategoris'));
    }

    public function show($id)
    {
        // Mengambil kategori berdasarkan ID yang dipilih
        $kategori = Kategori::with('produk')->findOrFail($id);

        // Mengirimkan kategori ke view
        return view('user.kategori', compact('kategori'));
    }
}

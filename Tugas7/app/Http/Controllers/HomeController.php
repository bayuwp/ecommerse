<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Cart;

class HomeController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        $produk = Produk::all();
        $bestSellingProducts = Produk::orderBy('sold', 'desc')->take(5)->get();
        $recommendedProducts = Produk::inRandomOrder()->take(5)->get();

        $cartCount = auth()->check() ? auth()->user()->carts->count() : 0;

        return view('home', [
            'kategoris' => $kategoris,
            'produk' => $produk,
            'bestSellingProducts' => $bestSellingProducts,
            'recommendedProducts' => $recommendedProducts,
            'cartCount' => $cartCount
        ]);

    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function navbar()
    {
        $kategoris = Kategori::all();
        return view('pages.cart.index', compact('kategoris'));
    }

}

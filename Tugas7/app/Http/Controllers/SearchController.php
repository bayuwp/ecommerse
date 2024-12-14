<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3'
        ]);

        $query = $request->input('query');
        $products = Produk::where('nama', 'like', '%' . $query . '%')->get();

        return view('pages.search.index', compact('products', 'query'));
    }
}

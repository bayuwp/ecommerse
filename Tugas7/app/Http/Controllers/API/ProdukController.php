<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $products = Produk::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama_produk', 'like', "%{$search}%")
                            ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(10);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk = Produk::create($validated);

        return response()->json($produk, 201);
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id); // Mengaitkan kategori
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($validated);

        return response()->json($produk);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return response()->json(null, 204);
    }
}

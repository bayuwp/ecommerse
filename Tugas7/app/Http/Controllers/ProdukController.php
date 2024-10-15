<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Http\Requests\Dashboard\Product\UpdateRequest;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Produk::all();
        return view('pages.admin.produk', compact('products'));
    }

    // Menyimpan produk baru
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $produk = Produk::create($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pages.admin.produk_edit', compact('produk'));
    }

    // Memperbarui produk
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $produk = Produk::findOrFail($id);
        $produk->update($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

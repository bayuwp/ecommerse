<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Kategori\StoreRequest;
use App\Http\Requests\Dashboard\Kategori\UpdateRequest;

class KategoriController extends Controller
{
    public function index()
    {
        $categories = Kategori::all();
        return view('pages.admin.kategori', compact('categories'));
    }


    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $kategori = Kategori::create($validated);

        return $kategori
            ? redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!')
            : redirect()->route('categories.index')->with('error', 'Gagal menambahkan kategori.');
    }


    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $categories = Kategori::all();
        return view('pages.admin.kategori', compact('kategori', 'categories'));
    }


    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $kategori = Kategori::findOrFail($id);

        return $kategori->update($validated)
            ? redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!')
            : redirect()->route('categories.index')->with('error', 'Gagal memperbarui kategori.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->delete()) {
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
        } else {
            return redirect()->route('categories.index')->with('error', 'Gagal menghapus kategori.');
        }
    }

    public function showByKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $produk = Produk::where('kategori_id', $id)->get();

        return view('produk.index', compact('kategori', 'produk'));
    }

}


<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Kategori\StoreRequest;
use App\Http\Requests\Dashboard\Kategori\UpdateRequest;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Kategori::all();
        return view('pages.admin.kategori', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        Kategori::create($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('pages.admin.kategori_edit', compact('kategori'));
    }

    // Memperbarui kategori
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}

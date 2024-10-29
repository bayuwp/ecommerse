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

        if ($kategori) {
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
        } else {
            return redirect()->route('categories.index')->with('error', 'Gagal menambahkan kategori.');
        }
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

        if ($kategori->update($validated)) {
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
        } else {
            return redirect()->route('categories.index')->with('error', 'Gagal memperbarui kategori.');
        }
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
}


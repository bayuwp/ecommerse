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
        // Validasi dan ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Cek jika ada file foto_produk yang diunggah
        if ($request->hasFile('foto_produk')) {
            $validated['foto_produk'] = $request->file('foto_produk')->store('images', 'public');
        }

        // Simpan produk baru ke database
        $produk = Produk::create($validated);

        // Redirect dengan pesan sukses
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
        // Validasi dan ambil data yang sudah divalidasi
        $validated = $request->validated();

        // Temukan produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Cek jika ada file foto_produk yang diunggah
        if ($request->hasFile('foto_produk')) {
            // Hapus foto produk lama jika ada
            if ($produk->foto_produk) {
                \Storage::disk('public')->delete($produk->foto_produk);
            }

            // Simpan foto_produk baru
            $validated['foto_produk'] = $request->file('foto_produk')->store('images', 'public');
        }

        // Update produk dengan data yang baru
        $produk->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto produk dari storage jika ada
        if ($produk->foto_produk) {
            \Storage::disk('public')->delete($produk->foto_produk);
        }

        // Hapus produk dari database
        $produk->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

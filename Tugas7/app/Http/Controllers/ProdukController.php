<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Http\Requests\Dashboard\Product\UpdateRequest;
use App\Http\Controllers\RajaOngkirController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        $kategori = Kategori::all();
        return view('pages.admin.produk', compact('products', 'kategori'));
    }

    public function create()
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get('https://api.rajaongkir.com/starter/city');

        if ($response->successful()) {
            $cities = $response->json()['rajaongkir']['results'];
        } else {
            $cities = [];
            $errorMessage = "Terjadi kesalahan dalam mengambil data kota.";
        }

        return view('produk.create', compact('cities', 'errorMessage'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto_produk')) {
            $validated['foto_produk'] = $request->file('foto_produk')->store('images', 'public');
        }

        Produk::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = DB::table('produks')->where('id', '=', $id)->first();
        if (!$produk) {
            abort(404, 'Produk tidak ditemukan.');
        }

        return view('pages.admin.produk_edit', compact('produk'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $produk = Produk::findOrFail($id);

        if ($request->hasFile('foto_produk')) {
            if ($produk->foto_produk) {
                \Storage::disk('public')->delete($produk->foto_produk);
            }

            $validated['foto_produk'] = $request->file('foto_produk')->store('images', 'public');
        }

        $produk->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto_produk) {
            \Storage::disk('public')->delete($produk->foto_produk);
        }

        $produk->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}

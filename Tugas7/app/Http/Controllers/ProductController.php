<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Http\Requests\Dashboard\Product\UpdateRequest;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Response;



class ProductController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $this->setTitle('Products');

    $this->addBreadcrumb('Dashboard', route('dashboard'));
    $this->addBreadcrumb('Products');

    $products = Produk::all();
    $kategoris = Kategori::all();

    // Mengembalikan view dengan variabel yang tepat
    return view('pages.admin.produk', [
        'products' => $products,
        'kategoris' => $kategoris, // Pastikan nama variabel konsisten
    ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
    try {
        $validated = $request->validated();
        dd($request->all());

        $produk = new Produk();
        $produk->kategori_id = $validated['kategori_id'];
        $produk->nama = $validated['nama'];
        $produk->harga = $validated['harga'];
        $produk->deskripsi = $validated['deskripsi'];

        if ($request->hasFile('foto_produk')) {
            $foto = $request->file('foto_produk');
            $fotoPath = $foto->store('uploads', 'public');
            $produk->foto_produk = $fotoPath;
        }

        $produk->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dibuat',
            'data' => $produk
        ])->setStatusCode(Response::HTTP_CREATED);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal membuat produk: ' . $th->getMessage(),
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }


    public function show($id)
    {
        $product = Produk::findOrFail($id);
        return response()->json($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $produk = Produk::findOrFail($id);

            $produk->kategori_id = $validated['kategori_id'];
            $produk->nama = $validated['nama'];
            $produk->harga = $validated['harga'];
            $produk->deskripsi = $validated['deskripsi'];

            if ($request->hasFile('foto_produk')) {
                $foto = $request->file('foto_produk');
                $fotoPath = $foto->store('uploads', 'public');
                $produk->foto_produk = $fotoPath;
            }

            $produk->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil diperbarui',
                'data' => $produk
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui produk: ' . $th->getMessage(),
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            $produk->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus',
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus produk: ' . $th->getMessage(),
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

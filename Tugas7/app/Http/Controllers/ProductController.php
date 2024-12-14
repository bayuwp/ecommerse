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
    // // Jika ada kategori yang dipilih, ambil produk terkait
    // if($request->has('kategori_id')){
    //     $selectedCategory = Kategori::find($request->kategori_id);
    //     $products = $selectedCategory->products; // Pastikan relasi products ada pada model Kategori
    // } else {
    //     $products = collect(); // Jika tidak ada kategori yang dipilih, tampilkan produk kosong
    //     $selectedCategory = null;
    // }
    // Mengembalikan view dengan variabel yang tepat
    return view('pages.admin.produk', [
        'products' => $products,
        'kategoris' => $kategoris,
    ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $produk = new Produk;
            $produk->kategori_id = $validated['kategori_id'];
            $produk->nama = $validated['nama'];
            $produk->harga = $validated['harga'];
            $produk->deskripsi = $validated['deskripsi'];
            $produk->sold = 0;


            if ($request->hasFile('foto_produk')) {
                $foto = $request->file('foto_produk');
                $fotoPath = $foto->store('uploads', 'public');
                $produk->foto_produk = $fotoPath;

            }
            $produk->save();


            session()->flash('success', 'Produk berhasil dibuat');

            return redirect()->route('products.index');
        } catch (\Throwable $th) {

            session()->flash('error', 'Gagal membuat produk: ' . $th->getMessage());
            return redirect()->route('products.index');
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

            if ($produk->delete()) {
                return redirect()->route('products.index')->with('success', 'Kategori berhasil dihapus!');
            } else {
                return redirect()->route('products.index')->with('error', 'Gagal menghapus kategori.');
            }
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('error','gagal menghapus produk');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Produk::where('nama', 'like', "%$query%")->get();
        return view('user.search_results', compact('products'));
    }

    public function byKategori($id)
    {
        $kategori = Kategori::find($id);
        $produk = Produk::where('kategori_id', $id)->get();

        return view('user.kategori', compact('kategori', 'produk'));
    }

}

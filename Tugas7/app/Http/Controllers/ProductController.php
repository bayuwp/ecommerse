<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Product\StoreRequest;
use App\Http\Controllers\DashboardController;
use App\Models\Product;
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

        $this->data['products'] = Product::all();

        // return view('dashboard.product.index', $this->data);
        return view('pages.admin.produk');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            Product::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
            ])->setStatusCode(Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create product',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

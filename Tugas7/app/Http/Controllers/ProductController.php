<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setTitle('Products');

        $this->addBreadcrumb('Dashboard', route('dashboard'));
        $this->addBreadcrumb('Products');

        $this->data['products'] = [
            [
                'name' => 'Sepatu NIke',
                'description' => 'Sepatu nike Air Max 270',
                'price' => '1.600.000',
                'image' => 'Product Image',
            ],
            [
                'name' => 'Sepatu NIke',
                'description' => 'Sepatu nike Air Max 270',
                'price' => '1.600.000',
                'image' => 'Product Image',
            ],
            [
                'name' => 'Sepatu NIke',
                'description' => 'Sepatu nike Air Max 270',
                'price' => '1.600.000',
                'image' => 'Product Image',
            ],

        ];

        return view('dashboard.product.index', $this->data);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function kategori()
    {
        return view('pages.admin.kategori');
    }

    public function produk()
    {
        return view('pages.admin.produk');
    }

    public function transaksi()
    {
        return view('pages.admin.transaksi');
    }
}

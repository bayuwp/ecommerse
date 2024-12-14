<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Auth::user()->carts;
        return view('pages.cart.index', compact('carts'));
    }
    public function addToCart(Request $request)
    {
        $cart = new Cart();
        $cart->user_id = Auth::id();
        $cart->produk_id = $request->produk_id;
        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->route('carts.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart(Request $request)
    {
        $cart = Cart::find($request->cart_id);
        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'selected_products' => 'required|array',
            'selected_products.*' => 'exists:carts,id',
        ]);

        $selectedProducts = Cart::whereIn('id', $request->selected_products)->get();

        $total = $selectedProducts->sum(function ($cart) {
            return $cart->produk->harga * $cart->quantity;
        });

        return view('pages.cart.index', compact('selectedProducts', 'total'));
    }
}

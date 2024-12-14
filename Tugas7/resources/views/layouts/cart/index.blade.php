@extends('user.app')

@section('container')
    <div class="container mt-5">
        <h1>Keranjang Belanja</h1>

        @if (count($cart) > 0)
            <ul class="list-group">
                @foreach ($cart as $productId)
                    <li class="list-group-item">
                        Produk ID: {{ $productId }}
                        <a href="{{ route('cart.remove', $productId) }}" class="btn btn-danger btn-sm float-end">Hapus</a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-primary">Lanjutkan Belanja</a>
                <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
            </div>
        @else
            <p>Keranjang belanja Anda kosong.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Lanjutkan Belanja</a>
        @endif
    </div>
@endsection

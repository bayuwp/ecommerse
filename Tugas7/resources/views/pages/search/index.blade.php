@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Hasil Pencarian: "{{ $query }}"</h1>

        @if($products->isEmpty())
            <p>Tidak ada produk yang ditemukan.</p>
        @else
            <ul class="list-group">
                @foreach ($products as $product)
                    <li class="list-group-item">
                        {{ $product->nama }} - Rp. {{ number_format($product->harga, 0, ',', '.') }}
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary btn-sm float-end">Tambahkan ke Keranjang</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

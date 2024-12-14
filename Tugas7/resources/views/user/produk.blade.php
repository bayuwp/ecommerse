@extends('user.app')

@section('container')
    <div class="container mt-5">
        <h1>Produk Kategori: {{ $kategori->nama }}</h1>

        @if($produk->count() > 0)
            <div class="row">
                @foreach($produk as $item)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset('uploads/' . $item->foto_produk) }}" class="card-img-top" alt="{{ $item->nama }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                                <p class="card-text">Harga: Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <a href="{{ route('produk.show', $item->id) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Tidak ada produk di kategori ini.</p>
        @endif
    </div>
@endsection

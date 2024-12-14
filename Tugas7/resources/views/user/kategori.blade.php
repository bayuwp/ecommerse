@extends('user.app')

@section('container')
    <div class="container my-5">
        <h2 class="text-center mb-4">Kategori: {{ $kategori->nama }}</h2>

        <div class="row mt-1">
            @foreach($kategori->produk as $item)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="card-img-top img-fluid" alt="{{ $item->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                            <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>

                            <!-- Tombol Lihat Detail -->
                            <button class="btn btn-primary" onclick="showDetail({{ $item->id }})">Lihat Detail</button>

                            <!-- Form untuk Menambah Produk ke Keranjang -->
                            <form action="{{ route('carts.add') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                <label for="quantity_{{ $item->id }}" class="form-label">Jumlah:</label>
                                <input type="number" name="quantity" id="quantity_{{ $item->id }}" class="form-control" min="1" value="1" required>
                                <button type="submit" class="btn btn-success mt-2">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

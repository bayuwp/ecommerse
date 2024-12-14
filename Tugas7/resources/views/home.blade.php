@extends('user.app')

@section('container')
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container my-5">
        <div class="row mt-1">
            @foreach($produk as $item)
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


    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Detail akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function showDetail(id) {
            // Mengambil detail produk dengan AJAX
            fetch(`/produk/${id}`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <h3>${data.nama}</h3>
                        <p><strong>Harga:</strong> Rp${data.harga.toLocaleString()}</p>
                        <p>${data.deskripsi}</p>
                        <img src="/storage/${data.foto_produk}" alt="${data.nama}" class="img-fluid">
                    `;
                    document.getElementById('detailContent').innerHTML = content;
                    new bootstrap.Modal(document.getElementById('detailModal')).show();
                })
                .catch(error => console.error(error));
        }
    </script>
@endsection

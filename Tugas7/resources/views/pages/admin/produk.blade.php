@extends('layouts.app')

@section('container')
    <p>Body Products</p>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <div id="product-list" class="row mt-3">
        @foreach($products as $product)
            <div class="card" style="width: 18rem; margin: 10px;">
                <img src="{{ $product->foto_produk }}" class="card-img-top" alt="{{ $product->nama }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->nama }}</h5>
                    <p class="card-text">{{ $product->deskripsi }}</p>
                    <p class="card-text">{{ $product->harga }}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="product-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Kategori -->
                        <label for="kategori" class="col-form-label">Kategori:</label>
                        <select class="form-control" id="kategori" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Nama Produk -->
                        <label for="product-name" class="col-form-label">Nama Produk:</label>
                        <input type="text" class="form-control" id="product-name" name="nama" required>

                        <!-- Harga Produk -->
                        <label for="product-price" class="col-form-label">Harga Produk:</label>
                        <input type="number" class="form-control" id="product-price" name="harga" step="0.01" required>

                        <!-- Foto Produk -->
                        <label for="product-photo" class="col-form-label">Foto Produk:</label>
                        <input type="file" class="form-control" id="product-photo" name="foto_produk" accept="image/jpeg, image/png, image/gif">


                        <!-- Deskripsi Produk -->
                        <label for="product-description" class="col-form-label">Deskripsi Produk:</label>
                        <textarea class="form-control" id="product-description" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function submitForm() {
            let form = document.getElementById('product-form');
            let data = new FormData(form);

    $.ajax({
        url: "{{ route('products.store') }}",
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#exampleModal').modal('hide'); // Menutup modal
            window.location.reload(); // Reload halaman setelah sukses
        },
        error: function(response) {
            console.error(response.responseText); // Menampilkan detail error di console

            // Mengambil pesan kesalahan dari respons, jika ada
            let errorMessage = 'Gagal menyimpan produk';
            if (response.responseJSON && response.responseJSON.message) {
                errorMessage = response.responseJSON.message; // Menggunakan pesan kesalahan dari respons
            }

            alert(errorMessage); // Menampilkan pesan kesalahan kepada pengguna
            }
        });
    }
    </script>
@endpush

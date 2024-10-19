@extends('layouts.app')

@section('container')
    <p>Body Products</p>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="resetForm()">
        Tambah Produk
    </button>

    <div id="product-list" class="row mt-3">
        @foreach($products as $product)
            <div class="card" style="width: 18rem; margin: 10px;">
                <img src="{{ asset('storage/' . $product->foto_produk) }}" class="card-img-top" alt="{{ $product->nama }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->nama }}</h5>
                    <p class="card-text">{{ $product->deskripsi }}</p>
                    <p class="card-text">Rp {{ number_format($product->harga, 2, ',', '.') }}</p>

                    <!-- Button Edit -->
                    <a href="#" class="btn btn-primary" onclick="editProduct({{ $product->toJson() }})" data-toggle="modal" data-target="#exampleModal">Edit</a>

                    <!-- Button Delete -->
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Delete</button>
                    </form>
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
            let actionUrl = form.getAttribute('action') || "{{ route('products.store') }}";

            $.ajax({
                url: actionUrl,
                type: form.getAttribute('method') || 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    window.location.reload();
                },
                error: function(response) {
                    console.error(response.responseText);
                    let errorMessage = 'Gagal menyimpan produk';
                    if (response.responseJSON && response.responseJSON.message) {
                        errorMessage = response.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        }

        function editProduct(product) {
            document.getElementById('exampleModalLabel').innerText = 'Edit Produk';
            document.getElementById('product-form').action = `/products/${product.id}`;
            document.getElementById('product-form').method = 'POST';
            document.getElementById('product-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('kategori').value = product.kategori_id;
            document.getElementById('product-name').value = product.nama;
            document.getElementById('product-price').value = product.harga;
            document.getElementById('product-description').value = product.deskripsi;
            document.getElementById('product-photo').value = ''; // Reset file input
        }

        function resetForm() {
            document.getElementById('exampleModalLabel').innerText = 'Tambah Produk';
            document.getElementById('product-form').action = "{{ route('products.store') }}";
            document.getElementById('product-form').method = 'POST';
            document.querySelector('input[name="_method"]')?.remove();
            document.getElementById('kategori').value = '';
            document.getElementById('product-name').value = '';
            document.getElementById('product-price').value = '';
            document.getElementById('product-description').value = '';
            document.getElementById('product-photo').value = '';
        }

        $('#exampleModal').on('hidden.bs.modal', function () {
            resetForm();
        });
    </script>
@endpush

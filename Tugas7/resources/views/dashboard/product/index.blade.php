@extends('layouts.dashboard')

@section('content')
    <p>Body Products</p>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <div id="product-list" class="row">
        @foreach ($products as $product)
        <div class="col-row-4 m-3">
            <div class="card" style="width: 18rem;">
                {{-- <img src="..." class="card-img-top" alt="Card image cap"> --}}
                <div class="card-body">
                    <h5 class="card-title">{{$product['name']}}</h5>
                    <p class="card-text">{{ $product['description']}}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
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
                <form id="product-form" accept="{{ route('products.store') }}" >
                    @csrf
                    <div class="modal-body">

                        <label for="product-name" class="col-form-label">Nama Produk:</label>
                        <input type="text" class="form-control" id="product-nama" name="name">

                        <label for="product-description" class="col-form-label">Deskripsi:</label>
                        <textarea class="form-control" id="product-descrption" name="description"></textarea>

                        <label for="product-price" class="col-form-label">Harga:</label>
                        <input type="text" class="form-control" id="product-price" name="price">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="bitton" class="btn btn-primary" onclick="submitForm()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function submitForm() {
            // let name = document.getElementById('product-name').value;
            // let description = document.getElementById('product-description').value;
            // let price = document.getElementById('product-price').value;

            // let data = {
            //     name: name,
            //     description: description,
            //     price: price
            // }

            let form = document.getElementById('product-form');
            let data = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('exampleModal').modal('hide');
                    window.location.reload();
                },
                error : function(response) {
                    consol.log(response)
                }
            });
        }
    </script>
@endpush

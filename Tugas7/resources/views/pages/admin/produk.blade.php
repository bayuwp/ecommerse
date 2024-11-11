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
                    <button type="button" class="btn btn-success " data-toggle="modal" data-target="#checkoutModal">
                        Checkout
                    </button>

                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="checkout-form">
                    @csrf
                    <div class="modal-body">
                        <!-- Pilih Provinsi Asal -->
                        <div class="form-group">
                            <label for="origin-province" class="col-form-label">Provinsi Asal:</label>
                            <select class="form-control" id="origin-province" name="origin_province" required>
                                <option value="">Pilih Provinsi Asal</option>
                                @if(isset($provinces) && count($provinces) > 0)
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Data provinsi tidak tersedia.</option>
                                @endif
                            </select>
                        </div>

                        <!-- Pilih Kota Asal -->
                        <div class="form-group">
                            <label for="origin-city" class="col-form-label">Asal Kota:</label>
                            <select class="form-control" id="origin-city" name="origin_city" required disabled>
                                <option value="">Pilih Kota Asal</option>
                            </select>
                        </div>

                        <!-- Pilih Provinsi Tujuan -->
                        <div class="form-group">
                            <label for="destination-province" class="col-form-label">Provinsi Tujuan:</label>
                            <select class="form-control" id="destination-province" name="destination_province" required>
                                <option value="">Pilih Provinsi Tujuan</option>
                                @if(isset($provinces) && count($provinces) > 0)
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Data provinsi tidak tersedia.</option>
                                @endif
                            </select>
                        </div>

                        <!-- Pilih Kota Tujuan -->
                        <div class="form-group">
                            <label for="destination-city" class="col-form-label">Tujuan Kota:</label>
                            <select class="form-control" id="destination-city" name="destination_city" required disabled>
                                <option value="">Pilih Kota Tujuan</option>
                            </select>
                        </div>

                        <!-- Berat Pengiriman -->
                        <div class="form-group">
                            <label for="weight" class="col-form-label">Berat (gram):</label>
                            <input type="number" class="form-control" id="weight" name="weight" required min="1">
                        </div>

                        <!-- Pilih Kurir -->
                        <div class="form-group">
                            <label for="courier" class="col-form-label">Kurir:</label>
                            <select class="form-control" id="courier" name="courier" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="tiki">Tiki</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="submitCheckout()">Hitung Ongkos Kirim</button>
                    </div>
                </form>
                <div id="checkout-result"style="margin-top: 20px;" padding: 7px; ></div>
            </div>
        </div>
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
                <form id="product-form" enctype="multipart/form-data" method="POST" action="{{ route('produk.store') }}">
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
                        <input type="number" class="form-control" id="product-price" name="harga" step="0.01" required min="0">

                        <!-- Foto Produk -->
                        <label for="product-photo" class="col-form-label">Foto Produk:</label>
                        <input type="file" class="form-control" id="product-photo" name="foto_produk" accept="image/jpeg, image/png, image/gif" required>

                        <!-- Deskripsi Produk -->
                        <label for="product-description" class="col-form-label">Deskripsi Produk:</label>
                        <textarea class="form-control" id="product-description" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

$(document).ready(function() {
    function getProvinces() {
        $.ajax({
            url: 'http://localhost:8000/api/rajaongkir/provinces',
            method: 'GET',
            success: function(data) {
                const provinces = data.rajaongkir.results;
                const originProvinceSelect = $('#origin-province');
                const destinationProvinceSelect = $('#destination-province');

                originProvinceSelect.empty();
                destinationProvinceSelect.empty();

                originProvinceSelect.append('<option value="">Pilih Provinsi Asal</option>');
                destinationProvinceSelect.append('<option value="">Pilih Provinsi Tujuan</option>');

                provinces.forEach(function(province) {
                    originProvinceSelect.append('<option value="' + province.province_id + '">' + province.province + '</option>');
                    destinationProvinceSelect.append('<option value="' + province.province_id + '">' + province.province + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching provinces: ' + textStatus, errorThrown);
                alert('Gagal mengambil data provinsi. Silakan coba lagi.');
            }
        });
    }

    $('#checkoutModal').on('show.bs.modal', function() {
        document.getElementById('checkout-result').innerHTML = '';
        document.getElementById('checkout-form').style.display = 'block';
    });

    $('#checkoutModal').on('hidden.bs.modal', function() {
        document.getElementById('checkout-result').innerHTML = '';
        document.getElementById('checkout-form').reset();

        $('#origin-city').val('');
        $('#origin-city').prop('disabled', true);

        $('#destination-city').val('');
        $('#destination-city').prop('disabled', true);
    });

    function getCitiesByProvince(provinceId, selectElement) {
        $.ajax({
            url: 'http://localhost:8000/api/rajaongkir/cities/' + provinceId,
            method: 'GET',
            success: function(data) {
                const cities = data.rajaongkir.results;

                if (cities && cities.length > 0) {
                    selectElement.empty();
                    selectElement.append('<option value="">Pilih Kota</option>');

                    cities.forEach(function(city) {
                        selectElement.append('<option value="' + city.city_id + '">' + city.type + ' ' + city.city_name + '</option>');
                    });

                    selectElement.removeAttr('disabled');
                } else {
                    selectElement.empty().append('<option value="">Tidak ada kota ditemukan.</option>').attr('disabled', 'disabled');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error fetching cities: ' + textStatus, errorThrown);
                alert('Gagal mengambil data kota. Silakan coba lagi.');
            }
        });
    }

    $('#origin-province').on('change', function() {
        let provinceId = $(this).val();

        if (provinceId) {
            getCitiesByProvince(provinceId, $('#origin-city'));
        } else {
            $('#origin-city').empty().append('<option value="">Pilih Kota Asal</option>').attr('disabled', 'disabled');
            $('#destination-city').empty().append('<option value="">Pilih Kota Tujuan</option>').attr('disabled', 'disabled');
        }
    });

    $('#destination-province').on('change', function() {
        let provinceId = $(this).val();

        if (provinceId) {
            getCitiesByProvince(provinceId, $('#destination-city'));
        } else {
            $('#destination-city').empty().append('<option value="">Pilih Kota Tujuan</option>').attr('disabled', 'disabled');
        }
    });

    getProvinces();
});

function submitCheckout() {
    let form = document.getElementById('checkout-form');
    let data = new FormData(form);

    if (!data.get('origin_city') || !data.get('destination_city') || !data.get('weight') || !data.get('courier')) {
        alert('Harap lengkapi semua field sebelum melanjutkan.');
        return;
    }

    $.ajax({
        url: "{{ route('calculateShipping') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            origin: data.get('origin_city'),
            destination: data.get('destination_city'),
            weight: data.get('weight'),
            courier: data.get('courier')
        },
        success: function(response) {
            if (response.status === 'success') {
                document.getElementById('checkout-form').style.display = 'none';
                showResultForm(response.data);
            } else {
                alert('Gagal mendapatkan ongkos kirim: ' + response.message);
            }
        },
        error: function(xhr) {
            console.error(xhr);
            alert('Terjadi kesalahan saat memproses checkout');
        }
    });
}

function showResultForm(data) {
    let container = document.getElementById('checkout-result');
    container.innerHTML = '';

    let formElement = document.createElement('form');
    formElement.setAttribute('id', 'result-form');
    formElement.style.padding = '7px';

    data.forEach((courier, courierIndex) => {
        let courierElement = document.createElement('div');
        courierElement.innerHTML = `<h4>${courier.name}</h4>`;

        courier.costs.forEach((costOption, index) => {
            courierElement.innerHTML += `
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shipping_option" id="shipping_${courierIndex}_${index}" value="${costOption.cost[0].value}">
                    <label class="form-check-label" for="shipping_${courierIndex}_${index}">
                        ${costOption.service} (${costOption.description}) - Harga: Rp ${costOption.cost[0].value} - Estimasi: ${costOption.cost[0].etd} hari
                    </label>
                </div>`;
        });

        formElement.appendChild(courierElement);
    });

    let submitButtonContainer = document.createElement('div');
    submitButtonContainer.classList.add('d-flex', 'justify-content-end', 'mt-2');

    let submitButton = document.createElement('button');
    submitButton.type = 'button';
    submitButton.className = 'btn btn-primary';
    submitButton.innerHTML = 'Lanjutkan ke Pembayaran';
    submitButton.onclick = processPayment;

    submitButtonContainer.appendChild(submitButton);
    formElement.appendChild(submitButtonContainer);
    container.appendChild(formElement);
}

function processPayment() {
    let selectedShippingOption = document.querySelector('input[name="shipping_option"]:checked');
    if (!selectedShippingOption) {
        alert("Pilih opsi pengiriman terlebih dahulu.");
        return;
    }

    let selectedProductId = 12;
    console.log("Selected Product ID:", selectedProductId);

    let data = {
        _token: "{{ csrf_token() }}",
        pelanggan_id: {{ auth()->user()->id }},
        produk_id: selectedProductId,
        shipping_cost: selectedShippingOption.value,
        shipping_service: selectedShippingOption.nextElementSibling ? selectedShippingOption.nextElementSibling.innerText : ''
    };

    $.ajax({
        url: "{{ route('checkout.saveTransaction') }}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: data,
        success: function(response) {
            if (response.status === 'success') {
                window.location.href = "{{ route('transaksi.index') }}";
            } else {
                alert('Gagal menyimpan data transaksi: ' + response.message);
            }
        },
        error: function(xhr) {
            console.error(xhr);
            alert('Terjadi kesalahan saat memproses transaksi. Silakan coba lagi.');
        }
    });
    showResultForm(data);
}

    function submitForm() {
        let form = document.getElementById('product-form');
        let data = new FormData(form);

        $.ajax({
            url: form.getAttribute('action') || "{{ route('products.store') }}",
            type: form.getAttribute('method') || 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function() {
                $('#exampleModal').modal('hide');
                window.location.reload();
            },
            error: function(response) {
                let errorMessage = response.responseJSON?.message || 'Gagal menyimpan produk';
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

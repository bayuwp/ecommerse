@extends('user.app') <!-- Sesuaikan dengan layout Anda -->

@section('container')
<div class="container mt-5">
    <h1>Keranjang Belanja</h1>

    <!-- Menampilkan Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cek Apakah Keranjang Kosong -->
    @if($carts->isEmpty())
        <div class="alert alert-warning">
            Keranjang belanja Anda kosong.
        </div>
    @else
        <!-- Tabel Keranjang -->
        <form action="{{ route('carts.checkout') }}" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Pilih</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $key => $cart)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $cart->produk->nama }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>Rp {{ number_format($cart->produk->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($cart->produk->harga * $cart->quantity, 0, ',', '.') }}</td>
                            <td>
                                <input type="checkbox"
                                        class="transaction-checkbox"
                                        name="selected_products[]"
                                        value="{{ $cart->id }}"
                                        data-amount="{{ $cart->produk->harga * $cart->quantity }}"
                                        {{ in_array($cart->id, old('selected_products', [])) ? 'checked' : '' }}>
                                </td>
                            <td>
                                <form action="{{ route('carts.remove') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total dan Tombol Checkout -->
            <div class="d-flex justify-content-between mt-4">
                <h3>Total: Rp <span id="totalHarga">
                    @php
                        $total = 0;
                        $selectedProducts = old('selected_products', []);
                        foreach($carts as $cart) {
                            if (in_array($cart->id, $selectedProducts)) {
                                $total += $cart->produk->harga * $cart->quantity;
                            }
                        }
                        echo number_format($total, 0, ',', '.');
                    @endphp
                </span></h3>
                <button type="submit" class="btn btn-success">Checkout</button>
            </div>
        </form>
    @endif
</div>

<script>
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.transaction-checkbox:checked').forEach(checkbox => {
            total += parseInt(checkbox.getAttribute('data-amount')) || 0;
        });
        document.getElementById('totalHarga').textContent = total.toLocaleString('id-ID');
    }

    // Panggil fungsi ketika ada perubahan pada checkbox
    document.querySelectorAll('.transaction-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', calculateTotal);
    });
</script>
@endsection

@extends('layouts.app')

@section('container')
<div class="container">
    <h1 class="mt-4">Daftar Transaksi</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif


    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Pilih</th>
                <th>ID Order</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Payment Type</th>
                <th>Gross Amount</th>
                <th>Transaction Time</th>
                <th>Transaction Status</th>
                <th>Metadata</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaktions as $transaksi)
                <tr>
                    <td>
                        <input type="checkbox" class="transaction-checkbox" data-amount="{{ $transaksi->gross_amount }}" aria-label="Pilih transaksi {{ $transaksi->order_id }}">
                    </td>
                    <td>{{ $transaksi->order_id }}</td>
                    <td>{{ $transaksi->pelanggan->nama_lengkap ?? 'N/A' }}</td>
                    <td>{{ $transaksi->produk->nama ?? 'N/A' }}</td>
                    <td>{{ $transaksi->payment_type ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($transaksi->gross_amount, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->transaction_time ? \Carbon\Carbon::parse($transaksi->transaction_time)->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    <td>{{ ucfirst($transaksi->transaction_status) }}</td>
                    <td>
                        <pre class="bg-light p-2">{{ json_encode(json_decode($transaksi->metadata), JSON_PRETTY_PRINT) }}</pre>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="showDetails('{{ $transaksi->order_id }}')">Detail</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTransaction('{{ $transaksi->order_id }}')">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada transaksi ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <h5>Total Harga yang Harus Dibayar: Rp <span id="totalHarga">0</span></h5>
        <button class="btn btn-success btn-lg" onclick="checkout()">Checkout</button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.querySelectorAll('.transaction-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.transaction-checkbox:checked').forEach(checkbox => {
                total += parseInt(checkbox.getAttribute('data-amount')) || 0;
            });
            document.getElementById('totalHarga').textContent = total.toLocaleString('id-ID');
            return total;
        }

    function checkout() {
        let totalHarga = calculateTotal();
        let selectedTransactions = [];

        document.querySelectorAll('.transaction-checkbox:checked').forEach(checkbox => {
            selectedTransactions.push({
                order_id: checkbox.closest('tr').children[1].innerText
            });
        });

        if (selectedTransactions.length === 0) {
            alert("Silakan pilih transaksi yang ingin di-checkout.");
            return;
        }

        let transactionData = {
            transactions: selectedTransactions,
            shipping_cost: totalHarga,
            shipping_service: 'Service Name Here',
        };
        $.ajax({
            url: "{{ route('checkout.saveTransaction') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: transactionData,
            success: function(response) {
                console.log(response);
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    alert("Terjadi kesalahan saat mendapatkan URL pembayaran.");
                }
            },
            error: function(xhr) {
                alert("Terjadi kesalahan saat menyimpan transaksi. Coba lagi nanti.");
            }
        });
    }


        function deleteTransaction(orderId) {
            if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
                $.ajax({
                    url: "{{ route('transactions.delete', ':orderId') }}".replace(':orderId', orderId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.message);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert("Terjadi kesalahan. Coba lagi nanti.");
                    }
                });
            }
        }
    </script>
</div>
@endsection

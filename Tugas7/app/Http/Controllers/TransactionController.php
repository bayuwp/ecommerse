<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pelanggan;
use App\Models\Produk;

class TransactionController extends Controller
{
    public function index()
    {
        $transaktions = Transaksi::all();
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();

        return view('pages.admin.transaksi', compact('transaktions', 'pelanggans', 'produks'));
    }

    public function store(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|string|unique:transaksis,transaction_id',
        'order_id' => 'required|string',
        'payment_type' => 'required|string',
        'shipping_cost' => 'required|integer|min:0',
        'transaction_time' => 'nullable|date',
        'transaction_status' => 'required|string|in:pending,settlement,cancel,expire',
        'metadata' => 'nullable|string',
    ]);

    $transaction = new Transaksi();
    $transaction->transaction_id = $request->transaction_id;
    $transaction->order_id = $request->order_id;
    $transaction->payment_type = $request->payment_type;
    $transaction->gross_amount = $request->shipping_cost;
    $transaction->transaction_time = $request->transaction_time ?? now();
    $transaction->transaction_status = $request->transaction_status;
    $transaction->metadata = $request->metadata;

    $transaction->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Transaksi berhasil disimpan.',
        'data' => $transaction,
    ]);
}


    public function createTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;

        $order_id = 'order-' . time();
        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $request->amount,
        ];

        $snapToken = Snap::getSnapToken($transaction_details);

        return response()->json(['transaction_token' => $snapToken]);
    }

    public function deleteTransaction($orderId)
    {
        $transaction = Transaksi::where('order_id', $orderId)->first();

        if ($transaction) {
            $transaction->delete();

            return response()->json(['message' => 'Transaksi berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }
    }
}

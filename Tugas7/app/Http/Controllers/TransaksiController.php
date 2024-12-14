<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
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
        // Validasi input
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|exists:produk,id',
            'transaction_id' => 'required|integer',
            'order_id' => 'required|string|max:100',
            'payment_type' => 'nullable|string|max:100',
            'gross_amount' => 'required|integer',
            'transaction_time' => 'nullable|date',
            'transaction_status' => 'required|in:pending,settlement,cancel,expire',
            'metadata' => 'nullable|string',
        ]);

        try {
            $transaction = new Transaksi();
            $transaction->transaction_id = $request->transaction_id;
            $transaction->order_id = $request->order_id;
            $transaction->payment_type = $request->payment_type;
            $transaction->gross_amount = $request->gross_amount;
            $transaction->transaction_time = $request->transaction_time ?? now();
            $transaction->transaction_status = $request->transaction_status;
            $transaction->metadata = $request->metadata ? json_encode($request->metadata) : null;
            $transaction->pelanggan_id = $request->pelanggan_id;
            $transaction->produk_id = $request->produk_id;
            $transaction->save();

            return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil dibuat!', 'data' => $transaction]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
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
        $transaction = DB::table('transaksi')->where('order_id', '=', $orderId)->first();

        if ($transaction) {
            DB::table('transaksi')->where('order_id', '=', $orderId)->delete();

            return response()->json(['message' => 'Transaksi berhasil dihapus.'], 200);
        } else {
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Pelanggan;

class CheckoutController extends Controller
{

    public function checkoutForm()
    {
        return view('checkout');
    }

    public function saveTransaction(Request $request)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric',
            'shipping_service' => 'required|string',
        ]);

        try {
            $latestTransaction = Transaksi::latest()->first();
            $customerDetails = Pelanggan::find($latestTransaction->pelanggan_id);

            if (!$latestTransaction) {
                return response()->json(['status' => 'error', 'message' => 'Tidak ada transaksi sebelumnya ditemukan.'], 404);
            }

            $transaction = new Transaksi;
            $transaction->pelanggan_id = $latestTransaction->pelanggan_id;
            $transaction->produk_id = $latestTransaction->produk_id;
            $transaction->transaction_id = rand();
            $transaction->order_id = uniqid('ORD-');
            $transaction->payment_type = 'online';
            $transaction->gross_amount = $request->total_harga + $request->shipping_cost;
            $transaction->transaction_status = 'pending';
            $transaction->metadata = $request->shipping_service;
            $transaction->transaction_time = now();
            $transaction->save();

            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->gross_amount,
                ],
                'customer_details' => [
                    'first_name' => $customerDetails->nama_lengkap,
                    'last_name' => '',
                    'email' => $customerDetails->email,
                    'phone' => $customerDetails->nomer_hp,
                ],
            ];

            $paymentUrl = Snap::createTransaction($params)->redirect_url;

            return response()->json(['status' => 'success', 'redirect_url' => $paymentUrl]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function getToken(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;

        $transaction = Transaksi::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.'], 404);
        }
        $products = Produk::whereIn('id', $transaction->produk_ids)->get();

        $itemDetails = [];
        $total = 0;

        foreach ($products as $product) {
            $total += $product->price;
            $itemDetails[] = [
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => 1,
                'name' => $product->nama,
            ];
        }

        $total += $transaction->shipping_cost;
        $itemDetails[] = [
            'id' => 'courier',
            'price' => $transaction->shipping_cost,
            'quantity' => 1,
            'name' => 'Ongkos Kirim (' . strtoupper($transaction->shipping_service) . ')',
        ];

        $transactionDetails = [
            'order_id' => $transaction->order_id,
            'gross_amount' => $total,
        ];

        $customerDetails = Pelanggan::find($transaction->pelanggan_id);

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $customerDetails->nama_lengkap,
                'email' => $customerDetails->email,
                'phone' => $customerDetails->nomer_hp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($transactionData);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat mendapatkan token: ' . $e->getMessage()], 500);
        }
    }



}

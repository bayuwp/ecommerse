<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    // Memastikan hanya pengguna yang terautentikasi yang dapat mengakses
    public function authorize()
    {
        return true; // Atau gunakan logika sesuai kebutuhan
    }

    // Mendefinisikan aturan validasi
    public function rules()
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ];
    }
}

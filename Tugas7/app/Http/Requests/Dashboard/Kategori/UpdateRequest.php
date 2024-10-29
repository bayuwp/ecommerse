<?php

namespace App\Http\Requests\Dashboard\Kategori;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ganti dengan logika otorisasi jika diperlukan
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoris,id',

        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama kategori harus diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }
}

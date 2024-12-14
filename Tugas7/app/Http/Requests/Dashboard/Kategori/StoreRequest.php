<?php

namespace App\Http\Requests\Dashboard\Kategori;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama kategori harus diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'kategori_id.exists' => 'Kategori induk tidak valid.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }
}

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
            'kategori_id' => 'required|exists:kategories,id',
        ];
    }

    public function authorize()
    {
        return true;
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $pelanggan = Pelanggan::when($search, function ($query, $search) {
            return $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nomor_hp', 'like', "%{$search}%");
        })->paginate(10);

        return response()->json($pelanggan);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
            'email' => 'required|email',
            'nomor_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $pelanggan = Pelanggan::create($validated);

        return response()->json($pelanggan, 201);
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return response()->json($pelanggan);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
            'email' => 'required|email',
            'nomor_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($validated);

        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
    $pelanggans = Pelanggan::all(); // Ambil semua data pelanggan
    return view('pages.pelanggan.pelanggan', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:pelanggan,email',
            'nomer_hp' => 'required',
            'alamat' => 'required',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('images', 'public');
        }

        Pelanggan::create($data);

        return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
{
    $pelanggan = Pelanggan::findOrFail($id);
    return view('pages.pelanggan.edit', compact('pelanggan'));
}



    public function update(Request $request, Pelanggan $pelanggan)
{
    // Validasi input
    $request->validate([
        'nama_lengkap' => 'required',
        'jenis_kelamin' => 'required',
        'email' => 'required|email|unique:pelanggan,email,' . $pelanggan->id,
        'nomer_hp' => 'required',
        'alamat' => 'required',
        'foto_profil' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto_profil')) {

        if ($pelanggan->foto_profil) {
            \Storage::disk('public')->delete($pelanggan->foto_profil);
        }
        $data['foto_profil'] = $request->file('foto_profil')->store('images', 'public');
    }

    $pelanggan->update($data);

    return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil diperbarui.');
}

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
    }
}

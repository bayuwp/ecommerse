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

        // Ambil semua data dari form
        $data = $request->all();

        // Cek apakah ada file yang diunggah
        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $request->file('foto_profil')->store('images', 'public');
        }

        // Simpan data pelanggan ke database
        Pelanggan::create($data);

        // Redirect dengan pesan sukses
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

    // Ambil data dari request
    $data = $request->all();

    // Cek apakah ada file yang diunggah
    if ($request->hasFile('foto_profil')) {
        // Hapus foto profil lama jika ada
        if ($pelanggan->foto_profil) {
            \Storage::disk('public')->delete($pelanggan->foto_profil);
        }
        $data['foto_profil'] = $request->file('foto_profil')->store('images', 'public');
    }

    // Update data pelanggan di database
    $pelanggan->update($data);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil diperbarui.');
}

    public function destroy(Pelanggan $pelanggan)
    {
        // Hapus data pelanggan dari database
        $pelanggan->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
    }
}

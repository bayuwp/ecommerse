@extends('layouts.app')

@section('container')
    <div class="container">
        <h1>Edit Pelanggan</h1>

        <form method="POST" action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="{{ $pelanggan->nama_lengkap }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                    <option value="laki-laki" {{ $pelanggan->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ $pelanggan->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $pelanggan->email }}" required>
            </div>

            <div class="mb-3">
                <label for="nomer_hp" class="form-label">Nomor HP</label>
                <input type="text" name="nomer_hp" class="form-control" id="nomer_hp" value="{{ $pelanggan->nomer_hp }}" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" id="alamat" required>{{ $pelanggan->alamat }}</textarea>
            </div>

            <div class="mb-3">
                <label for="foto_profil" class="form-label">Foto Profil</label>
                <input type="file" name="foto_profil" class="form-control" id="foto_profil" accept="image/*">
                <small>Biarkan kosong jika tidak ingin mengganti foto.</small>
            </div>

            <div class="modal-footer">
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
@endsection

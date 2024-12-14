@extends('layouts.app')

@section('container')
<div class="container">
    <h1>Kelola Kategori</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Kategori -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kategoriModal" onclick="resetForm()">
        Tambah Kategori
    </button>

    <!-- Modal Tambah/Edit Kategori -->
    <div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">
                        @isset($kategori) Edit Kategori @else Tambah Kategori @endisset
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ isset($kategori) ? route('categories.update', $kategori->id) : route('categories.store') }}">
                        @csrf
                        @isset($kategori)
                            @method('PUT')
                        @endisset

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama', $kategori->nama ?? '') }}" required>
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan">{{ old('keterangan', $kategori->keterangan ?? '') }}</textarea>
                            @error('keterangan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">
                                @isset($kategori) Perbarui @else Tambah @endisset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Kategori -->
    <div class="mt-5">
        <h3>Daftar Kategori</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->nama }}</td>
                        <td>{{ $category->keterangan }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


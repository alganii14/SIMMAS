@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Inventaris</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('inventories.update', $inventory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $inventory->nama) }}" required>
                </div>
                <div class="mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="Baik" {{ $inventory->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak" {{ $inventory->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ $inventory->kondisi == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($inventory->gambar)
                    <p>Gambar sebelumnya:</p>
                    <img src="{{ asset('storage/' . $inventory->gambar) }}" width="100">
                    @else
                    <span>Tidak Ada</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </section>
</div>
@endsection

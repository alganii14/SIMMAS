@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Kegiatan</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kegiatan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('kajian.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="judul_kajian">Judul Kegiatan</label>
                            <input type="text" name="judul_kajian" id="judul_kajian" class="form-control" value="{{ old('judul_kajian') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_ustad">Nama Ustad (Opsional)</label>
                            <input type="text" name="nama_ustad" id="nama_ustad" class="form-control" value="{{ old('nama_ustad') }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_kajian">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal_kajian" id="tanggal_kajian" class="form-control" value="{{ old('tanggal_kajian') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi_kajian">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_kajian" id="deskripsi_kajian" class="form-control" rows="4">{{ old('deskripsi_kajian') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="foto_kajian">Foto Kegiatan</label>
                            <input type="file" name="foto_kajian" id="foto_kajian" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="foto_ustad">Foto Ustad</label>
                            <input type="file" name="foto_ustad" id="foto_ustad" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('kajian.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Kegiatan</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('kajian.update', $kajian->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="judul_kajian">Judul Kegiatan</label>
                    <input type="text" class="form-control" id="judul_kajian" name="judul_kajian" value="{{ $kajian->judul_kajian }}" required>
                </div>

                <div class="form-group">
                    <label for="nama_ustad">Nama Ustad</label>
                    <input type="text" class="form-control" id="nama_ustad" name="nama_ustad" value="{{ $kajian->nama_ustad }}" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_kajian">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kajian" name="tanggal_kajian" value="{{ $kajian->tanggal_kajian }}" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kajian">Deskripsi Kegiatan</label>
                    <textarea class="form-control" id="deskripsi_kajian" name="deskripsi_kajian">{{ $kajian->deskripsi_kajian }}</textarea>
                </div>

                <div class="form-group">
                    <label for="foto_kajian">Foto Kegiatan</label>
                    <input type="file" class="form-control" id="foto_kajian" name="foto_kajian">
                    @if($kajian->foto_kajian)
                    <img src="{{ Storage::url($kajian->foto_kajian) }}" width="100">
                    @endif
                </div>

                <div class="form-group">
                    <label for="foto_ustad">Foto Ustad</label>
                    <input type="file" class="form-control" id="foto_ustad" name="foto_ustad">
                    @if($kajian->foto_ustad)
                    <img src="{{ Storage::url($kajian->foto_ustad) }}" width="100">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </section>
</div>
@endsection

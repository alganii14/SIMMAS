@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Donatur</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Donatur</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('donatur.update', $donatur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="no_donatur">No Donatur</label>
                            <input type="text" name="no_donatur" class="form-control" id="no_donatur"
                                value="{{ $donatur->no_donatur }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Donatur</label>
                            <input type="text" name="nama" class="form-control" id="nama" 
                                value="{{ $donatur->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" id="no_telepon"
                                value="{{ $donatur->no_telepon }}" required>
                        </div>
                        <!-- Tambahkan field Email (optional) -->
                        <div class="form-group">
                            <label for="email">Email <small class="text-muted">(opsional)</small></label>
                            <input type="email" name="email" class="form-control" id="email" 
                                value="{{ $donatur->email ?? '' }}">
                        </div>
                        <!-- Tambahkan field Anonim (optional) -->
                        <div class="form-group">
                            <label for="anonim">Status Anonim <small class="text-muted">(opsional)</small></label>
                            <select name="anonim" class="form-control" id="anonim">
                                <option value="tidak" {{ ($donatur->anonim ?? 'tidak') == 'tidak' ? 'selected' : '' }}>
                                    Tidak
                                </option>
                                <option value="ya" {{ ($donatur->anonim ?? 'tidak') == 'ya' ? 'selected' : '' }}>
                                    Ya (Tampilkan sebagai "Sahabat")
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" id="pekerjaan"
                                value="{{ $donatur->pekerjaan }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat"
                                rows="3">{{ $donatur->alamat }}</textarea>
                        </div>
                        <div class="form-group">
    <label for="pesan_doa">Pesan/Doa <small class="text-muted">(opsional)</small></label>
    <textarea name="pesan_doa" class="form-control" id="pesan_doa" 
        rows="3">{{ $donatur->pesan_doa ?? '' }}</textarea>
</div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('donatur.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Tambah Jadwal Sholat</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Jadwal</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('sholat.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_sholat">Nama Sholat</label>
                            <input type="text" name="nama_sholat" class="form-control" id="nama_sholat" placeholder="Masukkan Nama Sholat" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_sholat">Waktu Sholat</label>
                            <input type="time" name="waktu_sholat" class="form-control" id="waktu_sholat" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_iqomah">Waktu Iqomah</label>
                            <input type="time" name="waktu_iqomah" class="form-control" id="waktu_iqomah" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('sholat.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

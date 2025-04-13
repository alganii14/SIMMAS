@extends('layouts.master')

@section('konten')
<div class="container">
    <h1>Edit Data Sholat</h1>
    <form action="{{ route('sholat.update', $sholat) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_sholat" class="form-label">Nama Sholat</label>
            <input type="text" name="nama_sholat" id="nama_sholat" class="form-control" value="{{ $sholat->nama_sholat }}" required>
        </div>
        <div class="mb-3">
            <label for="waktu_sholat" class="form-label">Waktu Sholat</label>
            <input type="time" name="waktu_sholat" id="waktu_sholat" class="form-control" value="{{ $sholat->waktu_sholat }}" required>
        </div>
        <div class="mb-3">
            <label for="waktu_iqomah" class="form-label">Waktu Iqomah</label>
            <input type="time" name="waktu_iqomah" id="waktu_iqomah" class="form-control" value="{{ $sholat->waktu_iqomah }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection

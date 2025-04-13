@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Transaksi Keuangan Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Transaksi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('keuangan-qurban.update', $keuangan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="jenis">Jenis Transaksi</label>
                            <select class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" name="jenis" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Masuk" {{ old('jenis', $keuangan->jenis) === 'Masuk' ? 'selected' : '' }}>
                                    Pemasukan
                                </option>
                                <option value="Keluar" {{ old('jenis', $keuangan->jenis) === 'Keluar' ? 'selected' : '' }}>
                                    Pengeluaran
                                </option>
                            </select>
                            @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                   id="jumlah" name="jumlah" value="{{ old('jumlah', $keuangan->jumlah) }}" required>
                            @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                   id="tanggal" name="tanggal"
                                   value="{{ old('tanggal', $keuangan->tanggal->format('Y-m-d')) }}" required>
                            @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('keuangan-qurban.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Harga Hewan Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Harga Hewan Qurban</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('harga-hewan-qurban.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tahun_hijriah">Tahun Hijriah</label>
                            <input type="number" class="form-control @error('tahun_hijriah') is-invalid @enderror"
                                   id="tahun_hijriah" name="tahun_hijriah" value="{{ old('tahun_hijriah') }}" required>
                            @error('tahun_hijriah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenis_hewan">Jenis Hewan</label>
                            <select class="form-control @error('jenis_hewan') is-invalid @enderror"
                                    id="jenis_hewan" name="jenis_hewan" required>
                                <option value="">Pilih Jenis Hewan</option>
                                <option value="Domba/Kambing">Domba/Kambing</option>
                                <option value="Sapi">Sapi</option>
                            </select>
                            @error('jenis_hewan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                   id="harga" name="harga" value="{{ old('harga') }}" required>
                            @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('harga-hewan-qurban.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Tambah Petugas Qurban</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Petugas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_hijriah">Tahun Hijriah</label>
                            <input type="text" name="tahun_hijriah" id="tahun_hijriah" class="form-control @error('tahun_hijriah') is-invalid @enderror" value="{{ old('tahun_hijriah') }}" required>
                            @error('tahun_hijriah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="Petugas DKM" {{ old('status') == 'Petugas DKM' ? 'selected' : '' }}>Petugas DKM</option>
                                <option value="Warga" {{ old('status') == 'Warga' ? 'selected' : '' }}>Warga</option>
                                <option value="Penyembelih" {{ old('status') == 'Penyembelih' ? 'selected' : '' }}>Penyembelih</option>
                                <option value="Lainnya" {{ old('status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('petugas.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


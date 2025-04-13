@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Edit Penerima Qurban</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Penerima</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('penerima-qurban.update', $penerima_qurban->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $penerima_qurban->nik) }}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $penerima_qurban->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tahun_hijriah">Tahun Hijriah</label>
                            <input type="text" name="tahun_hijriah" id="tahun_hijriah" class="form-control @error('tahun_hijriah') is-invalid @enderror" value="{{ old('tahun_hijriah', $penerima_qurban->tahun_hijriah) }}" required>
                            @error('tahun_hijriah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Personal/Yayasan</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="Personal" {{ old('status', $penerima_qurban->status) == 'Personal' ? 'selected' : '' }}>Personal</option>
                                <option value="Yayasan" {{ old('status', $penerima_qurban->status) == 'Yayasan' ? 'selected' : '' }}>Yayasan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $penerima_qurban->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rt">RT</label>
                                    <input type="text" name="rt" id="rt" class="form-control @error('rt') is-invalid @enderror" value="{{ old('rt', $penerima_qurban->rt) }}" required>
                                    @error('rt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rw">RW</label>
                                    <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror" value="{{ old('rw', $penerima_qurban->rw) }}" required>
                                    @error('rw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            <a href="{{ route('penerima-qurban.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


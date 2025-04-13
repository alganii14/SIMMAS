@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Mustahik</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Mustahik</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('mustahik.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_mustahik">No Mustahik</label>
                            <input type="text" name="no_mustahik" class="form-control" id="no_mustahik"
                                value="{{ $newNoMustahik }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="no_kk">No KK</label>
                            <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror"
                                id="no_kk" value="{{ old('no_kk') }}" required>
                            @error('no_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_mustahik">Nama Mustahik</label>
                            <input type="text" name="nama_mustahik"
                                class="form-control @error('nama_mustahik') is-invalid @enderror"
                                id="nama_mustahik" value="{{ old('nama_mustahik') }}" required>
                            @error('nama_mustahik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat_mustahik">Alamat</label>
                            <textarea name="alamat_mustahik"
                                class="form-control @error('alamat_mustahik') is-invalid @enderror"
                                id="alamat_mustahik" rows="3" required>{{ old('alamat_mustahik') }}</textarea>
                            @error('alamat_mustahik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="asnaf">Asnaf</label>
                            <select name="asnaf" class="form-control @error('asnaf') is-invalid @enderror"
                                id="asnaf" required>
                                <option value="">Pilih Asnaf</option>
                                @foreach($asnafList as $asnaf)
                                    <option value="{{ $asnaf }}" {{ old('asnaf') == $asnaf ? 'selected' : '' }}>
                                        {{ $asnaf }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asnaf')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rt">RT</label>
                            <input type="text" name="rt" class="form-control @error('rt') is-invalid @enderror"
                                id="rt" value="{{ old('rt') }}" required maxlength="2">
                            @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah_anak">Jumlah Anak</label>
                            <input type="number" name="jumlah_anak"
                                class="form-control @error('jumlah_anak') is-invalid @enderror"
                                id="jumlah_anak" value="{{ old('jumlah_anak', 0) }}" required min="0">
                            @error('jumlah_anak')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('mustahik.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

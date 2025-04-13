@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Nasabah Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Nasabah Qurban</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('nasabah-qurban.update', $nasabah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                   id="nik" name="nik" value="{{ old('nik', $nasabah->nik) }}" required>
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama', $nasabah->nama) }}" required>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                   id="hp" name="hp" value="{{ old('hp', $nasabah->hp) }}" required>
                            @error('hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $nasabah->alamat) }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="target_hewan_id">Target Hewan Qurban</label>
                            <select class="form-control @error('target_hewan_id') is-invalid @enderror"
                                    id="target_hewan_id" name="target_hewan_id">
                                <option value="">Pilih Target Hewan</option>
                                @foreach($hargaHewan as $hewan)
                                <option value="{{ $hewan->id }}"
                                        {{ old('target_hewan_id', $nasabah->target_hewan_id) == $hewan->id ? 'selected' : '' }}
                                        data-harga="{{ $hewan->harga }}">
                                    {{ $hewan->jenis_hewan }} - Rp {{ number_format($hewan->harga, 0, ',', '.') }}
                                    ({{ $hewan->tahun_hijriah }} H)
                                </option>
                                @endforeach
                            </select>
                            @error('target_hewan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($nasabah->targetHewan)
                        <div class="form-group">
                            <label>Progress Tabungan</label>
                            <div class="progress">
                                @php
                                    $progress = ($nasabah->total_tabungan / $nasabah->targetHewan->harga) * 100;
                                @endphp
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ $progress }}%"
                                     aria-valuenow="{{ $progress }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    {{ number_format($progress, 1) }}%
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Terkumpul: Rp {{ number_format($nasabah->total_tabungan, 0, ',', '.') }}
                                dari Rp {{ number_format($nasabah->targetHewan->harga, 0, ',', '.') }}
                            </small>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('nasabah-qurban.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

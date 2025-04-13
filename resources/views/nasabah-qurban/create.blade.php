@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Nasabah Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Nasabah Qurban</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('nasabah-qurban.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                           id="nik" name="nik" value="{{ old('nik') }}" required
                                           placeholder="Masukkan NIK">
                                    @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                           id="nama" name="nama" value="{{ old('nama') }}" required
                                           placeholder="Masukkan Nama Lengkap">
                                    @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hp">No. HP</label>
                                    <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                           id="hp" name="hp" value="{{ old('hp') }}" required
                                           placeholder="Contoh: 08xxxxxxxxxx">
                                    @error('hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                              id="alamat" name="alamat" rows="3" required
                                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
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
                                                {{ old('target_hewan_id') == $hewan->id ? 'selected' : '' }}
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

                                <div id="info-target" class="form-group" style="display: none;">
                                    <label>Informasi Target</label>
                                    <div class="alert alert-info">
                                        <p class="mb-0">Target Tabungan: <strong id="target-harga">Rp 0</strong></p>
                                        <small class="text-muted">
                                            Nasabah akan mengikuti program tabungan qurban dengan target hewan yang dipilih.
                                            Setoran dapat dilakukan secara bertahap.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mr-1 fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('nasabah-qurban.index') }}" class="btn btn-secondary">
                                    <i class="mr-1 fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    .alert {
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetHewanSelect = document.getElementById('target_hewan_id');
    const infoTarget = document.getElementById('info-target');
    const targetHarga = document.getElementById('target-harga');

    function updateTargetInfo() {
        const selected = targetHewanSelect.options[targetHewanSelect.selectedIndex];
        if (selected && selected.value) {
            const harga = parseFloat(selected.dataset.harga);
            targetHarga.textContent = `Rp ${harga.toLocaleString('id-ID')}`;
            infoTarget.style.display = 'block';
        } else {
            infoTarget.style.display = 'none';
        }
    }

    targetHewanSelect.addEventListener('change', updateTargetInfo);
    updateTargetInfo(); // Run on page load for any pre-selected value
});
</script>
@endpush

@endsection

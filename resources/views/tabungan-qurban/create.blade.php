@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Setoran Tabungan Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Setoran</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tabungan-qurban.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nasabah_id">Nasabah</label>
                            <select class="form-control @error('nasabah_id') is-invalid @enderror" id="nasabah_id"
                                name="nasabah_id" required>
                                <option value="">Pilih Nasabah</option>
                                @foreach($nasabah as $n)
                                    <option value="{{ $n['id'] }}" data-target="{{ $n['target_harga'] }}"
                                        data-terkumpul="{{ $n['total_tabungan'] }}" data-sisa="{{ $n['sisa_tabungan'] }}">
                                        {{ $n['nama'] }} - {{ $n['target_hewan'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nasabah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Informasi Target</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Target: <span id="target_harga">Rp 0</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Terkumpul: <span id="terkumpul">Rp 0</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p>Sisa: <span id="sisa">Rp 0</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_setoran">Jumlah Setoran</label>
                            <input type="number" class="form-control @error('jumlah_setoran') is-invalid @enderror"
                                id="jumlah_setoran" name="jumlah_setoran" value="{{ old('jumlah_setoran') }}" required>
                            @error('jumlah_setoran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tanggal_setor">Tanggal Setor</label>
                            <input type="date" class="form-control @error('tanggal_setor') is-invalid @enderror"
                                id="tanggal_setor" name="tanggal_setor"
                                value="{{ old('tanggal_setor', date('Y-m-d')) }}" required>
                            @error('tanggal_setor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('tabungan-qurban.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nasabahSelect = document.getElementById('nasabah_id');
            const targetHargaSpan = document.getElementById('target_harga');
            const terkumpulSpan = document.getElementById('terkumpul');
            const sisaSpan = document.getElementById('sisa');

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(angka);
            }

            function updateInfo() {
                const selected = nasabahSelect.options[nasabahSelect.selectedIndex];
                if (selected.value) {
                    const target = parseFloat(selected.dataset.target);
                    const terkumpul = parseFloat(selected.dataset.terkumpul);
                    const sisa = parseFloat(selected.dataset.sisa);

                    targetHargaSpan.textContent = formatRupiah(target);
                    terkumpulSpan.textContent = formatRupiah(terkumpul);
                    sisaSpan.textContent = formatRupiah(sisa);
                } else {
                    targetHargaSpan.textContent = 'Rp 0';
                    terkumpulSpan.textContent = 'Rp 0';
                    sisaSpan.textContent = 'Rp 0';
                }
            }

            nasabahSelect.addEventListener('change', updateInfo);
            updateInfo();
        });
    </script>
@endpush

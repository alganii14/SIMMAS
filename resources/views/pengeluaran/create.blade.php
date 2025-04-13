@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Pengeluaran</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Pengeluaran</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengeluaran.store') }}" method="POST" id="pengeluaranForm">
                        @csrf

                        <!-- Menampilkan Sisa Saldo Infaq -->
                        <div class="form-group">
                            <label for="sisa_saldo">Sisa Saldo Infaq</label>
                            <input type="text" id="sisa_saldo" class="form-control" value="Rp {{ number_format($sisaSaldo, 0, ',', '.') }}" readonly>
                        </div>

                        <!-- Nomor Pengajuan -->
                        <div class="form-group">
                            <label for="no_pengajuan">Nomor Pengajuan</label>
                            <input type="text" name="no_pengajuan" id="no_pengajuan" class="form-control" value="{{ $noPengajuan }}" readonly>
                        </div>

                        <!-- Nama User (Login) -->
                        <div class="form-group">
                            <label for="user">Nama User</label>
                            <input type="text" id="user" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <!-- Nama Koordinator Pemohon Dana -->
                        <div class="form-group">
                            <label for="nama_koordinator">Nama Koordinator Pemohon Dana</label>
                            <input type="text" name="nama_koordinator" id="nama_koordinator" class="form-control @error('nama_koordinator') is-invalid @enderror" value="{{ old('nama_koordinator') }}" required>
                            @error('nama_koordinator')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilihan Koordinator Bidang -->
                        <div class="form-group">
                            <label for="koordinator_bidang">Koordinator Bidang</label>
                            <select name="koordinator_bidang" id="koordinator_bidang" class="form-control @error('koordinator_bidang') is-invalid @enderror" required>
                                <option value="">-- Pilih Koordinator Bidang --</option>
                                <option value="Koordinator Bidang Dakwah & Ibadah">Koordinator Bidang Dakwah & Ibadah</option>
                                <option value="Koordinator Bidang Sosial Kemasyarakatan">Koordinator Bidang Sosial Kemasyarakatan</option>
                                <option value="Koordinator Bidang Pendidikan">Koordinator Bidang Pendidikan</option>
                                <option value="Koordinator Bidang Pemberdayaan Ziswaf">Koordinator Bidang Pemberdayaan Ziswaf</option>
                                <option value="Koordinator Bidang Kerumah Tanggaan">Koordinator Bidang Kerumah Tanggaan</option>
                                <option value="Koordinator Bidang Muslimah">Koordinator Bidang Muslimah</option>
                            </select>
                            @error('koordinator_bidang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilihan Jenis Pengeluaran -->
                        <div class="form-group">
                            <label for="jenis_pengeluaran">Jenis Pengeluaran</label>
                            <select name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control @error('jenis_pengeluaran') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Pengeluaran --</option>
                                <option value="Pengeluaran DKM">Pengeluaran DKM</option>
                                <option value="Tagihan Bulanan">Tagihan Bulanan</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Pembelian Barang">Pembelian Barang</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('jenis_pengeluaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Pengajuan -->
                        <div class="form-group">
                            <label for="jumlah">Jumlah Pengajuan (Rp)</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript for checking the amount against the saldo -->
<script>
    document.getElementById('pengeluaranForm').addEventListener('submit', function(e) {
        var jumlah = parseFloat(document.getElementById('jumlah').value);
        var sisaSaldo = parseFloat('{{ $sisaSaldo }}'); // Available saldo from the backend

        // Check if the entered amount exceeds the available saldo
        if (jumlah > sisaSaldo) {
            e.preventDefault(); // Prevent form submission
            alert('Saldo yang Anda masukkan melebihi saldo yang tersedia (Rp ' + sisaSaldo.toLocaleString() + '). Mohon masukkan jumlah yang valid.');
        }
    });
</script>
@endsection

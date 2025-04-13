@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Shohibul Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Shohibul Qurban</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('shohibul-qurban.store') }}" method="POST" id="shohibulForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_hijriah">Tahun Hijriah</label>
                                    <input type="text" name="tahun_hijriah" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" name="nik" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="hp">No. HP</label>
                                    <input type="text" name="hp" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_hewan">Jenis Hewan</label>
                                    <select name="jenis_hewan" class="form-control" required>
                                        <option value="">Pilih Jenis Hewan</option>
                                        <option value="Domba/Kambing">Domba/Kambing</option>
                                        <option value="Sapi">Sapi</option>
                                        <option value="Unta">Unta</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="berat">Berat (kg)</label>
                                    <input type="number" step="0.01" name="berat" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="bagian_diminta">Bagian yang Diminta</label>
                                    <textarea name="bagian_diminta" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 card">
                            <div class="card-header">
                                <h3 class="card-title">Qurban Atas Nama</h3>
                            </div>
                            <div class="card-body">
                                <div id="atas-nama-container">
                                    <!-- Atas nama rows will be added here -->
                                </div>
                                <button type="button" class="btn btn-success" id="tambah-atas-nama">
                                    <i class="fas fa-plus"></i> Tambah Atas Nama
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 form-group">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('shohibul-qurban.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let counter = 0;
    const container = document.getElementById('atas-nama-container');
    const form = document.getElementById('shohibulForm');

    // Set tanggal hari ini
    document.querySelector('input[name="tanggal"]').value = new Date().toISOString().split('T')[0];

    function addAtasNamaRow() {
        const row = document.createElement('div');
        row.className = 'row mb-3';
        row.innerHTML = `
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="atas_nama[${counter}][nama]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Bin/Binti</label>
                    <select name="atas_nama[${counter}][bin_or_binti]" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="Bin">Bin</option>
                        <option value="Binti">Binti</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nama Orang Tua</label>
                    <input type="text" name="atas_nama[${counter}][bin_or_binti_value]" class="form-control" required>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-block hapus-atas-nama">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
        counter++;

        // Add event listener to delete button
        row.querySelector('.hapus-atas-nama').addEventListener('click', function() {
            row.remove();
        });
    }

    // Add first row on page load
    addAtasNamaRow();

    // Add row when button is clicked
    document.getElementById('tambah-atas-nama').addEventListener('click', addAtasNamaRow);

    // Form validation
    form.addEventListener('submit', function(e) {
        const rows = container.children.length;
        if (rows === 0) {
            e.preventDefault();
            alert('Minimal harus ada satu Qurban Atas Nama!');
        }
    });
});
</script>
@endsection
@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Shohibul Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Shohibul Qurban</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('shohibul-qurban.update', $shohibulQurban->id) }}" method="POST" id="shohibulForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_hijriah">Tahun Hijriah</label>
                                    <input type="text" name="tahun_hijriah" class="form-control"
                                           value="{{ $shohibulQurban->tahun_hijriah }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" name="nik" class="form-control"
                                           value="{{ $shohibulQurban->nik }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control"
                                           value="{{ $shohibulQurban->nama }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="hp">No. HP</label>
                                    <input type="text" name="hp" class="form-control"
                                           value="{{ $shohibulQurban->hp }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required>{{ $shohibulQurban->alamat }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_hewan">Jenis Hewan</label>
                                    <select name="jenis_hewan" class="form-control" required>
                                        <option value="">Pilih Jenis Hewan</option>
                                        <option value="Domba/Kambing" {{ $shohibulQurban->jenis_hewan == 'Domba/Kambing' ? 'selected' : '' }}>Domba/Kambing</option>
                                        <option value="Sapi" {{ $shohibulQurban->jenis_hewan == 'Sapi' ? 'selected' : '' }}>Sapi</option>
                                        <option value="Unta" {{ $shohibulQurban->jenis_hewan == 'Unta' ? 'selected' : '' }}>Unta</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="berat">Berat (kg)</label>
                                    <input type="number" step="0.01" name="berat" class="form-control"
                                           value="{{ $shohibulQurban->berat }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="bagian_diminta">Bagian yang Diminta</label>
                                    <textarea name="bagian_diminta" class="form-control" rows="3" required>{{ $shohibulQurban->bagian_diminta }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control"
                                           value="{{ $shohibulQurban->tanggal }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 card">
                            <div class="card-header">
                                <h3 class="card-title">Qurban Atas Nama</h3>
                            </div>
                            <div class="card-body">
                                <div id="atas-nama-container">
                                    @foreach($shohibulQurban->details as $index => $detail)
                                    <div class="mb-3 row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" name="atas_nama[{{ $index }}][nama]"
                                                       class="form-control" value="{{ $detail->nama }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Bin/Binti</label>
                                                <select name="atas_nama[{{ $index }}][bin_or_binti]" class="form-control" required>
                                                    <option value="">Pilih</option>
                                                    <option value="Bin" {{ $detail->bin_or_binti == 'Bin' ? 'selected' : '' }}>Bin</option>
                                                    <option value="Binti" {{ $detail->bin_or_binti == 'Binti' ? 'selected' : '' }}>Binti</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nama Orang Tua</label>
                                                <input type="text" name="atas_nama[{{ $index }}][bin_or_binti_value]"
                                                       class="form-control" value="{{ $detail->bin_or_binti_value }}" required>
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
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success" id="tambah-atas-nama">
                                    <i class="fas fa-plus"></i> Tambah Atas Nama
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 form-group">
                            <button type="submit" class="btn btn-success">Update</button>
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
    let counter = {{ count($shohibulQurban->details) }};
    const container = document.getElementById('atas-nama-container');
    const form = document.getElementById('shohibulForm');

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

    // Add event listeners to existing delete buttons
    document.querySelectorAll('.hapus-atas-nama').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.row').remove();
        });
    });

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
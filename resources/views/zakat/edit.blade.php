@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Zakat</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Zakat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('zakat.update', $zakat->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="no_zakat">No Zakat</label>
                            <input type="text" class="form-control" value="{{ $zakat->no_zakat }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_zakat">Tanggal</label>
                            <input type="date" class="form-control" value="{{ $zakat->tanggal_zakat }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="jam_zakat">Jam</label>
                            <input type="time" class="form-control" value="{{ $zakat->jam_zakat }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="no_muzakki">Muzakki</label>
                            <input type="text" class="form-control"
                                value="{{ $zakat->muzakki->no_muzakki }} - {{ $zakat->muzakki->nama_muzakki }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="jenis_zakat">Jenis Zakat</label>
                            <select name="jenis_zakat" class="form-control" id="jenis_zakat" required>
                                <option value="">Pilih Jenis Zakat</option>
                                <option value="Zakat Fitrah" {{ $zakat->jenis_zakat == 'Zakat Fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                                <option value="Zakat Mal" {{ $zakat->jenis_zakat == 'Zakat Mal' ? 'selected' : '' }}>Zakat Mal</option>
                                <option value="Zakat Penghasilan" {{ $zakat->jenis_zakat == 'Zakat Fidyah' ? 'selected' : '' }}>Zakat Fidyah</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_zakat">Jumlah Zakat</label>
                            <input type="number" name="jumlah_zakat" class="form-control" id="jumlah_zakat"
                                value="{{ $zakat->jumlah_zakat }}" required>
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('zakat.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

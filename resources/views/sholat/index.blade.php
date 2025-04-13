@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Jadwal Sholat</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Jadwal Sholat</h3>
                    <div class="card-tools">
                        <a href="{{ route('sholat.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sholat</th>
                                    <th>Waktu Sholat</th>
                                    <th>Waktu Iqomah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sholats as $index => $sholat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sholat->nama_sholat }}</td>
                                    <td>{{ $sholat->waktu_sholat }}</td>
                                    <td>{{ $sholat->waktu_iqomah }}</td>
                                    <td>
                                        <a href="{{ route('sholat.edit', $sholat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('sholat.destroy', $sholat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

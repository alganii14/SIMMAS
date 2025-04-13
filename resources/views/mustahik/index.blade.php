@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Mustahik</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('mustahik.create') }}" class="btn btn-success">Tambah Mustahik</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Mustahik</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Mustahik</th>
                                <th>No KK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Asnaf</th>
                                <th>RT</th>
                                <th>Jumlah Anak</th> <!-- Tambahkan ini -->
                                <th>Tanggal Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mustahiks as $index => $mustahik)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mustahik->no_mustahik }}</td>
                                <td>{{ $mustahik->no_kk }}</td>
                                <td>{{ $mustahik->nama_mustahik }}</td>
                                <td>{{ $mustahik->alamat_mustahik }}</td>
                                <td>{{ $mustahik->asnaf }}</td>
                                <td>{{ $mustahik->rt }}</td>
                                <td>{{ $mustahik->jumlah_anak }}</td> <!-- Tambahkan ini -->
                                <td>{{ date('d-m-Y', strtotime($mustahik->tanggal_input)) }}</td>
                                <td>
                                    <a href="{{ route('mustahik.edit', $mustahik->id) }}"
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('mustahik.destroy', $mustahik->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus data?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

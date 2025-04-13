@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Muzakki</h1>
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
                <a href="{{ route('muzakki.create') }}" class="btn btn-success">Tambah Muzakki</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Muzakki</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Muzakki</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Tanggal Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($muzakkis as $index => $muzakki)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $muzakki->no_muzakki }}</td>
                                <td>{{ $muzakki->nama_muzakki }}</td>
                                <td>{{ $muzakki->telp_muzakki }}</td>
                                <td>{{ $muzakki->alamat_muzakki }}</td>
                                <td>{{ date('d-m-Y', strtotime($muzakki->tanggal_input)) }}</td>
                                <td>
                                    <a href="{{ route('muzakki.edit', $muzakki->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('muzakki.destroy', $muzakki->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Delete</button>
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
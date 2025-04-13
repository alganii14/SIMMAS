@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Inventaris</h1>
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
                <a href="{{ route('inventories.create') }}" class="btn btn-success">Tambah Inventaris</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Inventaris</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kondisi</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $index => $inventory)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $inventory->nama }}</td>
                                <td>{{ $inventory->kondisi }}</td>
                                <td>
                                    @if($inventory->gambar)
                                        <img src="{{ asset('storage/' . $inventory->gambar) }}" width="100">
                                    @else
                                        <span>Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
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

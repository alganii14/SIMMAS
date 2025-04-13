@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Donatur</h1>
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

            <!-- Button Tambah Donatur -->
            <div class="mb-3">
                <a href="{{ route('donatur.create') }}" class="btn btn-success">Tambah Donatur</a>
            </div>

            <!-- Daftar Donatur -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Daftar Donatur</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Donatur</th>
                                    <th>Nama</th>
                                    <th>Tampilan</th>
                                    <th>No Telepon</th>
                                    <th>Email</th>
                                    <th>Pekerjaan</th>
                                    <th>Alamat</th>
                                    <th>Pesan/Doa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($donaturs as $index => $donatur)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $donatur->no_donatur }}</td>
                                    <td>{{ $donatur->nama }}</td>
                                    <td>
                                        @if(isset($donatur->anonim) && $donatur->anonim == 'ya')
                                            <span class="badge badge-info">Sahabat</span>
                                        @else
                                            {{ $donatur->nama }}
                                        @endif
                                    </td>
                                    <td>{{ $donatur->no_telepon }}</td>
                                    <td>{{ $donatur->email ?? '-' }}</td>
                                    <td>{{ $donatur->pekerjaan ?? '-' }}</td>
                                    <td>{{ $donatur->alamat ?? '-' }}</td>
                                    <td>{{ $donatur->pesan_doa ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('donatur.edit', $donatur->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('donatur.destroy', $donatur->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus donatur?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if(count($donaturs) == 0)
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data donatur</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
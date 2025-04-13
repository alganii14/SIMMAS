@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Register Petugas</h1>
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

            <!-- Button Tambah Petugas -->
            <div class="mb-3">
                <a href="{{ route('register.create') }}" class="btn btn-success">Tambah Petugas</a>
            </div>

            <!-- Daftar Petugas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Daftar Petugas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID Petugas</th> <!-- Added column for ID -->
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugas as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ 'ID' . sprintf('%03d', $user->id) }}</td> <!-- Display the formatted ID -->
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>
                                    <a href="{{ route('register.edit', $user->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('register.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus petugas?')">Delete</button>
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
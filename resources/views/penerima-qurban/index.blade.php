@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Penerima Qurban</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Penerima Qurban</h3>
                    <div class="card-tools">
                        <a href="{{ route('penerima-qurban.create') }}" class="btn btn-primary">Tambah Penerima</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Search Form -->
                    <form action="{{ route('penerima-qurban.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rt">RT</label>
                                    <input type="text" name="rt" id="rt" class="form-control" value="{{ request('rt') }}" placeholder="Cari RT...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rw">RW</label>
                                    <input type="text" name="rw" id="rw" class="form-control" value="{{ request('rw') }}" placeholder="Cari RW...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary d-block">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tahun Hijriah</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($penerima as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->tahun_hijriah }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td>{{ $p->alamat }}</td>
                                    <td>{{ $p->rt }}</td>
                                    <td>{{ $p->rw }}</td>
                                    <td>
                                        <a href="{{ route('penerima-qurban.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('penerima-qurban.destroy', $p->id) }}" method="POST" class="d-inline">
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

@push('scripts')
<script>
    // Real-time search functionality
    document.querySelectorAll('input[name="rt"], input[name="rw"]').forEach(input => {
        input.addEventListener('keyup', function() {
            this.form.submit();
        });
    });
</script>
@endpush


@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Pengeluaran</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengeluaran</h3>
                    <div class="card-tools">
                        <a href="{{ route('pengeluaran.create') }}" class="btn btn-success">
                            Tambah Pengeluaran
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="pengeluaranTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Pengajuan</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Pemohon Dana</th>
                                <th>Koordinator</th>
                                <th>Jenis Pengeluaran</th>
                                <th>Jumlah Pengajuan (Rp)</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengeluarans as $pengeluaran)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengeluaran->no_pengajuan }}</td>
                                <td>{{ $pengeluaran->created_at->format('d-m-Y') }}</td> <!-- Tanggal -->
                                <td>{{ $pengeluaran->user->name }}</td> <!-- User (Nama User) -->
                                <td>{{ $pengeluaran->nama_koordinator }}</td> <!-- Pemohon Dana -->
                                <td>{{ $pengeluaran->koordinator_bidang }}</td> <!-- Koordinator -->
                                <td>{{ $pengeluaran->jenis_pengeluaran }}</td>
                                <td>Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $pengeluaran->keterangan }}</td>
                                <td>
                                    <a href="{{ route('pengeluaran.edit', $pengeluaran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')">Hapus</button>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#pengeluaranTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [[0, 'asc']],
            "lengthChange": false,
            "dom": 'Bfrtip',
            "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    });
</script>
@endpush
@endsection

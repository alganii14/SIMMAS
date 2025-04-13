@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Shohibul Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Search Bar -->
            <form action="{{ route('shohibul-qurban.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search"
                           placeholder="Cari berdasarkan nama/NIK" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <!-- Button Tambah Data -->
            <div class="mb-3">
                <a href="{{ route('shohibul-qurban.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Shohibul Qurban
                </a>
            </div>

            <!-- Tabel Shohibul Qurban -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Shohibul Qurban</h3>
                </div>
                <div class="p-0 card-body table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Hijriah</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Jenis Hewan</th>
                                <th>Berat</th>
                                <th>Bagian Diminta</th>
                                <th>Tanggal</th>
                                <th>Atas Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shohibulQurbans as $index => $sq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $sq->tahun_hijriah }}</td>
                                <td>{{ $sq->nik }}</td>
                                <td>{{ $sq->nama }}</td>
                                <td>{{ $sq->hp }}</td>
                                <td>{{ $sq->alamat }}</td>
                                <td>{{ $sq->jenis_hewan }}</td>
                                <td>{{ $sq->berat }} kg</td>
                                <td>{{ $sq->bagian_diminta }}</td>
                                <td>{{ \Carbon\Carbon::parse($sq->tanggal)->format('d-m-Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm"
                                            data-toggle="modal"
                                            data-target="#detailModal-{{ $sq->id }}">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>

                                    <!-- Modal Detail Atas Nama -->
                                    <div class="modal fade" id="detailModal-{{ $sq->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Qurban Atas Nama</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Nama</th>
                                                                    <th>Bin/Binti</th>
                                                                    <th>Nama Orang Tua</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($sq->details as $index => $detail)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $detail->nama }}</td>
                                                                        <td>{{ $detail->bin_or_binti }}</td>
                                                                        <td>{{ $detail->bin_or_binti_value }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" class="text-center">Tidak ada data atas nama.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('shohibul-qurban.edit', $sq->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('shohibul-qurban.destroy', $sq->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">
                                    <div class="mb-0 alert alert-info" role="alert">
                                        <i class="mr-2 fas fa-info-circle"></i>
                                        Tidak ada data Shohibul Qurban.
                                        <a href="{{ route('shohibul-qurban.create') }}" class="alert-link">
                                            Klik disini untuk menambah data
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto hide alert after 5 seconds
    const alertSuccess = document.querySelector('.alert-success');
    if (alertSuccess) {
        setTimeout(function() {
            alertSuccess.remove();
        }, 5000);
    }

    // Initialize DataTable if there are records
    const table = document.querySelector('table');
    if (table && table.rows.length > 1) {
        $(table).DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    }
});
</script>
@endpush

@endsection

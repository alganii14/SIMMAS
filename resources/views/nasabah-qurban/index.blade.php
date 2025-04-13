@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Nasabah Qurban</h1>
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Nasabah Qurban</h3>
                    <div class="card-tools">
                        <a href="{{ route('nasabah-qurban.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Nasabah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>HP</th>
                                    <th>Alamat</th>
                                    <th>Target Hewan</th>
                                    <th>Progress Tabungan</th>
                                    <th>Ref ID</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nasabah as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->hp }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>
                                        @if($item->targetHewan)
                                            {{ $item->targetHewan->jenis_hewan }} <br>
                                            <small>Rp {{ number_format($item->targetHewan->harga, 0, ',', '.') }}</small>
                                        @else
                                            <span class="badge badge-warning">Belum ada target</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->targetHewan)
                                            @php
                                                $progress = ($item->total_tabungan / $item->targetHewan->harga) * 100;
                                            @endphp
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $progress }}%"
                                                     aria-valuenow="{{ $progress }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    {{ number_format($progress, 1) }}%
                                                </div>
                                            </div>
                                            <small>
                                                Terkumpul: Rp {{ number_format($item->total_tabungan, 0, ',', '.') }}
                                                <br>
                                                Sisa: Rp {{ number_format($item->sisa_tabungan, 0, ',', '.') }}
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->ref_id }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('nasabah-qurban.edit', $item->id) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($item->targetHewan)
                                            <a href="{{ route('tabungan-qurban.create', ['nasabah_id' => $item->id]) }}"
                                               class="btn btn-sm btn-info" title="Tambah Setoran">
                                                <i class="fas fa-money-bill"></i>
                                            </a>
                                            @endif
                                            <form action="{{ route('nasabah-qurban.destroy', $item->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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

@push('styles')
<style>
    .progress {
        height: 20px;
        margin-bottom: 5px;
    }
    .btn-group {
        display: flex;
        gap: 5px;
    }
</style>
@endpush

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

    // Initialize DataTable
    $('.table').DataTable({
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
});
</script>
@endpush

@endsection

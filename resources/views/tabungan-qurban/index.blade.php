@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Tabungan Qurban</h1>
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
                    <h3 class="card-title">Data Tabungan Qurban</h3>
                    <div class="card-tools">
                        <a href="{{ route('tabungan-qurban.create') }}" class="btn btn-primary">
                            Tambah Setoran
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Card info saldo -->
                    <div class="mb-4 row">
                        <div class="col-lg-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-money-bill"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Saldo Tabungan Qurban</span>
                                    <span class="info-box-number">Rp {{ number_format(App\Models\TabunganQurban::getTotalSaldo(), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nasabah</th>
                                    <th>Target Hewan</th>
                                    <th>Jumlah Setoran</th>
                                    <th>Total Tabungan</th>
                                    <th>Sisa Target</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tabungan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->tanggal_setor }}</td>
                                    <td>{{ $item->nasabah->nama }}</td>
                                    <td>
                                        {{ $item->hargaHewan->jenis_hewan }} -
                                        Rp {{ number_format($item->hargaHewan->harga, 0, ',', '.') }}
                                    </td>
                                    <td>Rp {{ number_format($item->jumlah_setoran, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->nasabah->total_tabungan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item->nasabah->sisa_tabungan, 0, ',', '.') }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('tabungan-qurban.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('tabungan-qurban.destroy', $item->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
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

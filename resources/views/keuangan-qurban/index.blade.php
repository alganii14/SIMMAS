@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Keuangan Qurban</h1>
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

            <div class="mb-4 row">
                <div class="col-lg-4">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Saldo Tabungan Qurban</span>
                            <span class="info-box-number">Rp {{ number_format($saldoTabungan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-money-bill"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Saldo Keuangan Qurban</span>
                            <span class="info-box-number">Rp {{ number_format($saldoKeuangan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Saldo</span>
                            <span class="info-box-number">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Transaksi</h3>
                    <div class="card-tools">
                        <a href="{{ route('keuangan-qurban.create') }}" class="btn btn-primary">
                            Tambah Transaksi
                        </a>
                        <a href="{{ route('keuangan-qurban.laporan') }}" class="btn btn-info">
                            Laporan Keuangan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Transaksi</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $index => $t)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $t->no_transaksi }}</td>
                                    <td>
                                        <span class="badge badge-{{ $t->jenis === 'Masuk' ? 'success' : 'danger' }}">
                                            {{ $t->jenis }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $t->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('keuangan-qurban.edit', $t->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('keuangan-qurban.destroy', $t->id) }}"
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

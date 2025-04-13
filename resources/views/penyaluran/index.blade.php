@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Penyaluran Zakat</h1>
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

            <!-- Ringkasan Saldo -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
                            <p>Total Saldo Zakat</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalZakatFitrah, 0, ',', '.') }}</h3>
                            <p>Total Zakat Fitrah</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalZakatMal, 0, ',', '.') }}</h3>
                            <p>Total Zakat Mal</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalZakatFidyah, 0, ',', '.') }}</h3>
                            <p>Total Zakat Fidyah</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Beras -->
            {{-- <div class="mb-4 row">
                <div class="col-lg-6">
                    <div class="info-box bg-gradient-primary">
                        <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Beras Terkumpul</span>
                            <span class="info-box-number">{{ number_format($totalBeras, 2, ',', '.') }} Kg</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                                Setara dengan Rp {{ number_format($totalBeras * 14000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="mb-3">
                <a href="{{ route('penyaluran.create') }}" class="btn btn-primary">Tambah Penyaluran</a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penyaluran Zakat</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Penyaluran</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Petugas</th>
                                <th>Jenis Zakat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penyalurans as $index => $penyaluran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $penyaluran->no_penyaluran }}</td>
                                <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal_penyaluran)->format('d-m-Y') }}</td>
                                <td>{{ $penyaluran->jam_penyaluran }}</td>
                                <td>{{ $penyaluran->petugas_penyaluran }}</td>
                                <td>{{ $penyaluran->jenis_zakat }}</td>
                                <td>Rp {{ number_format($penyaluran->total_penyaluran, 0, ',', '.') }}</td>
                                <td>{{ $penyaluran->status_penyaluran }}</td>
                                <td>
                                    <a href="{{ route('penyaluran.edit', $penyaluran->no_penyaluran) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('penyaluran.destroy', $penyaluran->no_penyaluran) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
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

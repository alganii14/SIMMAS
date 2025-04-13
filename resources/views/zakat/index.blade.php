@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Penerimaan Zakat</h1>
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

            <!-- Search Bar -->
            <form action="{{ route('zakat.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search"
                           placeholder="Cari Zakat" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <!-- Button Tambah Data -->
            <div class="mb-3">
                <a href="{{ route('zakat.create') }}" class="btn btn-primary">Tambah Zakat</a>
                <a href="{{ route('zakat.report') }}" class="btn btn-info">
                    <i class="fas fa-file-alt"></i> Laporan Zakat
                </a>
            </div>

            <!-- Tabel Zakat -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penerimaan Zakat</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Zakat</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Petugas</th>
                                    <th>Muzakki</th>
                                    <th>Jenis Zakat</th>
                                    <th>Jenis Bayar</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($zakats as $index => $zakat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $zakat->no_zakat }}</td>
                                    <td>{{ $zakat->tanggal_zakat->format('d-m-Y') }}</td>
                                    <td>{{ $zakat->jam_zakat }}</td>
                                    <td>{{ $zakat->petugas_penerima }}</td>
                                    <td>{{ $zakat->muzakki->nama_muzakki }}</td>
                                    <td>{{ $zakat->jenis_zakat }}</td>
                                    <td>{{ ucfirst($zakat->jenis_bayar) }}</td>
                                    <td>
                                        @if($zakat->jenis_bayar === 'beras')
                                            {{ number_format($zakat->berat_beras, 2, ',', '.') }} kg
                                        @else
                                            Rp {{ number_format($zakat->jumlah_zakat, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('zakat.edit', $zakat->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('zakat.destroy', $zakat->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

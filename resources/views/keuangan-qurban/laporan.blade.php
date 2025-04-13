@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Laporan Keuangan Qurban</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('keuangan-qurban.laporan') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai"
                                           name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="tanggal_akhir"
                                           name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('keuangan-qurban.laporan', ['type' => 'pdf'] + request()->all()) }}"
                                           class="btn btn-danger" target="_blank">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="mb-4 row">
                        <div class="col-md-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Saldo Tabungan Qurban</span>
                                    <span class="info-box-number">Rp {{ number_format($saldoTabungan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-money-bill"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Saldo Keuangan Qurban</span>
                                    <span class="info-box-number">Rp {{ number_format($saldoKeuangan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Saldo</span>
                                    <span class="info-box-number">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
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
                                    <th>No Transaksi</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $saldoBerjalan = 0; @endphp
                                @foreach($transaksi as $index => $t)
                                @php
                                    if ($t->jenis === 'Masuk') {
                                        $saldoBerjalan += $t->jumlah;
                                    } else {
                                        $saldoBerjalan -= $t->jumlah;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $t->no_transaksi }}</td>
                                    <td>{{ $t->keterangan }}</td>
                                    <td class="text-right">
                                        {{ $t->jenis === 'Masuk' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-right">
                                        {{ $t->jenis === 'Keluar' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-right">Rp {{ number_format($saldoBerjalan, 0, ',', '.') }}</td>
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

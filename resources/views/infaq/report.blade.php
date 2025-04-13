@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Laporan Penerimaan Infaq dan Shodaqoh</h1>
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

            <!-- Filter -->
            <form action="{{ route('infaq.report') }}" method="GET" class="mb-3">
                <div class="form-row">
                    <div class="col-md-3">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="jenis_penerimaan">Jenis Penerimaan</label>
                        <select name="jenis_penerimaan" class="form-control">
                            <option value="all">Semua</option>
                            <option value="Transfer" {{ request('jenis_penerimaan') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="QRIS" {{ request('jenis_penerimaan') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            <option value="Kotak Amal" {{ request('jenis_penerimaan') == 'Kotak Amal' ? 'selected' : '' }}>Kotak Amal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="mt-4 btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <!-- PDF Export Button -->
            <a href="{{ route('infaq.report.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'jenis_penerimaan' => request('jenis_penerimaan')]) }}" class="mb-3 btn btn-success">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>

            @php
            $totalPenerimaan = $infaqs->sum('jumlah');
            @endphp

            <!-- Daftar Penerimaan -->
            <div class="mt-4 card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penerimaan Infaq dan Shodaqoh</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Penerimaan</th>
                                <th>Petugas</th>
                                <th>Donatur</th>
                                <th>Jenis Penerimaan</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($infaqs as $index => $infaq)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $infaq->no_penerimaan }}</td>
                                <td>{{ $infaq->petugas ? $infaq->petugas->name : '-' }}</td>
                                <td>{{ $infaq->donatur->nama }}</td>
                                <td>{{ $infaq->jenis_penerimaan }}</td>
                                <td>Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($infaq->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($infaq->waktu)->format('H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total Penerimaan:</th>
                                <th>Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

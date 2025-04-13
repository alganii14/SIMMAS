@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Laporan Penerimaan Zakat</h1>
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

            <!-- Filter Tanggal -->
            <form action="{{ route('zakat.report') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                        <a href="{{ route('zakat.report.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                           class="btn btn-success mt-4">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel Laporan -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Penerimaan Zakat</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Zakat</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Petugas</th>
                                <th>Muzakki</th>
                                <th>Jenis Zakat</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalZakat = 0; @endphp
                            @forelse ($zakats as $index => $zakat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $zakat->no_zakat }}</td>
                                <td>{{ \Carbon\Carbon::parse($zakat->tanggal_zakat)->format('d-m-Y') }}</td>
                                <td>{{ $zakat->jam_zakat }}</td>
                                <td>{{ $zakat->petugas_penerima }}</td>
                                <td>{{ $zakat->muzakki->nama_muzakki }}</td>
                                <td>{{ $zakat->jenis_zakat }}</td>
                                <td>Rp {{ number_format($zakat->jumlah_zakat, 0, ',', '.') }}</td>
                            </tr>
                            @php $totalZakat += $zakat->jumlah_zakat; @endphp
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                            @if($zakats->count() > 0)
                            <tr>
                                <td colspan="7" class="text-right"><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($totalZakat, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
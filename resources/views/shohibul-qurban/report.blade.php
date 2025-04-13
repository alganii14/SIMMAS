@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Laporan Shohibul Qurban</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Shohibul Qurban</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('shohibul-qurban.report') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tahun Hijriah</label>
                                    <select name="tahun_hijriah" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ request('tahun_hijriah') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Hewan</label>
                                    <select name="jenis_hewan" class="form-control">
                                        <option value="">Semua Jenis</option>
                                        <option value="Domba/Kambing" {{ request('jenis_hewan') == 'Domba/Kambing' ? 'selected' : '' }}>
                                            Domba/Kambing
                                        </option>
                                        <option value="Sapi" {{ request('jenis_hewan') == 'Sapi' ? 'selected' : '' }}>
                                            Sapi
                                        </option>
                                        <option value="Unta" {{ request('jenis_hewan') == 'Unta' ? 'selected' : '' }}>
                                            Unta
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control"
                                           value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control"
                                           value="{{ request('end_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('shohibul-qurban.report') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                                <a href="{{ route('shohibul-qurban.export-pdf', request()->all()) }}"
                                   class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Shohibul Qurban</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Hijriah</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Hewan</th>
                                    <th>Nama Shohibul</th>
                                    <th>Berat (kg)</th>
                                    <th>Qurban Atas Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shohibuls as $index => $shohibul)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $shohibul->tahun_hijriah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($shohibul->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $shohibul->jenis_hewan }}</td>
                                    <td>{{ $shohibul->nama }}</td>
                                    <td>{{ $shohibul->berat }}</td>
                                    <td>
                                        <ul class="m-0 list-unstyled">
                                            @foreach($shohibul->details as $detail)
                                                <li>{{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}</li>
                                            @endforeach
                                        </ul>
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

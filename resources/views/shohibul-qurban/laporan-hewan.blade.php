@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Laporan Hewan Qurban</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Hewan Qurban</li>
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
                    <form action="{{ route('shohibul-qurban.laporan-hewan') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('shohibul-qurban.laporan-hewan') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                                <a href="{{ route('shohibul-qurban.laporan-hewan.pdf', request()->all()) }}"
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
                    <h3 class="card-title">Data Hewan Qurban</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 50%">MUDHOHI</th>
                                <th style="width: 50%">ATAS NAMA</th>
                            </tr>
                            @foreach($shohibuls as $shohibul)
                            <tr>
                                <td>
                                    {{ $shohibul->jenis_hewan }} {{ $shohibul->nama }},
                                    {{ $shohibul->berat }} Kg
                                </td>
                                <td>
                                    @foreach($shohibul->details as $detail)
                                        {{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}
                                        @if(!$loop->last)<br>@endif
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

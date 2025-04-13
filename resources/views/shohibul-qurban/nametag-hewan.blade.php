@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Nametag Hewan Qurban</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Nametag Hewan Qurban</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Nametag</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('shohibul-qurban.nametag-hewan') }}" method="GET">
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
                                <a href="{{ route('shohibul-qurban.nametag-hewan') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                                <a href="{{ route('shohibul-qurban.nametag-hewan.pdf', request()->all()) }}"
                                   class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Download Nametag
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview Nametag</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($shohibuls as $shohibul)
                        <div class="mb-4 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3 text-center">
                                        <h4>PANITIA QURBAN {{ $shohibul->tahun_hijriah }} H</h4>
                                        <h5>MASJID KHAIRUL AMAL</h5>
                                    </div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" class="text-center bg-light">NAMETAG HEWAN QURBAN</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px">Jenis Hewan</th>
                                            <td>{{ $shohibul->jenis_hewan }}</td>
                                        </tr>
                                        <tr>
                                            <th>Berat</th>
                                            <td>{{ $shohibul->berat }} Kg</td>
                                        </tr>
                                        <tr>
                                            <th>Shohibul Qurban</th>
                                            <td>{{ $shohibul->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Atas Nama</th>
                                            <td>
                                                @foreach($shohibul->details as $detail)
                                                    {{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}
                                                    @if(!$loop->last)<br>@endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

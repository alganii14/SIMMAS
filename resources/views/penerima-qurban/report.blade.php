@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Laporan Distribusi Qurban</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Laporan Distribusi Qurban</li>
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
                    <form action="{{ route('penerima-qurban.report') }}" method="GET">
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>RT</label>
                                    <select name="rt" class="form-control">
                                        <option value="">Semua RT</option>
                                        @foreach($rts as $rt)
                                            <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>
                                                {{ $rt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>RW</label>
                                    <select name="rw" class="form-control">
                                        <option value="">Semua RW</option>
                                        @foreach($rws as $rw)
                                            <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>
                                                {{ $rw }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="Personal" {{ request('status') == 'Personal' ? 'selected' : '' }}>Personal</option>
                                        <option value="Yayasan" {{ request('status') == 'Yayasan' ? 'selected' : '' }}>Yayasan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('penerima-qurban.report') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Distribusi Qurban</h3>
                    <div class="card-tools">
                        <a href="{{ route('penerima-qurban.export-pdf', request()->all()) }}"
                           class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tahun Hijriah</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $currentRw = ''; $currentRt = ''; $no = 1; @endphp
                                @foreach($penerimas as $penerima)
                                    @if($currentRw != $penerima->rw)
                                        <tr class="bg-light">
                                            <td colspan="8"><strong>RW {{ $penerima->rw }}</strong></td>
                                        </tr>
                                        @php $currentRw = $penerima->rw; $currentRt = ''; @endphp
                                    @endif
                                    @if($currentRt != $penerima->rt)
                                        <tr class="bg-light">
                                            <td colspan="8" style="padding-left: 20px;"><strong>RT {{ $penerima->rt }}</strong></td>
                                        </tr>
                                        @php $currentRt = $penerima->rt; @endphp
                                    @endif
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $penerima->nik }}</td>
                                        <td>{{ $penerima->nama }}</td>
                                        <td>{{ $penerima->tahun_hijriah }}</td>
                                        <td>{{ $penerima->status }}</td>
                                        <td>{{ $penerima->alamat }}</td>
                                        <td>{{ $penerima->rt }}</td>
                                        <td>{{ $penerima->rw }}</td>
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
@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Penerimaan Infaq dan Shodaqoh</h1>
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
            <!-- Total Infaq Balance Card -->
            <div class="card bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Saldo Infaq</h5>
                    <h2 class="card-text">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</h2>
                </div>
            </div>
            <!-- Search Bar -->
            <form action="{{ route('infaq.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari Penerimaan Infaq" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            <!-- Filter Status -->
            <form action="{{ route('infaq.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <select name="status" class="form-control">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Sukses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Button Tambah Data -->
            <div class="mb-3">
                <a href="{{ route('infaq.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>

            <!-- Status Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Sukses</h5>
                            <p class="card-text">{{ $statusSummary['success']['count'] }} transaksi</p>
                            <h4 class="card-text">Rp {{ number_format($statusSummary['success']['total'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <p class="card-text">{{ $statusSummary['pending']['count'] }} transaksi</p>
                            <h4 class="card-text">Rp {{ number_format($statusSummary['pending']['total'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Gagal/Batal</h5>
                            <p class="card-text">{{ $statusSummary['failed']['count'] }} transaksi</p>
                            <h4 class="card-text">Rp {{ number_format($statusSummary['failed']['total'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Penerimaan -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Daftar Penerimaan Infaq dan Shodaqoh</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Penerimaan</th>
                                <th>Petugas</th>
                                <th>Donatur</th>
                                <th>Jenis Penerimaan</th>
                                <th>Jumlah</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($infaqs as $index => $infaq)
                            <tr class="{{ $infaq->status == 'success' ? 'table-success' : ($infaq->status == 'pending' ? 'table-warning' : 'table-danger') }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $infaq->no_penerimaan }}</td>
                                <td>{{ $infaq->petugas ? $infaq->petugas->name : '-' }}</td>
                                <td>{{ $infaq->donatur->nama }}</td>
                                <td>{{ $infaq->jenis_penerimaan }}</td>
                                <td>Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($infaq->created_at)->format('d M Y H:i:s') }}
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($infaq->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($infaq->status == 'success')
                                        <span class="badge badge-success">Sukses</span>
                                    @elseif($infaq->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($infaq->status == 'expired')
                                        <span class="badge badge-danger">Kadaluarsa</span>
                                    @elseif($infaq->status == 'canceled')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @elseif($infaq->status == 'denied')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif($infaq->status == 'failed')
                                        <span class="badge badge-danger">Gagal</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $infaq->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('infaq.edit', $infaq->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('infaq.destroy', $infaq->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                        @if($infaq->snap_token && $infaq->status == 'pending')
                                            <a href="{{ route('midtrans.payment', $infaq->id) }}" class="btn btn-sm btn-info">Bayar</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add this script to update relative times automatically -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update relative times
    function updateRelativeTimes() {
        // This is a placeholder - in a real implementation, you would need to
        // use a library like moment.js or fetch updated times from the server
        console.log('Relative times would update here');
    }

    // Update times every minute
    setInterval(updateRelativeTimes, 60000);
});
</script>
@endsection

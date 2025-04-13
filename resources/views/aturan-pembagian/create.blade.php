@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>DKM Masjid Khairul Akmal</h1>
            <h2>Aturan Pembagian</h2>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Aturan Pembagian</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('aturan-pembagian.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">Silahkan Pilih</option>
                                        <option value="Penerima - Personal">Penerima - Personal</option>
                                        <option value="Penerima - Yayasan">Penerima - Yayasan</option>
                                        <option value="Panitia - Petugas DKM">Panitia - Petugas DKM</option>
                                        <option value="Panitia - Warga">Panitia - Warga</option>
                                        <option value="Panitia - Penyembelih">Panitia - Penyembelih</option>
                                        <option value="Panitia - Lainnya">Panitia - Lainnya</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Jenis</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Daging Kambing" class="custom-control-input" id="daging_kambing">
                                        <label class="custom-control-label" for="daging_kambing">Daging Kambing</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Daging Sapi" class="custom-control-input" id="daging_sapi">
                                        <label class="custom-control-label" for="daging_sapi">Daging Sapi</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Tulang Kambing" class="custom-control-input" id="tulang_kambing">
                                        <label class="custom-control-label" for="tulang_kambing">Tulang Kambing</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Tulang Sapi" class="custom-control-input" id="tulang_sapi">
                                        <label class="custom-control-label" for="tulang_sapi">Tulang Sapi</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Jeroan" class="custom-control-input" id="jeroan">
                                        <label class="custom-control-label" for="jeroan">Jeroan</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="produk[]" value="Kepala" class="custom-control-input" id="kepala">
                                        <label class="custom-control-label" for="kepala">Kepala</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4 card">
                        <div class="card-header">
                            <h3 class="card-title">Form Hasil Pemotongan</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('aturan-pembagian.store-produk') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="produk">Jenis</label>
                                    <select name="produk" class="form-control @error('produk') is-invalid @enderror" required>
                                        <option value="">Silahkan Pilih</option>
                                        <option value="Daging Kambing">Daging Kambing</option>
                                        <option value="Daging Sapi">Daging Sapi</option>
                                        <option value="Tulang Kambing">Tulang Kambing</option>
                                        <option value="Tulang Sapi">Tulang Sapi</option>
                                        <option value="Jeroan">Jeroan</option>
                                        <option value="Kepala">Kepala</option>
                                    </select>
                                    @error('produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="berat">Berat (kg)</label>
                                    <input type="number" step="0.01" name="berat" class="form-control @error('berat') is-invalid @enderror" required>
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Hitung</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Aturan Pembagian</h3>
                        </div>
                        <div class="p-0 card-body table-responsive">
                            <table class="table table-hover text-nowrap" id="tabelAturan">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Produk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aturanPembagians as $index => $aturan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $aturan->status }}</td>
                                        <td>{{ $aturan->produk }}</td>
                                        <td>
                                            <form action="{{ route('aturan-pembagian.destroy', $aturan->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Hasil Pemotongan</h3>
                        </div>
                        <div class="p-0 card-body table-responsive">
                            <table class="table table-hover text-nowrap" id="tabelProduk">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Berat Total</th>
                                        <th>Jumlah Penerima</th>
                                        <th>Berat /penerima</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pembagianProduks as $index => $produk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $produk->produk }}</td>
                                        <td>{{ number_format($produk->berat, 2) }} kg</td>
                                        <td>{{ $produk->total_bungkus }}</td>
                                        <td>{{ number_format($produk->berat_perproduk, 2) }} kg</td>
                                        <td>
                                            <form action="{{ route('aturan-pembagian.destroy-produk', $produk->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#tabelAturan').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $('#tabelProduk').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    // Auto hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>
@endpush
@endsection

@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Edit Pembagian Produk</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Produk</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('aturan-pembagian.produk.update', $pembagianProduk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <select name="produk" class="form-control @error('produk') is-invalid @enderror" required>
                                <option value="">Pilih Produk</option>
                                <option value="Daging Kambing" {{ $pembagianProduk->produk == 'Daging Kambing' ? 'selected' : '' }}>
                                    Daging Kambing
                                </option>
                                <option value="Daging Sapi" {{ $pembagianProduk->produk == 'Daging Sapi' ? 'selected' : '' }}>
                                    Daging Sapi
                                </option>
                                <option value="Tulang Kambing" {{ $pembagianProduk->produk == 'Tulang Kambing' ? 'selected' : '' }}>
                                    Tulang Kambing
                                </option>
                                <option value="Tulang Sapi" {{ $pembagianProduk->produk == 'Tulang Sapi' ? 'selected' : '' }}>
                                    Tulang Sapi
                                </option>
                                <option value="Jeroan" {{ $pembagianProduk->produk == 'Jeroan' ? 'selected' : '' }}>
                                    Jeroan
                                </option>
                                <option value="Kepala" {{ $pembagianProduk->produk == 'Kepala' ? 'selected' : '' }}>
                                    Kepala
                                </option>
                            </select>
                            @error('produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="berat">Berat Total (kg)</label>
                            <input type="number" step="0.01" name="berat"
                                   class="form-control @error('berat') is-invalid @enderror"
                                   value="{{ old('berat', $pembagianProduk->berat) }}" required>
                            @error('berat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="total_bungkus">Jumlah Penerima</label>
                            <input type="number" name="total_bungkus"
                                   class="form-control @error('total_bungkus') is-invalid @enderror"
                                   value="{{ old('total_bungkus', $pembagianProduk->total_bungkus) }}" required>
                            @error('total_bungkus')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('aturan-pembagian.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

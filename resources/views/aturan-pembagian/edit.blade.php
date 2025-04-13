@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1>Edit Aturan Pembagian</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Aturan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('aturan-pembagian.update', $aturanPembagian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="Penerima - Personal" {{ $aturanPembagian->status == 'Penerima - Personal' ? 'selected' : '' }}>
                                    Penerima - Personal
                                </option>
                                <option value="Penerima - Yayasan" {{ $aturanPembagian->status == 'Penerima - Yayasan' ? 'selected' : '' }}>
                                    Penerima - Yayasan
                                </option>
                                <option value="Panitia - Petugas DKM" {{ $aturanPembagian->status == 'Panitia - Petugas DKM' ? 'selected' : '' }}>
                                    Panitia - Petugas DKM
                                </option>
                                <option value="Panitia - Warga" {{ $aturanPembagian->status == 'Panitia - Warga' ? 'selected' : '' }}>
                                    Panitia - Warga
                                </option>
                                <option value="Panitia - Penyembelih" {{ $aturanPembagian->status == 'Panitia - Penyembelih' ? 'selected' : '' }}>
                                    Panitia - Penyembelih
                                </option>
                                <option value="Panitia - Lainnya" {{ $aturanPembagian->status == 'Panitia - Lainnya' ? 'selected' : '' }}>
                                    Panitia - Lainnya
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Jenis</label>
                            @php
                                $produks = explode(', ', $aturanPembagian->produk);
                            @endphp
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Daging Kambing"
                                       class="custom-control-input" id="daging_kambing"
                                       {{ in_array('Daging Kambing', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="daging_kambing">Daging Kambing</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Daging Sapi"
                                       class="custom-control-input" id="daging_sapi"
                                       {{ in_array('Daging Sapi', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="daging_sapi">Daging Sapi</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Tulang Kambing"
                                       class="custom-control-input" id="tulang_kambing"
                                       {{ in_array('Tulang Kambing', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tulang_kambing">Tulang Kambing</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Tulang Sapi"
                                       class="custom-control-input" id="tulang_sapi"
                                       {{ in_array('Tulang Sapi', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="tulang_sapi">Tulang Sapi</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Jeroan"
                                       class="custom-control-input" id="jeroan"
                                       {{ in_array('Jeroan', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="jeroan">Jeroan</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="produk[]" value="Kepala"
                                       class="custom-control-input" id="kepala"
                                       {{ in_array('Kepala', $produks) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="kepala">Kepala</label>
                            </div>
                            @error('produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
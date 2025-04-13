@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Muzakki</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Muzakki</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('muzakki.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_muzakki">No Muzakki</label>
                            <input type="text" name="no_muzakki" class="form-control" id="no_muzakki"
                                value="{{ $newNoMuzakki }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="nama_muzakki">Nama Muzakki</label>
                            <input type="text" name="nama_muzakki" 
                                class="form-control @error('nama_muzakki') is-invalid @enderror" 
                                id="nama_muzakki" value="{{ old('nama_muzakki') }}" required>
                            @error('nama_muzakki')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telp_muzakki">No. Telepon</label>
                            <input type="text" name="telp_muzakki" 
                                class="form-control @error('telp_muzakki') is-invalid @enderror" 
                                id="telp_muzakki" value="{{ old('telp_muzakki') }}" 
                                required maxlength="13">
                            @error('telp_muzakki')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat_muzakki">Alamat</label>
                            <textarea name="alamat_muzakki" 
                                class="form-control @error('alamat_muzakki') is-invalid @enderror" 
                                id="alamat_muzakki" rows="3" required>{{ old('alamat_muzakki') }}</textarea>
                            @error('alamat_muzakki')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('muzakki.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Optional: Add phone number formatting
    document.getElementById('telp_muzakki').addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
    });
</script>
@endpush
@endsection
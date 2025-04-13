@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Petugas</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Form to Add Petugas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Petugas</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id">ID Petugas</label>
                            <input type="text" class="form-control" id="id" value="{{ $nextId }}" disabled>
                            <input type="hidden" name="id" value="{{ $nextId }}">
                        </div>

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                name="jabatan" required>
                                <option value="">Pilih Jabatan</option>
                                <option value="Bendahara DKM" {{ old('jabatan') == 'Bendahara DKM' ? 'selected' : '' }}>
                                    Bendahara DKM</option>
                                <option value="Petugas Qurban"
                                    {{ old('jabatan') == 'Petugas Qurban' ? 'selected' : '' }}>
                                    Petugas Qurban</option>
                                <option value="Ketua DKM" {{ old('jabatan') == 'Ketua DKM' ? 'selected' : '' }}>Ketua
                                    DKM</option>
                            </select>
                            @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Show Password Toggle -->
                        <div class="form-group">
                            <input type="checkbox" id="showPassword">
                            <label for="showPassword">Tampilkan Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Toggle password visibility
document.getElementById('showPassword').addEventListener('change', function() {
    var passwordField = document.getElementById('password');
    var passwordConfirmationField = document.getElementById('password_confirmation');
    if (this.checked) {
        passwordField.type = 'text';
        passwordConfirmationField.type = 'text';
    } else {
        passwordField.type = 'password';
        passwordConfirmationField.type = 'password';
    }
});
</script>
@endsection

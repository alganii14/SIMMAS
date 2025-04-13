@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Donatur</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Donatur</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('donatur.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_donatur">No Donatur</label>
                            <input type="text" name="no_donatur" class="form-control" id="no_donatur"
                                value="{{ $newNoDonatur }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Donatur</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Donatur"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" id="no_telepon"
                                placeholder="No Telepon" required>
                        </div>
                        <!-- Tambahkan field Email (optional) -->
                        <div class="form-group">
                            <label for="email">Email <small class="text-muted">(opsional)</small></label>
                            <input type="email" name="email" class="form-control" id="email" 
                                placeholder="Email">
                        </div>
                        <!-- Tambahkan field Anonim (optional) -->
                        <div class="form-group">
                            <label for="anonim">Status Anonim <small class="text-muted">(opsional)</small></label>
                            <select name="anonim" class="form-control" id="anonim">
                                <option value="tidak" selected>Tidak</option>
                                <option value="ya">Ya (Tampilkan sebagai "Sahabat")</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <select name="pekerjaan" class="form-control" id="pekerjaan" required>
                                <option value="" disabled selected>Pilih Pekerjaan</option>
                                @php
                                $pekerjaan = [
                                "BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA",
                                "PENSIUNAN", "PEGAWAI NEGERI SIPIL", "TENTARA NASIONAL INDONESIA",
                                "KEPOLISIAN RI", "PERDAGANGAN", "PETANI/PEKEBUN", "PETERNAK",
                                "NELAYAN/PERIKANAN", "KARYAWAN SWASTA", "KARYAWAN BUMN", "KARYAWAN BUMD",
                                "KARYAWAN HONORER", "BURUH", "PEMBANTU RUMAH TANGGA", "TUKANG CUKUR",
                                "TUKANG LISTRIK", "TUKANG BATU", "TUKANG KAYU", "TUKANG SOL SEPATU",
                                "TUKANG LASIPANDAI BESI", "TUKANG GIGI", "SENIMAN", "PENTERJEMAH",
                                "WARTAWAN", "WIRASWASTA", "LAINNYA", "TUKANG JAHIT"
                                ];
                                @endphp
                                @foreach($pekerjaan as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
    <label for="pesan_doa">Pesan/Doa <small class="text-muted">(opsional)</small></label>
    <textarea name="pesan_doa" class="form-control" id="pesan_doa" placeholder="Pesan atau doa"
        rows="3"></textarea>
</div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('donatur.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Data Infaq</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Data Infaq</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('infaq.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_penerimaan">No. Penerimaan</label>
                            <input type="text" class="form-control" id="no_penerimaan" name="no_penerimaan" value="{{ old('no_penerimaan', $no_penerimaan) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="time" class="form-control" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="petugas_id">Petugas</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="donatur_id">Donatur</label>
                            <select class="form-control" id="donatur_id" name="donatur_id" required>
                                <option value="" disabled selected>- Pilih Donatur -</option>
                                @foreach ($donaturs as $donatur)
                                    <option value="{{ $donatur->id }}"
                                            data-telp="{{ $donatur->no_telepon }}"
                                            data-pekerjaan="{{ $donatur->pekerjaan }}"
                                            data-alamat="{{ $donatur->alamat }}">
                                            {{ $donatur->no_donatur }} - {{ $donatur->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" readonly>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenis_penerimaan">Jenis Penerimaan</label>
                            <select class="form-control" id="jenis_penerimaan" name="jenis_penerimaan" required>
                                <option value="" disabled selected>- Pilih Jenis Penerimaan -</option>
                                <option value="Transfer" {{ old('jenis_penerimaan') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="QRIS" {{ old('jenis_penerimaan') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                <option value="Kotak Amal" {{ old('jenis_penerimaan') == 'Kotak Amal' ? 'selected' : '' }}>Kotak Amal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah (Rp)</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('infaq.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Set Tanggal otomatis ke hari ini
    document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];

    // Set Waktu otomatis ke saat ini dalam format yang benar (HH:mm)
let currentTime = new Date().toTimeString().split(' ')[0].substring(0, 5);
document.getElementById('waktu').value = currentTime;


    document.getElementById('donatur_id').addEventListener('change', function() {
        // Ambil data dari pilihan donatur
        const selectedOption = this.options[this.selectedIndex];
        const telp = selectedOption.getAttribute('data-telp');
        const pekerjaan = selectedOption.getAttribute('data-pekerjaan');
        const alamat = selectedOption.getAttribute('data-alamat');

        // Masukkan data ke input form
        document.getElementById('no_telp').value = telp;
        document.getElementById('pekerjaan').value = pekerjaan;
        document.getElementById('alamat').value = alamat;
    });
</script>

@endsection

@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Zakat</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Zakat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('zakat.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_zakat">No Zakat</label>
                            <input type="text" name="no_zakat" class="form-control" id="no_zakat" value="{{ $no_zakat }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_zakat">Tanggal</label>
                            <input type="date" name="tanggal_zakat" class="form-control" id="tanggal_zakat" required>
                        </div>

                        <div class="form-group">
                            <label for="jam_zakat">Jam</label>
                            <input type="time" name="jam_zakat" class="form-control" id="jam_zakat" required>
                        </div>

                        <div class="form-group">
                            <label for="no_muzakki">Muzakki</label>
                            <select name="no_muzakki" class="form-control" id="no_muzakki" required>
                                <option value="">Pilih Muzakki</option>
                                @foreach($muzakkis as $muzakki)
                                    <option value="{{ $muzakki->no_muzakki }}">
                                        {{ $muzakki->no_muzakki }} - {{ $muzakki->nama_muzakki }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jenis_zakat">Jenis Zakat</label>
                            <select name="jenis_zakat" class="form-control" id="jenis_zakat" required>
                                <option value="">Pilih Jenis Zakat</option>
                                <option value="Zakat Fitrah">Zakat Fitrah</option>
                                <option value="Zakat Mal">Zakat Mal</option>
                                <option value="Zakat Fidyah">Zakat Fidyah</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jenis_bayar">Jenis Bayar</label>
                            <select name="jenis_bayar" class="form-control" id="jenis_bayar" required>
                                <option value="">Pilih Jenis Bayar</option>
                                <option value="uang">Uang</option>
                                <option value="beras">Beras</option>
                            </select>
                        </div>

                        <!-- Zakat Fitrah Fields -->
                        <div id="zakatFitrahFields" style="display: none;">
                            <div class="form-group">
                                <label for="harga_beras">Harga Beras / 1 kg</label>
                                <input type="text" class="form-control" id="harga_beras" value="14000" readonly>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_keluarga">Jumlah Keluarga</label>
                                <input type="number" class="form-control" id="jumlah_keluarga" value="1">
                            </div>
                            <button type="button" class="btn btn-primary" id="hitungZakat">Hitung</button>
                            <input type="text" class="form-control mt-2" id="jumlah_bayar" readonly>
                            <button type="button" class="btn btn-info mt-2" id="ambilData">Ambil Data</button>
                        </div>

                        <!-- Zakat Mal Fields -->
                        <div id="zakatMalFields" style="display: none;">
                            <div class="form-group">
                                <label for="hartaMal">Jumlah Harta</label>
                                <input type="text" class="form-control" id="hartaMal" placeholder="Masukkan jumlah harta">
                            </div>
                            <button type="button" class="btn btn-primary" id="hitungMal">Hitung Zakat Mal</button>
                            <div id="resultMal" class="mt-2"></div>
                        </div>

                        <!-- Zakat Fidyah Fields -->
                        <div id="zakatFidyahFields" style="display: none;">
                            <div class="form-group">
                                <label for="hariFidyah">Jumlah Hari</label>
                                <input type="number" class="form-control" id="hariFidyah" placeholder="Masukkan jumlah hari">
                            </div>
                            <button type="button" class="btn btn-primary" id="hitungFidyah">Hitung Fidyah</button>
                            <div id="resultFidyah" class="mt-2"></div>
                        </div>

                        <div class="form-group" id="beratBerasContainer" style="display: none;">
                            <label for="berat_beras">Berat Beras (kg)</label>
                            <input type="number" name="berat_beras" class="form-control" id="berat_beras" step="0.01">
                        </div>

                        <!-- Zakat Input Fields -->
                        <br>
                        <div class="form-group" id="jumlahZakatContainer" style="display: none;">
                            <label for="jumlah_zakat">Jumlah Zakat</label>
                            <input type="number" name="jumlah_zakat" class="form-control" id="jumlah_zakat" required>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('zakat.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.getElementById('tanggal_zakat').value = new Date().toISOString().split('T')[0];
    const now = new Date();
    document.getElementById('jam_zakat').value = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

    document.getElementById('jenis_zakat').addEventListener('change', function () {
        const zakatType = this.value;
        const zakatFitrahFields = document.getElementById('zakatFitrahFields');
        const zakatMalFields = document.getElementById('zakatMalFields');
        const zakatFidyahFields = document.getElementById('zakatFidyahFields');
        const jumlahZakatContainer = document.getElementById('jumlahZakatContainer');

        if (zakatType === 'Zakat Fitrah') {
            zakatFitrahFields.style.display = 'block';
            zakatMalFields.style.display = 'none';
            zakatFidyahFields.style.display = 'none';
            jumlahZakatContainer.style.display = 'none';
        } else if (zakatType === 'Zakat Mal') {
            zakatFitrahFields.style.display = 'none';
            zakatMalFields.style.display = 'block';
            zakatFidyahFields.style.display = 'none';
            jumlahZakatContainer.style.display = 'none';
        } else if (zakatType === 'Zakat Fidyah') {
            zakatFitrahFields.style.display = 'none';
            zakatMalFields.style.display = 'none';
            zakatFidyahFields.style.display = 'block';
            jumlahZakatContainer.style.display = 'none';
        } else {
            zakatFitrahFields.style.display = 'none';
            zakatMalFields.style.display = 'none';
            zakatFidyahFields.style.display = 'none';
            jumlahZakatContainer.style.display = 'none';
        }
    });

    document.getElementById('hitungZakat').addEventListener('click', function () {
        const hargaBeras = 14000;
        const jumlahKeluarga = parseInt(document.getElementById('jumlah_keluarga').value) || 1;
        const totalBayar = hargaBeras * 2.5 * jumlahKeluarga;
        document.getElementById('jumlah_bayar').value = totalBayar.toLocaleString('id-ID');
        // Set the calculated value into jumlah_zakat field
        document.getElementById('jumlah_zakat').value = totalBayar;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    document.getElementById('ambilData').addEventListener('click', function () {
        document.getElementById('jumlah_zakat').value = document.getElementById('jumlah_bayar').value.replace(/\./g, '');
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    // Calculate Zakat Mal
    document.getElementById('hitungMal').addEventListener('click', function () {
        let harta = parseInt(document.getElementById('hartaMal').value.replace(/\./g, '') || 0);
        let nisab = 85685972;
        let zakat = (harta >= nisab) ? harta * 0.025 : 0;
        document.getElementById('resultMal').innerText = formatRupiah(zakat);
        // Set the calculated value into jumlah_zakat field
        document.getElementById('jumlah_zakat').value = zakat;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    // Calculate Zakat Fidyah
    document.getElementById('hitungFidyah').addEventListener('click', function () {
        let hari = parseInt(document.getElementById('hariFidyah').value || 0);
        let fidyahPerHari = 15000;
        let totalFidyah = hari * fidyahPerHari;
        document.getElementById('resultFidyah').innerText = formatRupiah(totalFidyah);
        // Set the calculated value into jumlah_zakat field
        document.getElementById('jumlah_zakat').value = totalFidyah;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    // Function to format the amount as Rupiah
    function formatRupiah(amount) {
        return amount.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR'
        });
    }

    document.getElementById('jenis_bayar').addEventListener('change', function() {
        const jenisBayar = this.value;
        const beratBerasContainer = document.getElementById('beratBerasContainer');
        if (jenisBayar === 'beras') {
            beratBerasContainer.style.display = 'block';
        } else {
            beratBerasContainer.style.display = 'none';
        }
        updateBeratBeras();
    });

    function updateBeratBeras() {
        const jenisBayar = document.getElementById('jenis_bayar').value;
        const jumlahZakat = parseFloat(document.getElementById('jumlah_zakat').value) || 0;
        const beratBerasInput = document.getElementById('berat_beras');
        const jumlahZakatContainer = document.getElementById('jumlahZakatContainer');

        if (jenisBayar === 'beras') {
            const beratBeras = jumlahZakat / 14000; // Calculate kg of rice
            beratBerasInput.value = beratBeras.toFixed(2);
            beratBerasInput.readOnly = true; // Make it readonly as it's calculated
            jumlahZakatContainer.style.display = 'block';
        } else {
            beratBerasInput.value = '';
            jumlahZakatContainer.style.display = 'block';
        }
    }

    // Update berat_beras when jumlah_zakat changes
    document.getElementById('jumlah_zakat').addEventListener('input', updateBeratBeras);

    // Update berat_beras when jenis_bayar changes
    document.getElementById('jenis_bayar').addEventListener('change', function() {
        const jenisBayar = this.value;
        const beratBerasContainer = document.getElementById('beratBerasContainer');

        if (jenisBayar === 'beras') {
            beratBerasContainer.style.display = 'block';
            updateBeratBeras();
        } else {
            beratBerasContainer.style.display = 'none';
        }
    });

    // Additional handlers for the calculation buttons
    document.getElementById('hitungZakat').addEventListener('click', function() {
        const hargaBeras = 14000;
        const jumlahKeluarga = parseInt(document.getElementById('jumlah_keluarga').value) || 1;
        const totalBayar = hargaBeras * 2.5 * jumlahKeluarga;
        document.getElementById('jumlah_bayar').value = totalBayar.toLocaleString('id-ID');
        document.getElementById('jumlah_zakat').value = totalBayar;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    // Calculate Zakat Mal
    document.getElementById('hitungMal').addEventListener('click', function () {
        let harta = parseInt(document.getElementById('hartaMal').value.replace(/\./g, '') || 0);
        let nisab = 85685972;
        let zakat = (harta >= nisab) ? harta * 0.025 : 0;
        document.getElementById('resultMal').innerText = formatRupiah(zakat);
        // Set the calculated value into jumlah_zakat field
        document.getElementById('jumlah_zakat').value = zakat;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });

    // Calculate Zakat Fidyah
    document.getElementById('hitungFidyah').addEventListener('click', function () {
        let hari = parseInt(document.getElementById('hariFidyah').value || 0);
        let fidyahPerHari = 15000;
        let totalFidyah = hari * fidyahPerHari;
        document.getElementById('resultFidyah').innerText = formatRupiah(totalFidyah);
        // Set the calculated value into jumlah_zakat field
        document.getElementById('jumlah_zakat').value = totalFidyah;
        document.getElementById('jumlahZakatContainer').style.display = 'block';
        updateBeratBeras();
    });


</script>
@endsection


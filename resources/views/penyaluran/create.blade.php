@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Penyaluran Zakat</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Penyaluran Zakat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('penyaluran.store') }}" method="POST" id="penyaluranForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_penyaluran">Nomor Penyaluran</label>
                                    <input type="text" class="form-control" id="no_penyaluran" name="no_penyaluran" value="{{ $no_penyaluran }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_penyaluran">Tanggal Penyaluran</label>
                                    <input type="date" class="form-control" id="tanggal_penyaluran" name="tanggal_penyaluran" required>
                                </div>

                                <div class="form-group">
                                    <label for="jam_penyaluran">Jam Penyaluran</label>
                                    <input type="time" class="form-control" id="jam_penyaluran" name="jam_penyaluran" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_zakat">Jenis Zakat</label>
                                    <select class="form-control" id="jenis_zakat" name="jenis_zakat" required>
                                        <option value="">Pilih Jenis Zakat</option>
                                        @foreach($jenis_zakats as $jenis)
                                            <option value="{{ $jenis }}">{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Informasi Saldo -->
                                <div id="info-saldo" class="mb-3" style="display: none;">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Informasi Saldo</h5>
                                            <div id="saldo-uang-container">
                                                <p>Saldo Uang: <span id="saldo-uang">Rp 0</span></p>
                                            </div>
                                            <div id="saldo-beras-container" style="display: none;">
                                                <p>Saldo Beras: <span id="saldo-beras">0 kg</span> (Rp <span id="nilai-beras">0</span>)</p>
                                            </div>
                                            <p>Total Saldo: <span id="total-saldo">Rp 0</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="total_penyaluran">Total Penyaluran</label>
                                    <input type="number" class="form-control" id="total_penyaluran" name="total_penyaluran" required>
                                </div>

                                <div class="form-group">
                                    <label for="status_penyaluran">Status Penyaluran</label>
                                    <select class="form-control" id="status_penyaluran" name="status_penyaluran" required>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Dibatalkan">Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>

                        <!-- Kalkulator Penyaluran -->
                        <div class="mt-4 card">
                            <div class="card-header">
                                <h3 class="card-title">Kalkulator Penyaluran Zakat</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="persentase_fakir_miskin">Persentase Fakir/Miskin (%)</label>
                                            <input type="number" class="form-control" id="persentase_fakir_miskin" name="persentase_fakir_miskin" value="65" min="0" max="100" step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="persentase_amilin">Persentase Amilin (%)</label>
                                            <input type="number" class="form-control" id="persentase_amilin" name="persentase_amilin" value="35" min="0" max="100" step="0.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">Bagian Fakir/Miskin (<span id="persen_fakir_miskin">65</span>%)</span>
                                                <span class="info-box-number" id="bagianFakirMiskin">0</span>
                                                <div id="bagianFakirMiskinBeras" style="display: none;">
                                                    <small>Setara dengan: <span id="berasFakirMiskin">0</span> kg beras</small>
                                                </div>
                                                <small>Bagian per KK: <span id="bagianPerKK">0</span></small>
                                                <div id="bagianPerKKBeras" style="display: none;">
                                                    <small>Setara dengan: <span id="berasPerKK">0</span> kg beras</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">Bagian Amilin (<span id="persen_amilin">35</span>%)</span>
                                                <span class="info-box-number" id="bagianAmilin">0</span>
                                                <div id="bagianAmilinBeras" style="display: none;">
                                                    <small>Setara dengan: <span id="berasAmilin">0</span> kg beras</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Penerima Zakat -->
                        <div class="mt-4 card">
                            <div class="card-header">
                                <h3 class="card-title">Penerima Zakat</h3>
                            </div>
                            <div class="card-body">
                                <div id="penerima-container">
                                    <!-- Penerima rows will be added here -->
                                </div>
                                <button type="button" class="btn btn-success" id="tambah-penerima">
                                    <i class="fas fa-plus"></i> Tambah Penerima
                                </button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('penyaluran.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let counter = 0;
        const container = document.getElementById('penerima-container');
        const form = document.getElementById('penyaluranForm');
        let selectedMustahiks = new Set();
        let mustahikData = @json($mustahiks);

        // Saldo per jenis zakat
        const saldoPerJenisZakat = @json($saldoPerJenisZakat);

        // Untuk menyimpan data perhitungan distribusi
        let distributionData = {
            fakirMiskin: 0,
            amilin: 0,
            perKK: 0,
            perAmilin: 0,
            berasFakirMiskin: 0,
            berasAmilin: 0,
            berasPerKK: 0
        };

        // Flag untuk menyimpan apakah jenis zakat saat ini memiliki beras
        let hasBeras = false;

        // Nilai beras per kg
        const nilaiBerasPerKg = 14000;

        // Debugging
        console.log('Saldo Per Jenis Zakat:', saldoPerJenisZakat);

        // Set default date and time
        document.querySelector('input[name="tanggal_penyaluran"]').value = new Date().toISOString().split('T')[0];
        document.querySelector('input[name="jam_penyaluran"]').value = new Date().toLocaleTimeString('en-GB').slice(0, 5);

        // Validasi persentase agar total selalu 100%
        function validatePercentages() {
            const persentaseFakirMiskin = parseFloat(document.getElementById('persentase_fakir_miskin').value) || 0;
            const persentaseAmilin = parseFloat(document.getElementById('persentase_amilin').value) || 0;

            const total = persentaseFakirMiskin + persentaseAmilin;

            // Update display
            document.getElementById('persen_fakir_miskin').textContent = persentaseFakirMiskin.toFixed(1);
            document.getElementById('persen_amilin').textContent = persentaseAmilin.toFixed(1);

            // Recalculate distribution
            calculateDistribution();

            return total === 100;
        }

        // Add event listeners for percentage inputs
        document.getElementById('persentase_fakir_miskin').addEventListener('input', function() {
            const persentaseFakirMiskin = parseFloat(this.value) || 0;

            // Auto-adjust amilin to make total 100%
            const persentaseAmilin = 100 - persentaseFakirMiskin;
            document.getElementById('persentase_amilin').value = Math.max(0, persentaseAmilin.toFixed(1));

            validatePercentages();
        });

        document.getElementById('persentase_amilin').addEventListener('input', function() {
            const persentaseAmilin = parseFloat(this.value) || 0;

            // Auto-adjust fakir/miskin to make total 100%
            const persentaseFakirMiskin = 100 - persentaseAmilin;
            document.getElementById('persentase_fakir_miskin').value = Math.max(0, persentaseFakirMiskin.toFixed(1));

            validatePercentages();
        });

        // Auto-fill total_penyaluran when jenis_zakat changes
        document.getElementById('jenis_zakat').addEventListener('change', function() {
            const jenisZakat = this.value;
            const totalPenyaluranInput = document.getElementById('total_penyaluran');
            const infoSaldo = document.getElementById('info-saldo');
            const saldoUangContainer = document.getElementById('saldo-uang-container');
            const saldoBerasContainer = document.getElementById('saldo-beras-container');
            const saldoUangSpan = document.getElementById('saldo-uang');
            const saldoBerasSpan = document.getElementById('saldo-beras');
            const nilaiBerasSpan = document.getElementById('nilai-beras');
            const totalSaldoSpan = document.getElementById('total-saldo');

            // Reset tampilan beras
            hasBeras = false;

            if (jenisZakat && saldoPerJenisZakat[jenisZakat]) {
                // Tampilkan informasi saldo
                infoSaldo.style.display = 'block';

                // Tampilkan saldo uang
                saldoUangSpan.textContent = formatRupiah(saldoPerJenisZakat[jenisZakat].uang);

                // Tampilkan saldo beras jika ada
                if (saldoPerJenisZakat[jenisZakat].beras > 0) {
                    saldoBerasContainer.style.display = 'block';
                    saldoBerasSpan.textContent = saldoPerJenisZakat[jenisZakat].beras.toFixed(2) + ' kg';
                    nilaiBerasSpan.textContent = formatRupiah(saldoPerJenisZakat[jenisZakat].nilai_beras);
                    hasBeras = true;
                } else {
                    saldoBerasContainer.style.display = 'none';
                }

                // Tampilkan total saldo
                totalSaldoSpan.textContent = formatRupiah(saldoPerJenisZakat[jenisZakat].total);

                // Isi total penyaluran dengan total saldo
                totalPenyaluranInput.value = saldoPerJenisZakat[jenisZakat].total;
                calculateDistribution();
            } else {
                infoSaldo.style.display = 'none';
                totalPenyaluranInput.value = '';
            }
        });

        function calculateDistribution() {
            const totalPenyaluran = parseFloat(document.getElementById('total_penyaluran').value) || 0;

            // Get percentages from inputs
            const persentaseFakirMiskin = parseFloat(document.getElementById('persentase_fakir_miskin').value) / 100 || 0.65;
            const persentaseAmilin = parseFloat(document.getElementById('persentase_amilin').value) / 100 || 0.35;

            // Calculate portions with configurable percentages
            const bagianFakirMiskin = totalPenyaluran * persentaseFakirMiskin;
            const bagianAmilin = totalPenyaluran * persentaseAmilin;

            // Simpan data distribusi
            distributionData.fakirMiskin = bagianFakirMiskin;
            distributionData.amilin = bagianAmilin;
            distributionData.sisaZakat = 0; // Set to 0 since we're not using it anymore

            // Count Fakir/Miskin recipients
            const fakirMiskinSelects = Array.from(container.querySelectorAll('.mustahik-select')).filter(select => {
                if (!select.value) return false;
                const mustahik = mustahikData.find(m => m.no_mustahik === select.value);
                return mustahik && (mustahik.asnaf === 'Fakir' || mustahik.asnaf === 'Miskin');
            });

            // Count Amilin recipients
            const amilinSelects = Array.from(container.querySelectorAll('.mustahik-select')).filter(select => {
                if (!select.value) return false;
                const mustahik = mustahikData.find(m => m.no_mustahik === select.value);
                return mustahik && (mustahik.asnaf === 'Amilin' || mustahik.asnaf === 'Amilin Lainnya');
            });

            const fakirMiskinCount = fakirMiskinSelects.length || 1; // Prevent division by zero
            const amilinCount = amilinSelects.length || 1; // Prevent division by zero

            // Calculate base amount per KK for Amilin
            const bagianPerAmilin = bagianAmilin / amilinCount;

            // BARU: Kalkulator Fakir/Miskin dengan pembagian 70% rata dan 30% berdasarkan jumlah anak
            // Hitung total jumlah anak dari semua mustahik Fakir/Miskin
            let totalAnakFakirMiskin = 0;
            const fakirMiskinMustahiks = [];

            fakirMiskinSelects.forEach(select => {
                const mustahik = mustahikData.find(m => m.no_mustahik === select.value);
                if (mustahik) {
                    totalAnakFakirMiskin += parseInt(mustahik.jumlah_anak || 0);
                    fakirMiskinMustahiks.push(mustahik);
                }
            });

            // Bagian 70% dibagi rata
            const bagianRataFakirMiskin = bagianFakirMiskin * 0.7;
            // Bagian 30% berdasarkan jumlah anak
            const bagianAnakFakirMiskin = bagianFakirMiskin * 0.3;

            // Nilai per KK untuk bagian rata
            const nilaiRataPerKK = bagianRataFakirMiskin / fakirMiskinCount;

            // Nilai per anak (jika ada anak)
            const nilaiPerAnak = totalAnakFakirMiskin > 0 ? bagianAnakFakirMiskin / totalAnakFakirMiskin : 0;

            // Simpan data per-KK untuk Amilin
            distributionData.perAmilin = bagianPerAmilin;

            // Hitung setara beras jika ada
            if (hasBeras) {
                distributionData.berasFakirMiskin = bagianFakirMiskin / nilaiBerasPerKg;
                distributionData.berasAmilin = bagianAmilin / nilaiBerasPerKg;
                distributionData.berasPerKK = nilaiRataPerKK / nilaiBerasPerKg;

                // Tampilkan informasi beras
                document.getElementById('bagianFakirMiskinBeras').style.display = 'block';
                document.getElementById('bagianAmilinBeras').style.display = 'block';
                document.getElementById('bagianPerKKBeras').style.display = 'block';

                document.getElementById('berasFakirMiskin').textContent = distributionData.berasFakirMiskin.toFixed(2);
                document.getElementById('berasAmilin').textContent = distributionData.berasAmilin.toFixed(2);
                document.getElementById('berasPerKK').textContent = distributionData.berasPerKK.toFixed(2);
            } else {
                // Sembunyikan informasi beras
                document.getElementById('bagianFakirMiskinBeras').style.display = 'none';
                document.getElementById('bagianAmilinBeras').style.display = 'none';
                document.getElementById('bagianPerKKBeras').style.display = 'none';
            }

            // Update display
            document.getElementById('bagianFakirMiskin').textContent = formatRupiah(bagianFakirMiskin);
            document.getElementById('bagianAmilin').textContent = formatRupiah(bagianAmilin);
            document.getElementById('bagianPerKK').textContent = formatRupiah(nilaiRataPerKK);

            // Update jumlah_terima for each recipient
            container.querySelectorAll('.row').forEach(row => {
                const select = row.querySelector('.mustahik-select');
                const jumlahInput = row.querySelector('input[name$="[jumlah_terima]"]');
                const berasInfoDiv = row.querySelector('.beras-info');
                const jenisTerimaSelect = row.querySelector('select[name$="[jenis_terima]"]');

                if (select.value) {
                    const mustahik = mustahikData.find(m => m.no_mustahik === select.value);

                    if (mustahik) {
                        console.log('Processing mustahik:', mustahik.nama_mustahik, 'Asnaf:', mustahik.asnaf);

                        let jumlah = 0;
                        let berasEquivalent = 0;

                        if (mustahik.asnaf === 'Fakir' || mustahik.asnaf === 'Miskin') {
                            // BARU: Bagian untuk Fakir/Miskin dengan perhitungan 70% rata dan 30% berdasarkan anak
                            const jumlahAnak = parseInt(mustahik.jumlah_anak || 0);
                            const bagianRata = nilaiRataPerKK;
                            const bagianAnak = jumlahAnak * nilaiPerAnak;
                            jumlah = Math.round(bagianRata + bagianAnak);

                            console.log(`${mustahik.nama_mustahik}: Bagian rata: ${bagianRata}, Jumlah anak: ${jumlahAnak}, Bagian anak: ${bagianAnak}, Total: ${jumlah}`);

                            berasEquivalent = jumlah / nilaiBerasPerKg;
                        } else if (mustahik.asnaf === 'Amilin' || mustahik.asnaf === 'Amilin Lainnya') {
                            // Bagian untuk Amilin
                            jumlah = Math.round(bagianPerAmilin);
                            berasEquivalent = jumlah / nilaiBerasPerKg;
                            console.log('Amilin amount:', jumlah);
                        }

                        jumlahInput.value = jumlah;

                        // Update info beras
                        if (hasBeras && berasInfoDiv) {
                            berasInfoDiv.style.display = 'block';
                            berasInfoDiv.querySelector('.beras-equivalent').textContent = berasEquivalent.toFixed(2);

                            // Jika ada select jenis_terima, tampilkan opsi beras
                            if (jenisTerimaSelect) {
                                jenisTerimaSelect.innerHTML = `
                                    <option value="uang">Uang</option>
                                    <option value="beras">Beras</option>
                                `;
                            }
                        } else if (berasInfoDiv) {
                            berasInfoDiv.style.display = 'none';

                            // Jika ada select jenis_terima, hanya tampilkan opsi uang
                            if (jenisTerimaSelect) {
                                jenisTerimaSelect.innerHTML = '<option value="uang">Uang</option>';
                            }
                        }
                    } else {
                        console.log('Mustahik not found for:', select.value);
                        jumlahInput.value = '';
                        if (berasInfoDiv) berasInfoDiv.style.display = 'none';
                    }
                } else {
                    jumlahInput.value = '';
                    if (berasInfoDiv) berasInfoDiv.style.display = 'none';
                }
            });
        }

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        // Add event listener for total_penyaluran changes
        document.getElementById('total_penyaluran').addEventListener('input', calculateDistribution);

        function updateMustahikOptions() {
            const allSelects = container.querySelectorAll('select[name^="penerimas"][name$="[no_mustahik]"]');

            allSelects.forEach(select => {
                const currentValue = select.value;

                // Store all options
                const options = Array.from(select.options);

                // Hide selected options in all selects except current
                options.forEach(option => {
                    if (option.value && option.value !== currentValue) {
                        option.disabled = selectedMustahiks.has(option.value);
                    } else {
                        option.disabled = false;
                    }
                });
            });
        }

        function addPenerimaRow() {
            const row = document.createElement('div');
            row.className = 'row mb-3';
            row.innerHTML = `
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Mustahik</label>
                        <select class="form-control mustahik-select" name="penerimas[${counter}][no_mustahik]" required>
                            <option value="">Pilih Mustahik</option>
                            @foreach($mustahiks as $mustahik)
                                <option value="{{ $mustahik->no_mustahik }}"
                                        data-asnaf="{{ $mustahik->asnaf }}"
                                        data-jumlah-anak="{{ $mustahik->jumlah_anak }}">
                                    {{ $mustahik->nama_mustahik }} ({{ $mustahik->asnaf }}) - {{ $mustahik->jumlah_anak }} Anak
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jumlah Terima</label>
                        <input type="number" class="form-control jumlah-terima" name="penerimas[${counter}][jumlah_terima]" required>
                        <div class="beras-info mt-1" style="display: none;">
                            <small class="text-muted">Setara dengan <span class="beras-equivalent">0</span> kg beras</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jenis Terima</label>
                        <select class="form-control" name="penerimas[${counter}][jenis_terima]" required>
                            <option value="uang">Uang</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-block hapus-penerima">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(row);

            // Add change event listener to new select
            const newSelect = row.querySelector('.mustahik-select');
            newSelect.addEventListener('change', function() {
                const oldValue = this.dataset.previousValue;
                const newValue = this.value;

                // Remove old value from selected set if it exists
                if (oldValue) {
                    selectedMustahiks.delete(oldValue);
                }

                // Add new value to selected set if it's not empty
                if (newValue) {
                    selectedMustahiks.add(newValue);
                    console.log('Selected mustahik:', newValue);

                    // Get the mustahik data
                    const mustahik = mustahikData.find(m => m.no_mustahik === newValue);
                    if (mustahik) {
                        console.log('Mustahik found:', mustahik.nama_mustahik, 'Asnaf:', mustahik.asnaf, 'Jumlah Anak:', mustahik.jumlah_anak);
                    } else {
                        console.log('Mustahik not found for:', newValue);
                    }
                }

                // Store current value as previous value for next change
                this.dataset.previousValue = newValue;

                updateMustahikOptions();
                calculateDistribution();
            });

            // Add event listener to delete button
            row.querySelector('.hapus-penerima').addEventListener('click', function() {
                const select = this.closest('.row').querySelector('.mustahik-select');
                const value = select.value;
                if (value) {
                    selectedMustahiks.delete(value);
                }
                this.closest('.row').remove();
                updateMustahikOptions();
                calculateDistribution();
            });

            counter++;
            updateMustahikOptions();
        }

        // Add first row on page load
        addPenerimaRow();

        // Add row when button is clicked
        document.getElementById('tambah-penerima').addEventListener('click', addPenerimaRow);

        // Form validation
        form.addEventListener('submit', function(e) {
            const rows = container.children.length;
            if (rows === 0) {
                e.preventDefault();
                alert('Minimal harus ada satu Penerima Zakat!');
            }

            // Validate percentages
            if (!validatePercentages()) {
                e.preventDefault();
                alert('Total persentase harus 100%!');
            }
        });

        // Initialize percentages
        validatePercentages();
    });
    </script>
@endsection

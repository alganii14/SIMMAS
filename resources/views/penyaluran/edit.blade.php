@extends('layouts.master')

@section('konten')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Penyaluran Zakat</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Penyaluran Zakat</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('penyaluran.update', $penyaluran->no_penyaluran) }}" method="POST" id="penyaluranForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_penyaluran">Nomor Penyaluran</label>
                                    <input type="text" class="form-control" id="no_penyaluran" value="{{ $penyaluran->no_penyaluran }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_penyaluran">Tanggal Penyaluran</label>
                                    <input type="date" class="form-control" id="tanggal_penyaluran" name="tanggal_penyaluran" value="{{ $penyaluran->tanggal_penyaluran }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="jam_penyaluran">Jam Penyaluran</label>
                                    <input type="time" class="form-control" id="jam_penyaluran" name="jam_penyaluran" value="{{ $penyaluran->jam_penyaluran }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_zakat">Jenis Zakat</label>
                                    <select class="form-control" id="jenis_zakat" name="jenis_zakat" required>
                                        <option value="">Pilih Jenis Zakat</option>
                                        @foreach($jenis_zakats as $jenis)
                                            <option value="{{ $jenis }}" {{ $penyaluran->jenis_zakat == $jenis ? 'selected' : '' }}>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="total_penyaluran">Total Penyaluran</label>
                                    <input type="number" class="form-control" id="total_penyaluran" name="total_penyaluran" value="{{ $penyaluran->total_penyaluran }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="status_penyaluran">Status Penyaluran</label>
                                    <select class="form-control" id="status_penyaluran" name="status_penyaluran" required>
                                        <option value="Selesai" {{ $penyaluran->status_penyaluran == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Pending" {{ $penyaluran->status_penyaluran == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Dibatalkan" {{ $penyaluran->status_penyaluran == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $penyaluran->keterangan }}</textarea>
                        </div>

                        <!-- Kalkulator Penyaluran -->
                        <div class="mt-4 card">
                            <div class="card-header">
                                <h3 class="card-title">Kalkulator Penyaluran Zakat</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">Bagian Fakir/Miskin (62.5%)</span>
                                                <span class="info-box-number" id="bagianFakirMiskin">0</span>
                                                <small>Bagian per KK: <span id="bagianPerKK">0</span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <div class="info-box-content">
                                                <span class="info-box-text">Bagian Amilin (37.5%)</span>
                                                <span class="info-box-number" id="bagianAmilin">0</span>
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
                                    @foreach($penyaluran->penerimas as $index => $penerima)
                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Mustahik</label>
                                                <select class="form-control mustahik-select" name="penerimas[{{ $index }}][no_mustahik]" required>
                                                    <option value="">Pilih Mustahik</option>
                                                    @foreach($mustahiks as $mustahik)
                                                        <option value="{{ $mustahik->no_mustahik }}"
                                                            {{ $penerima->no_mustahik == $mustahik->no_mustahik ? 'selected' : '' }}
                                                            data-asnaf="{{ $mustahik->asnaf }}"
                                                            data-jumlah-anak="{{ $mustahik->jumlah_anak }}">
                                                            {{ $mustahik->nama_mustahik }} ({{ $mustahik->asnaf }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Jumlah Terima</label>
                                                <input type="number" class="form-control"
                                                       name="penerimas[{{ $index }}][jumlah_terima]"
                                                       value="{{ $penerima->jumlah_terima }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-block hapus-penerima">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success" id="tambah-penerima">
                                    <i class="fas fa-plus"></i> Tambah Penerima
                                </button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    let counter = {{ count($penyaluran->penerimas) }};
    const container = document.getElementById('penerima-container');
    const form = document.getElementById('penyaluranForm');
    let selectedMustahiks = new Set();
    let mustahikData = @json($mustahiks);

    // Initialize selected mustahiks from existing data
    document.querySelectorAll('.mustahik-select').forEach(select => {
        if (select.value) {
            selectedMustahiks.add(select.value);
            select.dataset.previousValue = select.value;
        }
    });

    function calculateDistribution() {
        const totalPenyaluran = parseFloat(document.getElementById('total_penyaluran').value) || 0;

        // Calculate portions
        const bagianFakirMiskin = totalPenyaluran * 0.625;
        const bagianAmilin = totalPenyaluran * 0.375;

        // Count Fakir/Miskin recipients
        const fakirMiskinCount = Array.from(container.querySelectorAll('.mustahik-select')).filter(select => {
            const mustahik = mustahikData.find(m => m.no_mustahik === select.value);
            return mustahik && mustahik.asnaf === 'Fakir/Miskin';
        }).length || 1; // Prevent division by zero

        // Calculate base amount per KK
        const bagianPerKK = bagianFakirMiskin / fakirMiskinCount;

        // Update display
        document.getElementById('bagianFakirMiskin').textContent = formatRupiah(bagianFakirMiskin);
        document.getElementById('bagianAmilin').textContent = formatRupiah(bagianAmilin);
        document.getElementById('bagianPerKK').textContent = formatRupiah(bagianPerKK);

        // Update jumlah_terima for each recipient
        container.querySelectorAll('.row').forEach(row => {
            const select = row.querySelector('.mustahik-select');
            const jumlahInput = row.querySelector('input[name$="[jumlah_terima]"]');
            const mustahik = mustahikData.find(m => m.no_mustahik === select.value);

            if (mustahik) {
                let jumlah = 0;
                if (mustahik.asnaf === 'Fakir/Miskin') {
                    // Calculate with children
                    const baseAmount = bagianPerKK;
                    const childrenBonus = mustahik.jumlah_anak > 0 ? (baseAmount / mustahik.jumlah_anak) : 0;
                    jumlah = baseAmount + childrenBonus;
                } else if (mustahik.asnaf === 'Amilin' || mustahik.asnaf === 'Amilin Lainnya') {
                    jumlah = bagianAmilin;
                }
                jumlahInput.value = Math.round(jumlah);
            }
        });
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mustahik</label>
                    <select class="form-control mustahik-select" name="penerimas[${counter}][no_mustahik]" required>
                        <option value="">Pilih Mustahik</option>
                        @foreach($mustahiks as $mustahik)
                            <option value="{{ $mustahik->no_mustahik }}"
                                    data-asnaf="{{ $mustahik->asnaf }}"
                                    data-jumlah-anak="{{ $mustahik->jumlah_anak }}">
                                {{ $mustahik->nama_mustahik }} ({{ $mustahik->asnaf }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Jumlah Terima</label>
                    <input type="number" class="form-control" name="penerimas[${counter}][jumlah_terima]" required>
                </div>
            </div>
            <div class="col-md-1">
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

    // Add event listeners to existing delete buttons and select fields
    document.querySelectorAll('.hapus-penerima').forEach(button => {
        button.addEventListener('click', function() {
            const select = this.closest('.row').querySelector('.mustahik-select');
            const value = select.value;
            if (value) {
                selectedMustahiks.delete(value);
            }
            this.closest('.row').remove();
            updateMustahikOptions();
            calculateDistribution();
        });
    });

    document.querySelectorAll('.mustahik-select').forEach(select => {
        select.addEventListener('change', function() {
            const oldValue = this.dataset.previousValue;
            const newValue = this.value;

            if (oldValue) {
                selectedMustahiks.delete(oldValue);
            }
            if (newValue) {
                selectedMustahiks.add(newValue);
            }

            this.dataset.previousValue = newValue;
            updateMustahikOptions();
            calculateDistribution();
        });
    });

    // Initial update of options and calculations
    updateMustahikOptions();
    calculateDistribution();

    // Add row when button is clicked
    document.getElementById('tambah-penerima').addEventListener('click', addPenerimaRow);

    // Form validation
    form.addEventListener('submit', function(e) {
        const rows = container.children.length;
        if (rows === 0) {
            e.preventDefault();
            alert('Minimal harus ada satu Penerima Zakat!');
        }
    });
});
</script>
@endsection


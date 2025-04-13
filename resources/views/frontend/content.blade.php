@if(isset($success))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $success }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Hero Section -->
<section id="home" class="slider-home-1 owl-carousel owl-theme">
    <div class="hero-section item">
        <img src="{{asset('masjid')}}/main_files/assets/img/masjid5.jpg" alt="hero-img" class="hero-img-style">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Selamat Datang di Masjid Khairul Amal</h1>
                        <a href="#prayer-times" class="btn">Lihat Jadwal Sholat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-section item">
        <img src="{{asset('masjid')}}/main_files/assets/img/masjid6.jpg" alt="hero-img" class="hero-img-style">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Jadwal Kajian Rutin</h1>
                        <p>Ikuti kajian rutin bersama ustadz-ustadz terpercaya untuk meningkatkan pemahaman Islam</p>
                        <a href="#kajian" class="btn">Lihat Jadwal Kajian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-section item">
        <img src="{{asset('masjid')}}/main_files/assets/img/masjid7.jpg" alt="hero-img" class="hero-img-style">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Mari Berinfaq</h1>
                        <p>Salurkan infaq dan sedekah Anda untuk pembangunan dan operasional masjid</p>
                        <a href="#infaq" class="btn">Infaq Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Prayer Times Section -->
<section id="prayer-times" class="gap no-top">
    <div class="container">
        <div class="namaz-timing">
            @foreach ($sholats as $sholat)
            <div class="namaz-time">
                <img src="{{ asset('masjid/main_files/assets/img/namaz-time-icon-' . $loop->iteration . '.png') }}" alt="icon">
                <h4>{{ $sholat->nama_sholat }}</h4>
                <h5>{{ \Carbon\Carbon::parse($sholat->waktu_sholat)->format('h:i A') }}
                    <span>Iqamah:{{ \Carbon\Carbon::parse($sholat->waktu_iqomah)->format('h:i A') }}</span>
                </h5>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Inventory Section -->
<section id="inventory" class="gap no-top">
    <div class="container">
        <div class="text-center heading">
            <img src="{{ asset('masjid/main_files/assets/img/heading-img.png') }}" alt="icon" class="mb-3 img-fluid" style="max-width: 100px;">
            <p class="text-uppercase text-muted">Informasi Inventory</p>
            <h2 class="fw-bold">Daftar Inventory</h2>
        </div>

        <div class="row">
            @foreach ($inventories as $inventory)
                <div class="mb-4 col-lg-4 col-md-6">
                    <div class="p-3 bg-white rounded shadow-sm blog hoverimg">
                        <h4 class="text-primary">{{ $inventory->kategori }}</h4>
                        <figure class="mb-3">
                            @if($inventory->gambar)
                                <img src="{{ asset('storage/' . $inventory->gambar) }}" alt="{{ $inventory->nama }}" class="rounded img-fluid" style="max-height: 260px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300" alt="No Image" class="rounded img-fluid" style="max-height: 260px; object-fit: cover;">
                            @endif
                        </figure>
                        <h5 class="fw-bold"><a href="#" class="text-dark">{{ $inventory->nama }}</a></h5>
                        <p class="text-muted">Kondisi: {{ $inventory->kondisi }}</p>
                        <div class="blog-man d-flex align-items-center">
                            <i class="me-3 fa-solid fa-cogs fa-2x text-emerald-600"></i>
                            <h6 class="mb-0">Kode: <span class="text-primary">{{ $inventory->kode }}</span></h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Add this CSS in your styles -->
<style>
    .inventory-slider {
        display: flex;
        overflow-x: auto; /* Allow horizontal scrolling */
        scroll-snap-type: x mandatory; /* Smooth scrolling */
    }

    .inventory-item {
        scroll-snap-align: start;
    }

    .inventory-slider::-webkit-scrollbar {
        height: 8px;
    }

    .inventory-slider::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .inventory-slider::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Styles for infaq balance card */
    .infaq-balance-card {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .infaq-balance-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .infaq-balance-card .amount {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .infaq-balance-card .description {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* Form Infaq Styles */
    .btn-check:checked + .btn-outline-success {
        background-color: #4CAF50;
        color: white;
    }

    .form-switch .form-check-input:checked {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .btn-success {
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #2E7D32, #1B5E20);
    }

    /* Styling untuk tombol nominal cepat */
    .nominal-btn {
        flex: 1;
        min-width: 100px;
        transition: all 0.2s;
    }

    .nominal-btn.active {
        background-color: #4CAF50;
        color: white;
        border-color: #4CAF50;
        transform: scale(1.05);
    }

    /* Lebih banyak style untuk form */
    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
    }
</style>

<!-- Kajian Section -->
<section id="kajian" class="gap no-top">
    <div class="container">
        <div class="text-center heading">
            <img src="{{ asset('masjid/main_files/assets/img/heading-img.png') }}" alt="icon" class="mb-3 img-fluid" style="max-width: 100px;">
            <p class="text-uppercase text-muted">Informasi Kegiatan</p>
            <h2 class="fw-bold">Kegiatan</h2>
        </div>

        <div class="row">
            @foreach ($kajians as $kajian)
                <div class="mb-4 col-lg-4 col-md-6">
                    <div class="p-3 bg-white rounded shadow-sm blog hoverimg">
                        <h4 class="text-primary">{{ date('d', strtotime($kajian->tanggal_kajian)) }}<span class="d-block text-muted">{{ date('M, Y', strtotime($kajian->tanggal_kajian)) }}</span></h4>
                        <figure class="mb-3">
                            <img src="{{ asset('storage/' . $kajian->foto_kajian) }}" alt="img" class="rounded img-fluid" style="max-height: 260px; object-fit: cover;">
                        </figure>
                        <h5 class="fw-bold"><a href="#" class="text-dark">{{ $kajian->judul_kajian }}</a></h5>
                        <p class="text-muted">{{ Str::limit($kajian->deskripsi_kajian, 150) }}</p>
                        {{-- <div class="blog-man d-flex align-items-center">
                            <img alt="img" class="me-3 rounded-circle" src="{{ asset('storage/' . $kajian->foto_ustad) }}" style="width: 60px; height: 60px; object-fit: cover;">
                            <h6 class="mb-0"><a href="#" class="text-primary">{{ $kajian->nama_ustad }}</a></h6>
                        </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Zakat Calculator Section -->
<section id="zakat" class="py-5 gap no-top bg-light">
    <div class="container">
        <div class="text-center heading">
            <img src="{{ asset('masjid/main_files/assets/img/heading-img.png') }}" alt="icon" class="mb-3 img-fluid" style="max-width: 100px;">
            <p class="text-uppercase text-muted">Kalkulator Zakat</p>
            <h2 class="fw-bold">Hitung Zakat Anda</h2>
        </div>
        <div class="text-center zakat-calculator">
            <button class="m-2 btn btn-primary" onclick="showCalculator('mal')">Zakat Mal</button>
            <button class="m-2 btn btn-secondary" onclick="showCalculator('fidyah')">Zakat Fidyah</button>
            <div id="zakatMalCalculator" class="p-4 mt-4 bg-white rounded shadow-sm" style="display:none;">
                <h3 class="fw-bold text-primary">Kalkulator Zakat Mal</h3>
                <label class="fw-bold">Jumlah Harta (Rp):</label>
                <input type="text" id="hartaMal" class="mb-3 form-control" oninput="formatInputRupiah(this); calculateMal()">
                <p class="text-muted">Nisab Per Tahun: <strong>Rp 85.685.972</strong></p>
                <p class="text-muted">Nisab Per Bulan: <strong>Rp 7.140.498</strong></p>
                <p class="fw-bold">Zakat yang Harus Dibayar: Rp <span id="resultMal" class="text-primary">0</span></p>
            </div>
            <div id="zakatFidyahCalculator" class="p-4 mt-4 bg-white rounded shadow-sm" style="display:none;">
                <h3 class="fw-bold text-secondary">Kalkulator Zakat Fidyah</h3>
                <label class="fw-bold">Jumlah Hari Tidak Puasa:</label>
                <input type="number" id="hariFidyah" class="mb-3 form-control" oninput="calculateFidyah()">
                <p class="text-muted">Besaran Fidyah Per Hari: <strong>Rp 15.000</strong></p>
                <p class="fw-bold">Total Zakat Fidyah: Rp <span id="resultFidyah" class="text-secondary">0</span></p>
            </div>
        </div>
    </div>
</section>

<!-- Infaq Section -->
<section id="infaq" class="gap">
    <div class="container">
        <div class="text-center heading">
            <img src="{{ asset('masjid/main_files/assets/img/heading-img.png') }}" alt="icon" class="mb-3 img-fluid" style="max-width: 100px;">
            <p class="text-uppercase text-muted">Infaq & Sedekah</p>
            <h2 class="fw-bold">Salurkan Infaq Anda</h2>
        </div>
        <!-- Total Infaq Balance Card -->
        <div class="infaq-balance-card">
            <h3>Total Saldo Infaq & Sedekah Terkumpul</h3>
            <div class="amount">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</div>
            <p class="description">Dana ini digunakan untuk pembangunan dan operasional masjid. Terima kasih atas kontribusi Anda.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Infaq Online</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-center mb-4">Silahkan isi form di bawah ini untuk berinfaq secara online</p>
                        <form id="infaqForm">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Sapaan :</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="sapaan" id="sapaan-bpk" value="Bpk." checked>
                                    <label class="btn btn-outline-success" for="sapaan-bpk">Bpk.</label>

                                    <input type="radio" class="btn-check" name="sapaan" id="sapaan-ibu" value="Ibu">
                                    <label class="btn btn-outline-success" for="sapaan-ibu">Ibu</label>

                                    <input type="radio" class="btn-check" name="sapaan" id="sapaan-kak" value="Kak.">
                                    <label class="btn btn-outline-success" for="sapaan-kak">Kak.</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Nama Lengkap">
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sembunyikan_nama" name="sembunyikan_nama">
                                    <label class="form-check-label" for="sembunyikan_nama">Sembunyikan nama saya (Sahabat)</label>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="no_telepon">No Whatsapp atau Handphone</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required placeholder="No Whatsapp atau Handphone">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email (optional)</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email (optional)">
                            </div>

                            <div class="form-group mb-3">
                                <label for="jumlah">Nominal Donasi (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                        required placeholder="Nominal donasi"
                                        value="10000"
                                        oninput="formatDonationAmount(this)">
                                </div>
                                <small class="form-text text-muted">Minimal Rp 1.000</small>
                            </div>

                            <!-- Nominal cepat -->
                            <div class="form-group mb-4">
                                <label>Pilih Nominal Cepat:</label>
                                <div class="d-flex flex-wrap justify-content-between gap-2">
                                    <button type="button" class="btn btn-outline-success nominal-btn" data-amount="10000">Rp 10.000</button>
                                    <button type="button" class="btn btn-outline-success nominal-btn" data-amount="20000">Rp 20.000</button>
                                    <button type="button" class="btn btn-outline-success nominal-btn" data-amount="50000">Rp 50.000</button>
                                    <button type="button" class="btn btn-outline-success nominal-btn" data-amount="100000">Rp 100.000</button>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="pesan">Tuliskan pesan atau doa disini (optional)</label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="3" placeholder="Tuliskan pesan atau doa disini (optional)"></textarea>
                            </div>

                            <input type="hidden" name="jenis_penerimaan" value="Online">

                            <button type="submit" class="btn btn-success w-100">
                                <span class="d-flex align-items-center justify-content-center">
                                    Donasi Sekarang
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </span>
                            </button>
                        </form>
                        <div id="loading-indicator" class="text-center mt-3" style="display: none;">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memproses permintaan pembayaran...</p>
                        </div>
                        <div id="error-message" class="alert alert-danger mt-3" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add jQuery and FontAwesome if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<!-- Script untuk format dan pilihan nominal -->
<script>
    $(document).ready(function() {
        // Nominal cepat buttons
        $('.nominal-btn').click(function() {
            var amount = $(this).data('amount');
            $('#jumlah').val(formatRupiah(amount.toString()));
            // Highlight the selected button
            $('.nominal-btn').removeClass('active');
            $(this).addClass('active');
        });

        // Set button Rp 10.000 sebagai active secara default
        $('.nominal-btn[data-amount="10000"]').addClass('active');
    });

    // Format input nominal donasi
    function formatDonationAmount(input) {
        // Remove non-numeric characters
        let value = input.value.replace(/\D/g, '');

        // Format with thousand separator
        if (value !== '') {
            input.value = formatRupiah(value);
        }
    }

    // Format to rupiah with thousand separator
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }
</script>

<script>
    $(document).ready(function() {
        $('#infaqForm').submit(function(e) {
            e.preventDefault();

            // Sembunyikan pesan error sebelumnya
            $('#error-message').hide();

            // Validasi jumlah minimal
            let jumlahVal = $('#jumlah').val().replace(/\D/g, '');
            if (parseInt(jumlahVal) < 1000) {
                $('#error-message').text('Minimal donasi adalah Rp 1.000').show();
                return false;
            }

            // Tampilkan loading indicator
            $('#loading-indicator').show();

            // Nonaktifkan tombol submit
            $(this).find('button[type="submit"]').prop('disabled', true);

            // Ambil data form dan konversi ke FormData
            var formData = new FormData(this);

            // Fix jumlah (hapus format ribuan)
            formData.delete('jumlah');
            formData.append('jumlah', jumlahVal);

            // Proses donasi (dua langkah: simpan donatur terlebih dahulu, lalu proses pembayaran)
            $.ajax({
                url: '{{ route("donatur.store.ajax") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(donaturResponse) {
                    if (donaturResponse.status === 'success') {
                        // Donatur berhasil disimpan, sekarang proses pembayaran
                        processMidtransPayment(donaturResponse.donatur_id, jumlahVal);
                    } else {
                        // Tampilkan pesan error
                        $('#error-message').text('Terjadi kesalahan: ' + donaturResponse.message).show();
                        $('#loading-indicator').hide();
                        $('#infaqForm').find('button[type="submit"]').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Tangani error penyimpanan donatur
                    handleAjaxError(xhr, 'Gagal menyimpan data donatur');
                }
            });
        });

        function processMidtransPayment(donaturId, amount) {
            // Data untuk request Midtrans
            var paymentData = {
                donatur_id: donaturId,
                jenis_penerimaan: 'Online',
                jumlah: amount,
                _token: $('input[name="_token"]').val()
            };

            // Kirim request ke Midtrans
            $.ajax({
                url: '{{ route("midtrans.create") }}',
                type: 'POST',
                data: paymentData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Redirect ke halaman pembayaran
                        window.location.href = response.redirect_url;
                    } else {
                        // Tampilkan pesan error
                        $('#error-message').text('Terjadi kesalahan: ' + response.message).show();
                        $('#loading-indicator').hide();
                        $('#infaqForm').find('button[type="submit"]').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Tangani error Midtrans
                    handleAjaxError(xhr, 'Gagal memproses pembayaran');
                }
            });
        }

        function handleAjaxError(xhr, defaultMessage) {
            let errorMessage;

            try {
                // Coba parse response JSON jika ada
                const response = JSON.parse(xhr.responseText);

                if (response.errors) {
                    // Laravel validation errors
                    errorMessage = Object.values(response.errors).flat().join('<br>');
                } else if (response.message) {
                    errorMessage = response.message;
                } else if (response.error_messages) {
                    errorMessage = response.error_messages.join(', ');
                } else {
                    errorMessage = defaultMessage;
                }
            } catch (e) {
                // Fallback jika tidak bisa parse JSON
                errorMessage = defaultMessage + '. Silakan coba lagi nanti.';
            }

            // Tampilkan pesan error
            $('#error-message').html(errorMessage).show();
            $('#loading-indicator').hide();
            $('#infaqForm').find('button[type="submit"]').prop('disabled', false);
        }
    });
</script>

<!-- Zakat Calculator Script -->
<script>
    function showCalculator(type) {
        document.getElementById('zakatMalCalculator').style.display = (type === 'mal') ? 'block' : 'none';
        document.getElementById('zakatFidyahCalculator').style.display = (type === 'fidyah') ? 'block' : 'none';
    }

    function calculateMal() {
        let harta = document.getElementById('hartaMal').value.replace(/\./g, '');
        let nisab = 85685972;
        let zakat = (harta >= nisab) ? harta * 0.025 : 0;
        document.getElementById('resultMal').innerText = formatRupiah(zakat);
    }

    function calculateFidyah() {
        let hari = document.getElementById('hariFidyah').value;
        let fidyahPerHari = 15000;
        let totalFidyah = hari * fidyahPerHari;
        document.getElementById('resultFidyah').innerText = formatRupiah(totalFidyah);
    }

    function formatInputRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }
</script>
<script>
    // Set Tanggal otomatis ke hari ini
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('tanggal')) {
            document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
        }

        // Set Waktu otomatis ke saat ini dalam format yang benar (HH:mm)
        if(document.getElementById('waktu')) {
            let currentTime = new Date().toTimeString().split(' ')[0].substring(0, 5);
            document.getElementById('waktu').value = currentTime;
        }
    });
</script>

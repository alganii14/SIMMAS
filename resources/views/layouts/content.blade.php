<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @php
    // Calculate total zakat balance
    $zakats = App\Models\Zakat::all();

    // Hitung total per jenis zakat (uang)
    $totalZakatFitrahUang = $zakats->where('jenis_zakat', 'Zakat Fitrah')
        ->where('jenis_bayar', 'uang')
        ->sum('jumlah_zakat');

    $totalZakatMal = $zakats->where('jenis_zakat', 'Zakat Mal')
        ->sum('jumlah_zakat');

    $totalZakatFidyah = $zakats->where('jenis_zakat', 'Zakat Fidyah')
        ->sum('jumlah_zakat');

    // Hitung total beras dari tabel zakat
    $totalBerasMasuk = $zakats->where('jenis_bayar', 'beras')
        ->sum('berat_beras');

    // Hitung total penyaluran beras
    $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

    $totalBerasKeluar = 0;
    if ($hasBerasDisalurkanColumn) {
        $totalBerasKeluar = App\Models\Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('beras_disalurkan');
    } else {
        // Jika kolom tidak ada, hitung dari jumlah_terima
        $totalBerasKeluar = DB::table('penyaluran_penerimas')
            ->join('penyalurans', 'penyaluran_penerimas.no_penyaluran', '=', 'penyalurans.no_penyaluran')
            ->where('penyalurans.jenis_zakat', 'Zakat Fitrah')
            ->sum(DB::raw('penyaluran_penerimas.jumlah_terima / 14000'));
    }

    // Hitung sisa beras
    $totalBeras = $totalBerasMasuk - $totalBerasKeluar;
    if ($totalBeras < 0) $totalBeras = 0;

    // Nilai beras dalam bentuk uang
    $nilaiBerasZakatFitrah = $totalBeras * 14000;

    // Hitung total penyaluran per jenis zakat (uang)
    $penyaluranZakatFitrah = App\Models\Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('total_penyaluran');
    $penyaluranZakatMal = App\Models\Penyaluran::where('jenis_zakat', 'Zakat Mal')->sum('total_penyaluran');
    $penyaluranZakatFidyah = App\Models\Penyaluran::where('jenis_zakat', 'Zakat Fidyah')->sum('total_penyaluran');

    // Total Zakat Fitrah (uang + nilai beras)
    $totalZakatFitrah = $totalZakatFitrahUang + $nilaiBerasZakatFitrah;

    // Kurangi saldo uang dengan penyaluran
    $totalZakatFitrahUang -= $penyaluranZakatFitrah;
    if ($totalZakatFitrahUang < 0) {
        // Jika saldo uang minus, kurangi dari nilai beras
        $nilaiBerasZakatFitrah += $totalZakatFitrahUang; // Tambahkan nilai negatif
        $totalZakatFitrahUang = 0;
    }

    // Recalculate total zakat fitrah
    $totalZakatFitrah = $totalZakatFitrahUang + $nilaiBerasZakatFitrah;
    if ($totalZakatFitrah < 0) $totalZakatFitrah = 0;

    $totalZakatMal -= $penyaluranZakatMal;
    if ($totalZakatMal < 0) $totalZakatMal = 0;

    $totalZakatFidyah -= $penyaluranZakatFidyah;
    if ($totalZakatFidyah < 0) $totalZakatFidyah = 0;

    // Total saldo keseluruhan setelah dikurangi penyaluran
    $totalSaldoZakat = $totalZakatFitrah + $totalZakatMal + $totalZakatFidyah;

    // Calculate total infaq balance
    $totalSaldoInfaq = App\Models\Infaq::sum('jumlah');

    // Count total petugas
    $totalPetugas = App\Models\User::count();

    // Count total muzakki
    $totalMuzakki = App\Models\Muzakki::count();

    // Count total donatur
    $totalDonatur = App\Models\Donatur::count();

    // Count total mustahik
    $totalMustahik = App\Models\Mustahik::count();
    @endphp

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                {{-- <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalSaldoZakat, 0, ',', '.') }}</h3>
                            <p>Total Saldo Zakat</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-cash"></i>
                        </div>
                        {{-- <a href="{{ route('zakat.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    {{-- </div>
                </div> --}}
                <!-- ./col -->
                {{-- <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalSaldoInfaq, 0, ',', '.') }}</h3>
                            <p>Total Saldo Infaq</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        {{-- <a href="{{ route('infaq.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    {{-- </div>
                </div>  --}}
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalPetugas }}</h3>
                            <p>Total Petugas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        {{-- <a href="{{ route('register.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalMuzakki }}</h3>
                            <p>Total Muzakki</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        {{-- <a href="{{ route('muzakki.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <!-- Second row for additional stats -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $totalDonatur }}</h3>
                            <p>Total Donatur</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-heart"></i>
                        </div>
                        {{-- <a href="{{ route('donatur.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $totalMustahik }}</h3>
                            <p>Total Mustahik</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-people"></i>
                        </div>
                        {{-- <a href="{{ route('mustahik.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


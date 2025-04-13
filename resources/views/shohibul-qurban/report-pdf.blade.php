<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Shohibul Qurban</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Styling */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            position: relative;
            height: 120px; /* Fixed height untuk kop */
        }

        .logo {
            width: 100px;
            height: auto;
            position: absolute;
            left: 30px;
            top: 10px;
        }

        .kop-text {
            margin-left: 120px;
            margin-right: 100px;
            padding-top: 10px;
        }

        .kop-text h2, .kop-text h3, .kop-text p {
            margin: 2px 0;
        }

        /* Table Styling */
        .table-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 11px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            vertical-align: middle;
        }

        /* Filter Info Styling */
        .filter-info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        /* Signature Styling */
        .signatures {
            margin-top: 40px;
            position: relative;
            width: 100%;
        }

        .signature-box {
            float: left;
            width: 45%;
            text-align: center;
        }

        .signature-box.right {
            float: right;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
            width: 200px;
            display: inline-block;
        }

        .clear {
            clear: both;
        }

        /* Page Number */
        .page-number {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }

        /* Table Data Styling */
        .data-table th, .data-table td {
            padding: 6px 4px;
        }

        .data-table td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .filter-table td {
            border: none;
            padding: 2px 5px;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <img src="{{ public_path('masjid/main_files/assets/img/logo.png') }}" class="logo" alt="Logo Masjid">
        <div class="kop-text">
            <h2 style="font-size: 16px;">DEWAN KEMAKMURAN MASJID (DKM)</h2>
            <h2 style="font-size: 18px;">MASJID KHAIRUL AMAL</h2>
            <h3 style="font-size: 14px;">PANITIA QURBAN _______ H / _______ M</h3>
            <p style="font-size: 11px;">Jl. Serpong Raya No. 32, RT.10/RW.10, Kecamatan Tangerang, Kota Tangerang, Banten 15128</p>
            <p style="font-size: 11px;">Telp: (021) 123456 | Email: dkm@masjidkhairulamal.com</p>
        </div>
    </div>

    <!-- Judul Laporan -->
    <h3 style="text-align: center; margin: 20px 0;">LAPORAN DATA SHOHIBUL QURBAN</h3>

    <!-- Filter Info -->
    <div class="filter-info">
        <table class="filter-table">
            <tr>
                <td style="width: 120px;">Periode</td>
                <td>: {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Semua' }}
                    {{ request('end_date') ? ' - '.date('d/m/Y', strtotime(request('end_date'))) : '' }}</td>
            </tr>
            <tr>
                <td>Tahun Hijriah</td>
                <td>: {{ request('tahun_hijriah') ?: 'Semua' }}</td>
            </tr>
            <tr>
                <td>Jenis Hewan</td>
                <td>: {{ request('jenis_hewan') ?: 'Semua' }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Data -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 60px;">Tahun Hijriah</th>
                    <th style="width: 80px;">Tanggal</th>
                    <th style="width: 80px;">Jenis Hewan</th>
                    <th>Nama Shohibul</th>
                    <th style="width: 100px;">NIK</th>
                    <th style="width: 90px;">No. HP</th>
                    <th style="width: 60px;">Berat (kg)</th>
                    <th>Qurban Atas Nama</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shohibuls as $index => $shohibul)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $shohibul->tahun_hijriah }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($shohibul->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $shohibul->jenis_hewan }}</td>
                    <td>{{ $shohibul->nama }}</td>
                    <td>{{ $shohibul->nik }}</td>
                    <td>{{ $shohibul->hp }}</td>
                    <td class="text-center">{{ $shohibul->berat }}</td>
                    <td>
                        @foreach($shohibul->details as $index => $detail)
                            {{ $index + 1 }}. {{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}
                            @if(!$loop->last)<br>@endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Ketua DKM Masjid Khairul Amal</p>
            <div class="signature-line"></div>
            <p>( _________________________ )</p>
        </div>

        <div class="signature-box right">
            <p>Bekasi, {{ now()->isoFormat('D MMMM Y') }}</p>
            <p>Ketua Panitia Qurban</p>
            <div class="signature-line"></div>
            <p>( _________________________ )</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Page Number -->
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Arial");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>

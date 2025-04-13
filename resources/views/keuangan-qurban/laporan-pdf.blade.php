<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Qurban</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }

        .kop-surat h2 {
            margin: 0;
            padding: 0;
        }

        .logo {
            position: absolute;
            left: 30px;
            top: 10px;
            width: 80px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin: 20px 0;
        }

        .summary table {
            width: 50%;
            float: right;
        }

        .signatures {
            margin-top: 30px;
            text-align: right;
            padding-right: 40px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('masjid/main_files/assets/img/logo.png') }}" class="logo">
        <h2>DEWAN KEMAKMURAN MASJID (DKM)</h2>
        <h2>MASJID KHAIRUL AMAL</h2>
        <h3>LAPORAN KEUANGAN QURBAN {{ request('tahun_hijriah') ? request('tahun_hijriah').' H' : '' }}</h3>
        <p>Jl. Serpong Raya No. 32, RT.10/RW.10, Kecamatan Tangerang, Kota Tangerang, Banten 15128</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <th colspan="2">RINGKASAN KEUANGAN</th>
            </tr>
            <tr>
                <td>Total Pemasukan</td>
                <td class="text-right">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td class="text-right">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Saldo Keuangan</td>
                <td class="text-right">Rp {{ number_format($saldoKeuangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Saldo Tabungan</td>
                <td class="text-right">Rp {{ number_format($saldoTabungan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Saldo</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    <h3 style="text-align: center;">RINCIAN TRANSAKSI</h3>
    @if(request('tanggal_mulai') && request('tanggal_akhir'))
    <p style="text-align: center;">
        Periode: {{ date('d/m/Y', strtotime(request('tanggal_mulai'))) }} - {{ date('d/m/Y', strtotime(request('tanggal_akhir'))) }}
    </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $saldoBerjalan = 0; @endphp
            @foreach($transaksi as $index => $t)
            @php
                if ($t->jenis === 'Masuk') {
                    $saldoBerjalan += $t->jumlah;
                } else {
                    $saldoBerjalan -= $t->jumlah;
                }
            @endphp
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                <td>{{ $t->no_transaksi }}</td>
                <td>{{ $t->keterangan }}</td>
                <td class="text-right">{{ $t->jenis === 'Masuk' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $t->jenis === 'Keluar' ? 'Rp ' . number_format($t->jumlah, 0, ',', '.') : '-' }}</td>
                <td class="text-right">Rp {{ number_format($saldoBerjalan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signatures">
        <p>Bandung, {{ now()->isoFormat('D MMMM Y') }}</p>
        <p>Bendahara Panitia Qurban</p>
        <br><br><br>
        <p>( _________________________ )</p>
    </div>
</body>
</html>
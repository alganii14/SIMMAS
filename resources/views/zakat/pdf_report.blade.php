<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penerimaan Zakat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penerimaan Zakat</h2>
        @if(request('start_date') && request('end_date'))
            <p>Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }} 
               s/d {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Zakat</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Petugas</th>
                <th>Muzakki</th>
                <th>Jenis Zakat</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $totalZakat = 0; @endphp
            @foreach($zakats as $index => $zakat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $zakat->no_zakat }}</td>
                <td>{{ \Carbon\Carbon::parse($zakat->tanggal_zakat)->format('d-m-Y') }}</td>
                <td>{{ $zakat->jam_zakat }}</td>
                <td>{{ $zakat->petugas_penerima }}</td>
                <td>{{ $zakat->muzakki->nama_muzakki }}</td>
                <td>{{ $zakat->jenis_zakat }}</td>
                <td>Rp {{ number_format($zakat->jumlah_zakat, 0, ',', '.') }}</td>
            </tr>
            @php $totalZakat += $zakat->jumlah_zakat; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="7" class="text-right">Total:</td>
                <td>Rp {{ number_format($totalZakat, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
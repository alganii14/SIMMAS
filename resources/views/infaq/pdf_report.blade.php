<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Infaq</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Laporan Penerimaan Infaq dan Shodaqoh</h2>

    @if(request('start_date') && request('end_date'))
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}
        sampai {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}</p>
    @endif

    @if(request('jenis_penerimaan') && request('jenis_penerimaan') != 'all')
    <p><strong>Jenis Penerimaan:</strong> {{ request('jenis_penerimaan') }}</p>
@endif
@php
    $totalPenerimaan = $infaqs->sum('jumlah');
@endphp
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Penerimaan</th>
                <th>Petugas</th>
                <th>Donatur</th>
                <th>Jenis Penerimaan</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($infaqs as $index => $infaq)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $infaq->no_penerimaan }}</td>
                <td>{{ $infaq->petugas ? $infaq->petugas->name : '-' }}</td>
                <td>{{ $infaq->donatur->nama }}</td>
                <td>{{ $infaq->jenis_penerimaan }}</td>
                <td>Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($infaq->tanggal)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($infaq->waktu)->format('H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" align="right">Total Penerimaan:</th>
                <th>Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>

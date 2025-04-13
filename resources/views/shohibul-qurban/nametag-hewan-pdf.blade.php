<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nametag Hewan Qurban</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .nametag {
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2, .header h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 35%;
        }

        .title {
            text-align: center;
            background-color: #f0f0f0;
            padding: 5px;
            font-weight: bold;
            border: 1px solid #000;
            margin-bottom: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .logo {
            width: 60px;
            position: absolute;
            left: 10px;
            top: 10px;
        }
    </style>
</head>
<body>
    @foreach($shohibuls as $shohibul)
    <div class="nametag">
        <div class="header">
            <img src="{{ public_path('masjid/main_files/assets/img/logo.png') }}" class="logo">
            <h2>PANITIA QURBAN {{ $shohibul->tahun_hijriah }} H</h2>
            <h3>MASJID KHAIRUL AMAL</h3>
        </div>

        <div class="title">NAMETAG HEWAN QURBAN</div>

        <table>
            <tr>
                <th>Jenis Hewan</th>
                <td>{{ $shohibul->jenis_hewan }}</td>
            </tr>
            <tr>
                <th>Berat</th>
                <td>{{ $shohibul->berat }} Kg</td>
            </tr>
            <tr>
                <th>Shohibul Qurban</th>
                <td>{{ $shohibul->nama }}</td>
            </tr>
            <tr>
                <th>Atas Nama</th>
                <td>
                    @foreach($shohibul->details as $detail)
                        {{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}
                        @if(!$loop->last)<br>@endif
                    @endforeach
                </td>
            </tr>
        </table>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>

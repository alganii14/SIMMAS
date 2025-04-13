<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hewan Qurban</title>
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
        <h3>PANITIA QURBAN {{ request('tahun_hijriah') ? request('tahun_hijriah').' H' : '' }}</h3>
        <p>Jl. Serpong Raya No. 32, RT.10/RW.10, Kecamatan Tangerang, Kota Tangerang, Banten 15128</p>
    </div>

    <h3 style="text-align: center;">DAFTAR HEWAN QURBAN</h3>

    <table>
        <tr>
            <th style="width: 50%">MUDHOHI</th>
            <th style="width: 50%">ATAS NAMA</th>
        </tr>
        @foreach($shohibuls as $shohibul)
        <tr>
            <td>
                {{ $shohibul->jenis_hewan }} {{ $shohibul->nama }},
                {{ $shohibul->berat }} Kg : ____ Kg
            </td>
            <td>
                @foreach($shohibul->details as $detail)
                    {{ $detail->nama }} {{ $detail->bin_or_binti }} {{ $detail->bin_or_binti_value }}
                    @if(!$loop->last)<br>@endif
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>

    <div class="signatures">
        <p>Bandung, {{ now()->isoFormat('D MMMM Y') }}</p>
        <p>Ketua Panitia Qurban</p>
        <br><br><br>
        <p>( _________________________ )</p>
    </div>
</body>
</html>

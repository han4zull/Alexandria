<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Disetujui - Perpustakaan Alexandria</title>

    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: 'Cambria', 'Times New Roman', serif;
            background: white;
            color: black;
            margin: 0;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .kop {
            text-align: center;
        }

        .kop h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .kop p {
            font-size: 14px;
            margin: 3px 0;
            font-weight: normal;
        }

        .line {
            border-bottom: 2px solid black;
            margin: 15px 0 25px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .header-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .stats-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .stats-section p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            line-height: 1.3;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px 6px;
            text-align: center;
            word-break: break-word;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 10px;
            letter-spacing: 0.3px;
        }

        .text-left {
            text-align: left !important;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            background-color: #d1fae5;
            color: black;
        }

        .ttd {
            margin-top: 80px;
            width: 100%;
        }

        .ttd-right {
            float: right;
            text-align: center;
            min-width: 180px;
        }

        .ttd-right p {
            margin: 2px 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: black;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- KOP -->
    <div class="kop">
        <h1>ALEXANDRIA DIGITAL LIBRARY</h1>
        <p>Sistem Informasi Perpustakaan Digital</p>
        <p>Jl. Pendidikan No. 123, Indonesia</p>
    </div>

    <div class="line"></div>

    <!-- JUDUL -->
    <div class="judul">
        LAPORAN BUKU DISETUJUI
    </div>

    <!-- TABEL -->
    @if($buku->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ISBN</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($buku as $b)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $b->isbn ?? '-' }}</td>
                <td class="text-left">
                    <strong>{{ Str::limit($b->judul ?? '-', 40) }}</strong>
                </td>
                <td class="text-left">
                    @if($b->kategori && $b->kategori->count())
                        {{ $b->kategori->pluck('nama_kategori')->join(', ') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    Disetujui
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <p style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Tidak ada data</p>
        <p style="font-size: 12px;">Tidak ada buku dengan status disetujui</p>
    </div>
    @endif

    <!-- TTD -->
    <div class="ttd">
        <div class="ttd-right">
            <p>{{ date('d F Y') }}</p>
            <p>Mengetahui,</p>

            <br><br><br>

            <p><strong>Petugas Perpustakaan</strong></p>
        </div>
    </div>

</div>

</body>
</html>

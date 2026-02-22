<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian Selesai - Admin Perpustakaan Alexandria</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            line-height: 1.3;
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
            font-size: 11px;
            letter-spacing: 0.3px;
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
        LAPORAN PENGEMBALIAN SELESAI
    </div>

    <!-- TABEL -->
    @if(isset($items) && count($items))
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Judul Buku</th>
                <th>Tanggal Kembali</th>
                <th>Kondisi</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
            @php
                $kondisiArr = $item->kondisi_buku
                    ? array_map('trim', explode(',', $item->kondisi_buku))
                    : ['Baik'];
            @endphp
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->peminjaman->user->username ?? '-' }}</td>
                <td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                <td>
                    {{ $item->tanggal_kembali
                        ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('Y-m-d')
                        : '-' }}
                </td>
                <td>{{ implode(', ', $kondisiArr) }}</td>
                <td>
                    Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- TTD -->
    <div class="ttd">
        <div class="ttd-right">
            <p>{{ date('d F Y') }}</p>
            <p>Mengetahui,</p>

            <br><br><br>

            <p><strong>Admin Perpustakaan</strong></p>
        </div>
    </div>

</div>

</body>
</html>
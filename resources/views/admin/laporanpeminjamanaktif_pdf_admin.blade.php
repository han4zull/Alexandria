<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Aktif - Admin Perpustakaan Alexandria</title>

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
        LAPORAN PEMINJAMAN AKTIF
    </div>

    <!-- TABEL -->
    @if(isset($items) && count($items))
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->user->username ?? '-' }}</td>
                <td>{{ $item->buku->judul ?? '-' }}</td>
                <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
                <td>
                    @if($item->status === 'dipinjam')
                        <span style="color: black; font-weight: bold;">Dipinjam</span>
                    @elseif($item->status === 'terlambat')
                        <span style="color: black; font-weight: bold;">Terlambat</span>
                    @elseif($item->status === 'menunggu konfirmasi')
                        <span style="color: black; font-weight: bold;">Menunggu Konfirmasi</span>
                    @else
                        {{ ucfirst($item->status) }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: black; font-style: italic;">
        <p style="font-size: 16px; font-weight: bold; margin-bottom: 8px;">Tidak ada data</p>
        <p style="font-size: 12px;">Tidak ada peminjaman aktif untuk ditampilkan</p>
    </div>
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
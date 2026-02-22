<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan User - Admin Perpustakaan Alexandria</title>

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
        LAPORAN USER
    </div>

    <!-- TABEL -->
    @if(isset($user) && count($user))
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $i => $item)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $item->username ?? '-' }}</td>
                <td>{{ $item->nama_lengkap ?? '-' }}</td>
                <td>{{ $item->email ?? '-' }}</td>
                <td>{{ ucfirst($item->status ?? 'aktif') }}</td>
                <td>
                    {{ $item->created_at
                        ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d')
                        : '-' }}
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

<?php

// Debug script untuk cek data yang dikirim ke view
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pengembalian;

echo "=== DEBUG DATA UNTUK HALAMAN SELESAI ===\n\n";

$selesai = Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'peminjaman.prosesKembali'])
    ->orderBy('tanggal_kembali','desc')
    ->take(3)
    ->get();

foreach($selesai as $pengembalian) {
    echo "Pengembalian ID: " . $pengembalian->id . "\n";
    echo "Peminjaman ID: " . $pengembalian->peminjaman_id . "\n";

    $p = $pengembalian->peminjaman;
    $prosesKembali = $p->prosesKembali;

    echo "ProsesKembali exists: " . ($prosesKembali ? 'YES' : 'NO') . "\n";

    if ($prosesKembali) {
        echo "Kondisi Raw: '" . $prosesKembali->kondisi_buku . "'\n";
        $kondisiRaw = $prosesKembali->kondisi_buku ?? '';
        $kondisiArr = $kondisiRaw ? array_map('trim', explode(',', $kondisiRaw)) : [];
        echo "Kondisi Array: " . json_encode($kondisiArr) . "\n";
        echo "Denda: " . $prosesKembali->denda . "\n";
    } else {
        echo "TIDAK ADA DATA PROSES KEMBALI!\n";
    }

    echo "---\n";
}
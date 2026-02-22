<?php

require_once 'vendor/autoload.php';

use App\Models\Pengembalian;
use App\Models\ProsesKembali;

echo "=== CEK DATA PENGEMBALIAN DAN PROSES KEMBALI ===\n\n";

$pengembalians = Pengembalian::with(['peminjaman.prosesKembali'])->take(10)->get();

foreach($pengembalians as $pengembalian) {
    echo "Pengembalian ID: " . $pengembalian->id . "\n";
    echo "Peminjaman ID: " . $pengembalian->peminjaman_id . "\n";

    $prosesKembali = $pengembalian->peminjaman->prosesKembali;
    if ($prosesKembali) {
        echo "ProsesKembali ID: " . $prosesKembali->id . "\n";
        echo "Kondisi Buku: " . $prosesKembali->kondisi_buku . "\n";
        echo "Denda: " . $prosesKembali->denda . "\n";
    } else {
        echo "ProsesKembali: TIDAK ADA\n";
    }

    echo "---\n";
}

echo "\n=== JUMLAH DATA ===\n";
echo "Pengembalian: " . Pengembalian::count() . "\n";
echo "ProsesKembali: " . ProsesKembali::count() . "\n";
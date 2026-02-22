<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MEMBANDINGKAN DATA WEB VIEW VS PDF VIEW ===\n\n";

// Query yang sama untuk kedua view
$items = App\Models\Peminjaman::with(['user','buku','prosesKembali'])
    ->where('status', 'proses pengembalian')
    ->orderBy('tanggal_pinjam','desc')
    ->get();

echo "Total data: " . count($items) . "\n\n";

foreach($items as $i => $item) {
    $prosesRec = $item->prosesKembali;

    echo "=== RECORD " . ($i+1) . " ===\n";
    echo "ID Peminjaman: " . $item->id . "\n";
    echo "Username: " . ($item->user->username ?? '-') . "\n";
    echo "Judul Buku: " . ($item->buku->judul ?? '-') . "\n";
    echo "Tanggal Pinjam: " . ($item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-') . "\n";
    echo "Tanggal Dikembalikan: " . ($prosesRec && $prosesRec->tanggal_dikembalikan ? \Carbon\Carbon::parse($prosesRec->tanggal_dikembalikan)->format('d-m-Y') : '-') . "\n";

    $kondisi = $prosesRec && $prosesRec->kondisi_buku ? ucfirst($prosesRec->kondisi_buku) : 'Baik';
    echo "Kondisi Buku: " . $kondisi . "\n";

    if ($prosesRec) {
        echo "  (Raw kondisi_buku: '" . $prosesRec->kondisi_buku . "')\n";
    } else {
        echo "  (Tidak ada record prosesKembali)\n";
    }

    echo "\n";
}
?>
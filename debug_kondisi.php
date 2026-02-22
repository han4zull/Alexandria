<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$items = App\Models\Peminjaman::with('prosesKembali')->where('status', 'proses pengembalian')->get();
echo "Data proses pengembalian:\n";
foreach($items as $item) {
    $kondisi = $item->prosesKembali ? $item->prosesKembali->kondisi_buku : 'NULL';
    echo 'ID: ' . $item->id . ' - Kondisi: ' . $kondisi . PHP_EOL;
}
?>
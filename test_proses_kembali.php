<?php

require_once 'vendor/autoload.php';

use App\Models\Pengembalian;

$pengembalians = Pengembalian::with(['peminjaman.prosesKembali'])->take(5)->get();

foreach($pengembalians as $p) {
    echo 'Peminjaman ID: ' . $p->peminjaman_id . PHP_EOL;
    echo 'ProsesKembali exists: ' . ($p->peminjaman->prosesKembali ? 'YES' : 'NO') . PHP_EOL;
    if($p->peminjaman->prosesKembali) {
        echo 'Kondisi: ' . $p->peminjaman->prosesKembali->kondisi_buku . PHP_EOL;
        echo 'Denda: ' . $p->peminjaman->prosesKembali->denda . PHP_EOL;
    }
    echo '---' . PHP_EOL;
}
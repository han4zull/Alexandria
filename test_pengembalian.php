<?php

require_once 'vendor/autoload.php';

use App\Models\Pengembalian;

echo "Pengembalian count: " . Pengembalian::count() . PHP_EOL;
echo "Sample data:" . PHP_EOL;

$pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.buku'])->take(3)->get();

foreach($pengembalians as $p) {
    echo "ID: " . $p->id . ", User: " . ($p->peminjaman->user->username ?? 'N/A') . ", Book: " . ($p->peminjaman->buku->judul ?? 'N/A') . ", Date: " . $p->tanggal_kembali . PHP_EOL;
}
<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(10);
$buku = \App\Models\Buku::first();
$peminjaman = \App\Models\Peminjaman::where('user_id', 10)->where('status', 'selesai')->first();

if($peminjaman) {
    \App\Models\UlasanBuku::create([
        'user_id' => $user->id,
        'buku_id' => $buku->id,
        'peminjaman_id' => $peminjaman->id,
        'rating' => 5,
        'ulasan' => 'Test ulasan baru dengan peminjaman ID via script'
    ]);
    echo 'Ulasan test berhasil dibuat!' . PHP_EOL;
} else {
    echo 'Tidak ada peminjaman selesai' . PHP_EOL;
}

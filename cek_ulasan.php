<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(10);
$reviews = \App\Models\UlasanBuku::where('user_id', $user->id)->with('buku')->get();

echo 'Total ulasan user: ' . $reviews->count() . PHP_EOL;

foreach($reviews as $r) {
    echo 'ID: ' . $r->id . ', Buku: ' . $r->buku->judul . ', Rating: ' . $r->rating . ', Peminjaman ID: ' . ($r->peminjaman_id ?? 'NULL') . ', Created: ' . $r->created_at . PHP_EOL;
}

echo PHP_EOL . 'Semua ulasan di database:' . PHP_EOL;
$allReviews = \App\Models\UlasanBuku::with('buku', 'user')->get();
foreach($allReviews as $r) {
    echo 'ID: ' . $r->id . ', User: ' . $r->user->username . ', Buku: ' . $r->buku->judul . ', Rating: ' . $r->rating . ', Peminjaman ID: ' . ($r->peminjaman_id ?? 'NULL') . PHP_EOL;
}
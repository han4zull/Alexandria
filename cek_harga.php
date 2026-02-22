<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Buku;

echo "=== CEK DATA HARGA BUKU ===\n";

$buku = Buku::take(5)->get(['id', 'judul', 'harga']);

foreach($buku as $b) {
    echo $b->id . ': ' . $b->judul . ' - Harga: ' . ($b->harga ?? 'NULL') . "\n";
}
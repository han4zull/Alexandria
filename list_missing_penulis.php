<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$books = App\Models\Buku::whereNull('penulis')
    ->orWhereRaw("TRIM(IFNULL(penulis, '')) = ''")
    ->get(['id','judul','penulis']);

if ($books->isEmpty()) {
    echo "Tidak ada buku dengan penulis kosong.\n";
    exit(0);
}

echo "ID\tJudul\n";
foreach ($books as $b) {
    echo $b->id . "\t" . $b->judul . "\n";
}

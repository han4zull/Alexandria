<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$books = App\Models\Buku::select('id','judul','penulis')
    ->orderByRaw("COALESCE(TRIM(penulis),'[NULL]')")
    ->get()
    ->groupBy(function($b){ return trim($b->penulis ?? '[NULL]'); });

foreach ($books as $penulis => $items) {
    echo "-- [{$penulis}] (" . count($items) . ") --\n";
    foreach ($items as $b) {
        echo str_pad($b->id,4,' ',STR_PAD_LEFT) . "\t" . $b->judul . PHP_EOL;
    }
    echo PHP_EOL;
}

<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$rows = App\Models\Buku::selectRaw("COALESCE(TRIM(penulis),'[NULL]') as penulis, COUNT(*) as cnt")
    ->groupByRaw("COALESCE(TRIM(penulis),'[NULL]')")
    ->orderByDesc('cnt')
    ->get();

foreach ($rows as $r) {
    echo str_pad($r->cnt, 4, ' ', STR_PAD_LEFT) . "\t" . $r->penulis . PHP_EOL;
}

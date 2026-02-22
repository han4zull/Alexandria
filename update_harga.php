<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Buku;

Buku::where('id', 10)->update(['harga' => 100000]);
echo 'Updated buku ID 10 harga to 100000' . PHP_EOL;

Buku::where('id', 11)->update(['harga' => 150000]);
echo 'Updated buku ID 11 harga to 150000' . PHP_EOL;
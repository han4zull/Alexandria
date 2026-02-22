<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$petugas = \App\Models\Petugas::find(1);
echo 'Foto profil: ' . $petugas->foto_profil . PHP_EOL;
$fullPath = public_path('storage/petugas/' . $petugas->foto_profil);
echo 'Full path: ' . $fullPath . PHP_EOL;
echo 'File exists: ' . (file_exists($fullPath) ? 'YES' : 'NO') . PHP_EOL;
echo 'Is readable: ' . (is_readable($fullPath) ? 'YES' : 'NO') . PHP_EOL;

// Try to access via asset helper
$assetUrl = asset('storage/petugas/' . $petugas->foto_profil);
echo 'Asset URL: ' . $assetUrl . PHP_EOL;
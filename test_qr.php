<?php
require 'vendor/autoload.php';

$qrText = 'test';

if (class_exists('Endroid\QrCode\Writer\PngWriter') && class_exists('Endroid\QrCode\QrCode')) {
    echo 'Classes exist, trying to create QR...' . PHP_EOL;
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $qrCode = new \Endroid\QrCode\QrCode($qrText);
    $result = $writer->write($qrCode);
    if (method_exists($result, 'getString')) {
        $pngData = $result->getString();
        echo 'Success, PNG size: ' . strlen($pngData) . PHP_EOL;
    } else {
        echo 'No getString method' . PHP_EOL;
    }
} else {
    echo 'Classes do not exist' . PHP_EOL;
}
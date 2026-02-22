<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=information_schema','root','');
$stmt = $db->prepare("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_TYPE, COLUMN_DEFAULT FROM COLUMNS WHERE TABLE_SCHEMA = 'alexandria' AND TABLE_NAME = 'peminjaman' AND COLUMN_NAME = 'status'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo "COLUMN_NAME: " . $row['COLUMN_NAME'] . PHP_EOL;
    echo "DATA_TYPE: " . $row['DATA_TYPE'] . PHP_EOL;
    echo "COLUMN_TYPE: " . $row['COLUMN_TYPE'] . PHP_EOL;
    echo "COLUMN_DEFAULT: " . $row['COLUMN_DEFAULT'] . PHP_EOL;
} else {
    echo "No column found\n";
}

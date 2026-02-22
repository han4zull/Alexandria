<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=alexandria', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT id, username, poin FROM user ORDER BY id LIMIT 15');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
        echo "\n";
    }
} catch(Exception $e) {
    echo $e->getMessage();
}
?>
<?php
$host = 'localhost';
$db_name = 'sekolah_sma';
$username = 'root'; // default untuk XAMPP
$password = ''; // kosongkan jika tidak ada password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

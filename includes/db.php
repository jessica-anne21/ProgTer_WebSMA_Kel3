<?php
$host = 'localhost';
$db_name = 'school_2';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true); 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

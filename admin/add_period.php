<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $stmt = $pdo->prepare("INSERT INTO periode (tahun_ajaran) VALUES (?)");
    $stmt->execute([$tahun_ajaran, $semester]);

    header('Location: manage_students.php');
    exit;
}
?>
<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM jadwal WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage_schedule.php");
    exit();
} else {
    echo "<script>alert('ID jadwal tidak ditemukan.'); window.location.href='manage_schedule.php';</script>";
    exit();
}
?>

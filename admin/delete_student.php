<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmtCheck = $pdo->prepare("
        SELECT COUNT(*) 
        FROM nilai 
        WHERE id_siswa = ?
    ");
    $stmtCheck->execute([$id]);
    $counts = $stmtCheck->fetchAll(PDO::FETCH_COLUMN);

    if ($counts[0] > 0 || $counts[1] > 0) {
        echo "<script>alert('Siswa tidak bisa dihapus karena sudah memiliki nilai.'); window.location.href='manage_students.php';</script>";
        exit();
    }

    $stmtDelete = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
    $stmtDelete->execute([$id]);

    header("Location: manage_students.php");
    exit();
} else {
    echo "<script>alert('ID siswa tidak ditemukan.'); window.location.href='manage_students.php';</script>";
    exit();
}
?>

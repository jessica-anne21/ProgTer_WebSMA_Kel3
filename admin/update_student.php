<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $stmtUpdate = $pdo->prepare("UPDATE siswa SET nama = ?, telepon = ?, email = ?, alamat = ?, jenis_kelamin = ?, agama = ?, tanggal_lahir = ? WHERE id = ?");
    $stmtUpdate->execute([$nama, $telepon, $email, $alamat, $jenis_kelamin, $agama, $tanggal_lahir, $id]);

    header("Location: manage_students.php");
    exit();
}
?>

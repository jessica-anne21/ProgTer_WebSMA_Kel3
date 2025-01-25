<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guru_id = $_POST['guru_id'];
    $mata_pelajaran_id = $_POST['mata_pelajaran_id'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan = $_POST['ruangan'];
    $periode_id = $_POST['periode_id']; 

    $stmt = $pdo->prepare("INSERT INTO jadwal (id_guru, id_mata_pelajaran, kelas, hari, jam_mulai, jam_selesai, ruangan, periode_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$guru_id, $mata_pelajaran_id, $kelas, $hari, $jam_mulai, $jam_selesai, $ruangan, $periode_id]);

    header('Location: manage_schedule.php');  
}
?>

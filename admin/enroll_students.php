<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $student_ids = $_POST['student_id']; 
    $periode_id = $_POST['periode_id']; 

    foreach ($student_ids as $student_id) {
        $stmt = $pdo->prepare("INSERT INTO siswa_mapel (id_siswa, id_mata_pelajaran, periode_id) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $subject_id, $periode_id]);

        // Masukkan nilai default (0)
        $nilai_stmt = $pdo->prepare("INSERT INTO nilai (id_siswa, id_mata_pelajaran, nilai_tugas, nilai_uts, nilai_uas,periode_id) VALUES (?, ?, 0, 0, 0,?)");
        $nilai_stmt->execute([$student_id, $subject_id, $periode_id]);
    }

    header('Location: manage_subjects.php?periode_id=' . $periode_id);
    exit;
}
?>

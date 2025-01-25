<?php
session_start();
include('../includes/db.php'); 
require_once('../includes/fpdf.php'); 

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$user = $_SESSION['user'];

if (!isset($_GET['siswa_id']) || empty($_GET['siswa_id'])) {
    die("Siswa tidak dipilih. Silakan kembali dan pilih siswa terlebih dahulu.");
}

$student_id = $_GET['siswa_id']; 

$stmt_student = $pdo->prepare("SELECT nama, id, alamat FROM siswa WHERE id = ?");
$stmt_student->execute([$student_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Data siswa tidak ditemukan.");
}

$stmt = $pdo->prepare("
    SELECT mp.nama AS mata_pelajaran, 
           n.nilai_tugas, 
           n.nilai_uts, 
           n.nilai_uas
    FROM nilai n
    JOIN mata_pelajaran mp ON n.id_mata_pelajaran = mp.id
    WHERE n.id_siswa = ?
");
$stmt->execute([$student_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image('../images/logo.png', 10, 10, 30); 

$pdf->Ln(20); 

// Judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Report Card', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Nama: ' . htmlspecialchars($student['nama']), 0, 1);
$pdf->Cell(40, 10, 'ID Siswa: ' . htmlspecialchars($student['id']), 0, 1);
$pdf->Cell(40, 10, 'Alamat: ' . htmlspecialchars($student['alamat']), 0, 1);

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Mata Pelajaran', 1, 0, 'C');
$pdf->Cell(30, 10, 'Nilai Akhir', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
foreach ($grades as $grade) {
    $nilai_tugas = $grade['nilai_tugas'] ?? 0;
    $nilai_uts = $grade['nilai_uts'] ?? 0;
    $nilai_uas = $grade['nilai_uas'] ?? 0;
    $nilai_akhir = ($nilai_tugas * 0.5) + ($nilai_uts * 0.25) + ($nilai_uas * 0.25);

    $pdf->Cell(90, 10, htmlspecialchars($grade['mata_pelajaran']), 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($nilai_akhir, 2), 1, 1, 'C');
}

// Output PDF ke browser
$pdf->Output("Report_Card_" . $student['id'] . ".pdf", "I");
exit();
?>

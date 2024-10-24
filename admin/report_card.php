<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

$siswa_id = $_GET['id'] ?? null;
if ($siswa_id) {
    $stmt = $pdo->prepare("SELECT siswa.nama AS siswa, mata_pelajaran.nama AS mata_pelajaran, nilai.nilai FROM nilai JOIN siswa ON nilai.id_siswa = siswa.id JOIN mata_pelajaran ON nilai.id_mata_pelajaran = mata_pelajaran.id WHERE siswa.id = ?");
    $stmt->execute([$siswa_id]);
    $rapor = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor Nilai Siswa</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Rapor Nilai Siswa</h1>
    <?php if ($rapor): ?>
        <h2>Nama Siswa: <?= $rapor[0]['siswa'] ?></h2>
        <table>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
            </tr>
            <?php foreach ($rapor as $row): ?>
                <tr>
                    <td><?= $row['mata_pelajaran'] ?></td>
                    <td><?= $row['nilai'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Data tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>

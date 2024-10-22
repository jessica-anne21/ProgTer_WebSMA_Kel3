<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $id_mata_pelajaran = $_POST['id_mata_pelajaran'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kelas = $_POST['kelas'];
    $nilai = $_POST['nilai'];

    $stmt = $pdo->prepare("INSERT INTO nilai (id_siswa, id_mata_pelajaran, tahun_ajaran, kelas, nilai) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_siswa, $id_mata_pelajaran, $tahun_ajaran, $kelas, $nilai]);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Nilai</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Manajemen Nilai</h1>
    <form method="POST">
        <select name="id_siswa" required>
            <option value="">Pilih Siswa</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM siswa");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
            }
            ?>
        </select>
        <select name="id_mata_pelajaran" required>
            <option value="">Pilih Mata Pelajaran</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM mata_pelajaran");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
            }
            ?>
        </select>
        <input type="text" name="tahun_ajaran" placeholder="Tahun Ajaran" required>
        <input type="text" name="kelas" placeholder="Kelas" required>
        <input type="number" name="nilai" placeholder="Nilai" required>
        <button type="submit">Tambah Nilai</button>
    </form>

    <h2>Daftar Nilai</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Tahun Ajaran</th>
            <th>Kelas</th>
            <th>Nilai</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT nilai.*, siswa.nama AS siswa, mata_pelajaran.nama AS mata_pelajaran FROM nilai JOIN siswa ON nilai.id_siswa = siswa.id JOIN mata_pelajaran ON nilai.id_mata_pelajaran = mata_pelajaran.id");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['siswa']}</td>
                    <td>{$row['mata_pelajaran']}</td>
                    <td>{$row['tahun_ajaran']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['nilai']}</td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>

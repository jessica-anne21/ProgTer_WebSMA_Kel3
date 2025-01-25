<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$user = $_SESSION['user'];
$id_guru = $user['id']; // ID Guru yang sedang login

// Ambil siswa yang terhubung dengan kelas yang diampu oleh guru wali
$siswa_stmt = $pdo->prepare("
    SELECT s.id, s.nama 
    FROM siswa s
    JOIN kelas k ON s.kelas_id = k.id
    WHERE k.guru_id = ?
");
$siswa_stmt->execute([$id_guru]);
$siswa_list = $siswa_stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_siswa = null;
$siswa_nilai = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['siswa_id'])) {
    $selected_siswa = $_POST['siswa_id'];

    // Ambil nilai siswa yang dipilih
    $stmt = $pdo->prepare("
        SELECT s.id AS siswa_id, s.nama AS siswa_nama, s.kelas_id,
               mp.nama AS mata_pelajaran_nama,
               n.nilai_tugas, n.nilai_uts, n.nilai_uas
        FROM siswa s
        JOIN kelas k ON s.kelas_id = k.id
        LEFT JOIN nilai n ON s.id = n.id_siswa
        LEFT JOIN mata_pelajaran mp ON n.id_mata_pelajaran = mp.id
        WHERE s.id = ? AND k.guru_id = ?
    ");
    $stmt->execute([$selected_siswa, $id_guru]);
    $siswa_nilai = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="guru_style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="guru_dashboard.php"><b>Dashboard Guru</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="guru_dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_grades.php">
                                <i class="fas fa-chart-line"></i> Manage Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_schedule.php">
                                <i class="fas fa-calendar"></i> View Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="report_card.php">
                                <i class="fas fa-chart-bar"></i> View Report Cards
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Rapor Siswa</h1>
                </div>

                <!-- Form untuk Pilih Siswa -->
                <form method="POST" class="mb-3">
                    <label for="siswa_id" class="form-label">Pilih Siswa:</label>
                    <select name="siswa_id" id="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach ($siswa_list as $siswa): ?>
                            <option value="<?= htmlspecialchars($siswa['id']) ?>" <?= ($selected_siswa == $siswa['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($siswa['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Tampilkan Nilai</button>
                </form>

                <!-- Menampilkan Rapor Siswa yang Dipilih -->
                <?php if ($selected_siswa && !empty($siswa_nilai)): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Nama Siswa:</strong> <?= htmlspecialchars($siswa_nilai[0]['siswa_nama']) ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($siswa_nilai as $row): 
                                        $nilai_tugas = $row['nilai_tugas'] ?? 0;
                                        $nilai_uts = $row['nilai_uts'] ?? 0;
                                        $nilai_uas = $row['nilai_uas'] ?? 0;
                                        $nilai_akhir = ($nilai_tugas * 0.5) + ($nilai_uts * 0.25) + ($nilai_uas * 0.25);
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['mata_pelajaran_nama']) ?></td>
                                            <td><?= number_format($nilai_akhir, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a href="download_reportcard.php?siswa_id=<?= htmlspecialchars($selected_siswa) ?>" class="btn btn-success mt-3">
                                Download PDF
                            </a>
                        </div>
                    </div>
                <?php elseif ($selected_siswa): ?>
                    <div class="alert alert-warning">
                        Tidak ada nilai untuk siswa ini atau siswa tidak valid.
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

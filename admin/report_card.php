<?php
include '../includes/db.php'; 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Ambil data siswa untuk dropdown
$siswa_stmt = $pdo->query("SELECT id, nama FROM siswa");
$siswa_list = $siswa_stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses ketika form dikirim
$selected_siswa = null;
$siswa_nilai = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['siswa_id'])) {
    $selected_siswa = $_POST['siswa_id'];
    
    // Ambil nilai untuk siswa yang dipilih
    $stmt = $pdo->prepare("
        SELECT s.id AS siswa_id, s.nama AS siswa_nama, s.kelas, 
               n.nilai, mp.id AS mata_pelajaran_id, mp.nama AS mata_pelajaran_nama
        FROM siswa s
        LEFT JOIN nilai n ON s.id = n.id_siswa
        LEFT JOIN mata_pelajaran mp ON n.id_mata_pelajaran = mp.id
        WHERE s.id = ?
    ");
    $stmt->execute([$selected_siswa]);
    $siswa_nilai = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Report Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>Admin Dashboard</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
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
                            <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_teachers.php">Manage Teachers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_students.php">Manage Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_subjects.php">Manage Subjects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_grades.php">Manage Grades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="report_card.php">Report Card</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Report Card</h1>
                </div>

                <!-- Dropdown untuk memilih siswa -->
                <form method="POST" class="mb-3">
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label">Pilih Siswa:</label>
                        <select name="siswa_id" id="siswa_id" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswa_list as $siswa): ?>
                                <option value="<?= htmlspecialchars($siswa['id']) ?>" <?= ($selected_siswa == $siswa['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($siswa['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan Nilai</button>
                </form>

                <!-- Tabel Siswa dan Nilai -->
                <div class="card">
                    <div class="card-header">
                        Daftar Nilai Siswa
                    </div>
                    <div class="card-body">
                        <?php if (!empty($siswa_nilai)): ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Siswa</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>ID Mata Pelajaran</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($siswa_nilai as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['siswa_id']) ?></td>
                                            <td><?= htmlspecialchars($row['siswa_nama']) ?></td>
                                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                                            <td><?= htmlspecialchars($row['mata_pelajaran_id']) ?></td>
                                            <td><?= htmlspecialchars($row['mata_pelajaran_nama']) ?></td>
                                            <td><?= htmlspecialchars($row['nilai']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Tidak ada nilai untuk siswa ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

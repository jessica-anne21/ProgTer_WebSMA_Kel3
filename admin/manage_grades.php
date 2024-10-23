<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan nilai
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $id_siswa = $_POST['id_siswa'];
    $id_mata_pelajaran = $_POST['id_mata_pelajaran'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kelas = $_POST['kelas'];
    $nilai = $_POST['nilai'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE nilai SET id_siswa = ?, id_mata_pelajaran = ?, tahun_ajaran = ?, kelas = ?, nilai = ? WHERE id = ?");
        $stmt->execute([$id_siswa, $id_mata_pelajaran, $tahun_ajaran, $kelas, $nilai, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO nilai (id_siswa, id_mata_pelajaran, tahun_ajaran, kelas, nilai) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_siswa, $id_mata_pelajaran, $tahun_ajaran, $kelas, $nilai]);
    }
    header('Location: manage_grades.php');
}

// Proses penghapusan nilai
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM nilai WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_grades.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="admin_style.css"> <!-- Custom CSS -->
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
                            <a class="nav-link" href="admin_dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_teachers.php">
                                <i class="fas fa-users"></i> Manage Teachers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_students.php">
                                <i class="fas fa-user-graduate"></i> Manage Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_subjects.php">
                                <i class="fas fa-book"></i> Manage Subjects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_grades.php">
                                <i class="fas fa-chart-line"></i> Manage Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report_card">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Nilai</h1>
                </div>

                <!-- Grades Form Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <?= isset($_GET['edit']) ? 'Edit Nilai' : 'Tambah Nilai' ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= $nilai['id'] ?? '' ?>">
                            <div class="col-md-4">
                                <label for="id_siswa" class="form-label">ID Siswa</label>
                                <input type="text" class="form-control" name="id_siswa" placeholder="ID Siswa" value="<?= $nilai['id_siswa'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="id_mata_pelajaran" class="form-label">ID Mata Pelajaran</label>
                                <input type="text" class="form-control" name="id_mata_pelajaran" placeholder="ID Mata Pelajaran" value="<?= $nilai['id_mata_pelajaran'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                <input type="text" class="form-control" name="tahun_ajaran" placeholder="Tahun Ajaran" value="<?= $nilai['tahun_ajaran'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="kelas" placeholder="Kelas" value="<?= $nilai['kelas'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nilai" class="form-label">Nilai</label>
                                <input type="text" class="form-control" name="nilai" placeholder="Nilai" value="<?= $nilai['nilai'] ?? '' ?>" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= isset($_GET['edit']) ? 'Update' : 'Tambah' ?> Nilai</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Grades Table Section -->
                <div class="card">
                    <div class="card-header">
                        Daftar Nilai
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID Siswa</th>
                                    <th>ID Mata Pelajaran</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM nilai");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['id_siswa']}</td>
                                            <td>{$row['id_mata_pelajaran']}</td>
                                            <td>{$row['tahun_ajaran']}</td>
                                            <td>{$row['kelas']}</td>
                                            <td>{$row['nilai']}</td>
                                            <td>
                                                <a href='manage_grades.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='manage_grades.php?delete={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Handle form submission for adding or updating grades
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $id_siswa = $_POST['id_siswa'];
    $id_mata_pelajaran = $_POST['id_mata_pelajaran'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kelas = $_POST['kelas'];
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE nilai SET id_siswa = ?, id_mata_pelajaran = ?, tahun_ajaran = ?, kelas = ?, nilai_tugas = ?, nilai_uts = ?, nilai_uas = ? WHERE id = ?");
        $stmt->execute([$id_siswa, $id_mata_pelajaran, $tahun_ajaran, $kelas, $nilai_tugas, $nilai_uts, $nilai_uas, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO nilai (id_siswa, id_mata_pelajaran, tahun_ajaran, kelas, nilai_tugas, nilai_uts, nilai_uas) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_siswa, $id_mata_pelajaran, $tahun_ajaran, $kelas, $nilai_tugas, $nilai_uts, $nilai_uas]);
    }
    header('Location: manage_grades.php');
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM nilai WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_grades.php');
}

// Fetch subjects
$subjects = $pdo->query("SELECT id, nama FROM mata_pelajaran")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all grades without filtering by class
$query = "
    SELECT n.*, s.nama AS nama_siswa, mp.nama AS nama_mata_pelajaran 
    FROM nilai n 
    LEFT JOIN siswa s ON n.id_siswa = s.id 
    LEFT JOIN mata_pelajaran mp ON n.id_mata_pelajaran = mp.id
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
    <style>
        #sidebarMenu {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
    </style>
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
                                <i class="fas fa-calendar"></i> Manage Schedule
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
                                <label for="id_mata_pelajaran" class="form-label">Nama Mata Pelajaran</label>
                                <select class="form-control" name="id_mata_pelajaran" required>
                                    <option value="">Pilih Mata Pelajaran</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= $subject['id'] ?>" <?= isset($nilai['id_mata_pelajaran']) && $nilai['id_mata_pelajaran'] == $subject['id'] ? 'selected' : '' ?>>
                                            <?= $subject['nama'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
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
                                <label for="nilai_tugas" class="form-label">Nilai Tugas</label>
                                <input type="number" class="form-control" name="nilai_tugas" placeholder="Nilai Tugas" value="<?= $nilai['nilai_tugas'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nilai_uts" class="form-label">Nilai UTS</label>
                                <input type="number" class="form-control" name="nilai_uts" placeholder="Nilai UTS" value="<?= $nilai['nilai_uts'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nilai_uas" class="form-label">Nilai UAS</label>
                                <input type="number" class="form-control" name="nilai_uas" placeholder="Nilai UAS" value="<?= $nilai['nilai_uas'] ?? '' ?>" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <?= isset($_GET['edit']) ? 'Update Nilai' : 'Tambah Nilai' ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Grades Table Section -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Siswa</th>
                                <th>Nama Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Tahun Ajaran</th>
                                <th>Kelas</th>
                                <th>Nilai Tugas</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grades as $grade): ?>
                                <tr>
                                    <td><?= $grade['id_siswa'] ?></td>
                                    <td><?= $grade['nama_siswa'] ?></td>
                                    <td><?= $grade['nama_mata_pelajaran'] ?></td>
                                    <td><?= $grade['tahun_ajaran'] ?></td>
                                    <td><?= $grade['kelas'] ?></td>
                                    <td><?= $grade['nilai_tugas'] ?></td>
                                    <td><?= $grade['nilai_uts'] ?></td>
                                    <td><?= $grade['nilai_uas'] ?></td>
                                    <td>
                                        <a href="?edit=<?= $grade['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?delete=<?= $grade['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

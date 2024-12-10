<?php
include '../includes/db.php'; 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $id_guru = $_POST['guru_id'];
    $id_mata_pelajaran = $_POST['mata_pelajaran_id'];
    $kelas = $_POST['kelas'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan = $_POST['ruangan'];  

    if ($id) {
        $stmt = $pdo->prepare("UPDATE jadwal SET id_guru = ?, id_mata_pelajaran = ?, kelas = ?, hari = ?, jam_mulai = ?, jam_selesai = ?, ruangan = ? WHERE id = ?");
        $stmt->execute([$id_guru, $id_mata_pelajaran, $kelas, $hari, $jam_mulai, $jam_selesai, $ruangan, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO jadwal (id_guru, id_mata_pelajaran, kelas, hari, jam_mulai, jam_selesai, ruangan) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_guru, $id_mata_pelajaran, $kelas, $hari, $jam_mulai, $jam_selesai, $ruangan]);
    }
    header('Location: manage_schedule.php');
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM jadwal WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_schedule.php');
}

$schedule = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM jadwal WHERE id = ?");
    $stmt->execute([$id]);
    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $pdo->query("SELECT * FROM guru");
$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM mata_pelajaran");
$mataPelajaran = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Jadwal</title>
    <link rel="stylesheet" href="admin_style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
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
                            <a class="nav-link" href="manage_grades.php">
                                <i class="fas fa-chart-line"></i> Manage Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Manage Schedule
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Jadwal</h1>
                </div>

                <!-- Form Jadwal -->
                <div class="card mb-4">
                    <div class="card-header">
                        <?= isset($schedule) ? 'Edit Jadwal' : 'Tambah Jadwal' ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= $schedule['id'] ?? '' ?>">
                            <div class="col-md-6">
                                <label for="guru_id" class="form-label">Guru</label>
                                <select class="form-select" name="guru_id" required>
                                    <option value="" disabled selected>Pilih Guru</option>
                                    <?php foreach ($gurus as $guru): ?>
                                        <option value="<?= $guru['id'] ?>" <?= (isset($schedule) && $schedule['id_guru'] == $guru['id']) ? 'selected' : '' ?>><?= $guru['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                                <select class="form-select" name="mata_pelajaran_id" required>
                                    <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                    <?php foreach ($mataPelajaran as $mp): ?>
                                        <option value="<?= $mp['id'] ?>" <?= (isset($schedule) && $schedule['id_mata_pelajaran'] == $mp['id']) ? 'selected' : '' ?>><?= $mp['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="kelas" value="<?= $schedule['kelas'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hari" class="form-label">Hari</label>
                                <input type="text" class="form-control" name="hari" value="<?= $schedule['hari'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" name="jam_mulai" value="<?= $schedule['jam_mulai'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" name="jam_selesai" value="<?= $schedule['jam_selesai'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="ruangan" class="form-label">Ruangan</label>
                                <input type="text" class="form-control" name="ruangan" value="<?= $schedule['ruangan'] ?? '' ?>" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Guru</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT jadwal.*, guru.nama AS guru_nama, mata_pelajaran.nama AS mata_pelajaran_nama FROM jadwal JOIN guru ON jadwal.id_guru = guru.id JOIN mata_pelajaran ON jadwal.id_mata_pelajaran = mata_pelajaran.id");
                            $no = 1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['guru_nama'] ?></td>
                                    <td><?= $row['mata_pelajaran_nama'] ?></td>
                                    <td><?= $row['kelas'] ?></td>
                                    <td><?= $row['hari'] ?></td>
                                    <td><?= $row['jam_mulai'] ?></td>
                                    <td><?= $row['jam_selesai'] ?></td>
                                    <td><?= $row['ruangan'] ?></td>
                                    <td>
                                        <a href="manage_schedule.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="manage_schedule.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

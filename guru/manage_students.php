<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password

    if ($id) {
        $stmt = $pdo->prepare("UPDATE siswa SET nama = ?, kelas = ?, alamat = ?, telepon = ?, jenis_kelamin = ?, agama = ?, email = ?, tanggal_lahir = ?, password = ? WHERE id = ?");
        $stmt->execute([$nama, $kelas, $alamat, $telepon, $jenis_kelamin, $agama, $email, $tanggal_lahir, $password, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO siswa (nama, kelas, alamat, telepon, jenis_kelamin, agama, email, tanggal_lahir, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $kelas, $alamat, $telepon, $jenis_kelamin, $agama, $email, $tanggal_lahir, $password]);
    }
    header('Location: manage_students.php');
}

// Proses penghapusan siswa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_students.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="guru_style.css"> 
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
            <a class="navbar-brand" href="#"><b>Dashboard Guru</b></a>
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
                            <a class="nav-link active" href="manage_students.php">
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
                            <a class="nav-link" href="view_schedule.php">
                                <i class="fas fa-calendar"></i> View Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report_card.php">
                                <i class="fas fa-chart-bar"></i> Reports
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Siswa</h1>
                </div>

                <!-- Students Form Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <?= isset($_GET['edit']) ? 'Edit Siswa' : 'Tambah Siswa' ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= $siswa['id'] ?? '' ?>">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Siswa" value="<?= $siswa['nama'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="kelas" placeholder="Kelas" value="<?= $siswa['kelas'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Alamat" required><?= $siswa['alamat'] ?? '' ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" name="telepon" placeholder="Telepon" value="<?= $siswa['telepon'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="L" <?= (isset($siswa['jenis_kelamin']) && $siswa['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= (isset($siswa['jenis_kelamin']) && $siswa['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="agama" class="form-label">Agama</label>
                                <input type="text" class="form-control" name="agama" placeholder="Agama" value="<?= $siswa['agama'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $siswa['email'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir" value="<?= $siswa['tanggal_lahir'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= isset($siswa['id']) ? 'Update' : 'Tambah' ?></button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Students Table Section -->
                <div class="card">
                    <div class="card-header">
                        Daftar Siswa
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Agama</th>
                                    <th>Email</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Tampilkan daftar siswa
                                $stmt = $pdo->query("SELECT * FROM siswa");
                                while ($siswa = $stmt->fetch()) {
                                    echo "<tr>
                                        <td>{$siswa['id']}</td>
                                        <td>{$siswa['nama']}</td>
                                        <td>{$siswa['kelas']}</td>
                                        <td>{$siswa['alamat']}</td>
                                        <td>{$siswa['telepon']}</td>
                                        <td>{$siswa['jenis_kelamin']}</td>
                                        <td>{$siswa['agama']}</td>
                                        <td>{$siswa['email']}</td>
                                        <td>{$siswa['tanggal_lahir']}</td>
                                        <td>
                                            <a href='manage_students.php?edit={$siswa['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='manage_students.php?delete={$siswa['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

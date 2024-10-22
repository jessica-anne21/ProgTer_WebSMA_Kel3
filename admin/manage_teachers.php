<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan guru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $telepon = $_POST['telepon'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE guru SET nama = ?, mata_pelajaran = ?, telepon = ? WHERE id = ?");
        $stmt->execute([$nama, $mata_pelajaran, $telepon, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO guru (nama, mata_pelajaran, telepon) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $mata_pelajaran, $telepon]);
    }
    header('Location: manage_teachers.php');
}

// Proses penghapusan guru
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM guru WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_teachers.php');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css"> <!-- Custom CSS for the page -->
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
                            <a class="nav-link active" href="manage_teachers.php">
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
                            <a class="nav-link" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i>
                                Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report_card">
                                <i class="fas fa-chart-bar"></i>
                                Reports
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Guru</h1>
                </div>

                <!-- Teacher Form Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <?= isset($_GET['edit']) ? 'Edit Guru' : 'Tambah Guru' ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= $guru['id'] ?? '' ?>">
                            <div class="col-md-4">
                                <label for="nama" class="form-label">Nama Guru</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Guru" value="<?= $guru['nama'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                                <input type="text" class="form-control" name="mata_pelajaran" placeholder="Mata Pelajaran" value="<?= $guru['mata_pelajaran'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" name="telepon" placeholder="Telepon" value="<?= $guru['telepon'] ?? '' ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= isset($_GET['edit']) ? 'Update' : 'Tambah' ?> Guru</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Teachers Table Section -->
                <div class="card">
                    <div class="card-header">
                        Daftar Guru
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM guru");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['nama']}</td>
                                            <td>{$row['mata_pelajaran']}</td>
                                            <td>{$row['telepon']}</td>
                                            <td>
                                                <a href='manage_teachers.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='manage_teachers.php?delete={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
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

    <!-- Bootstrap JS and Icons -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

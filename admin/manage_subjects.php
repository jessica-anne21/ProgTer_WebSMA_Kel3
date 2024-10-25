<?php
include '../includes/db.php'; 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Proses penambahan atau pengeditan mata pelajaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $guru_pengajar = $_POST['guru_pengajar'];

    if ($id) {
        // Update data mata pelajaran
        $stmt = $pdo->prepare("UPDATE mata_pelajaran SET nama = ?, guru_pengajar = ? WHERE id = ?");
        $stmt->execute([$nama, $guru_pengajar, $id]);
    } else {
        // Tambah data mata pelajaran
        $stmt = $pdo->prepare("INSERT INTO mata_pelajaran (nama, guru_pengajar) VALUES (?, ?)");
        $stmt->execute([$nama, $guru_pengajar]);
    }
    header('Location: manage_subjects.php');
}

// Proses penghapusan mata pelajaran
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM mata_pelajaran WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_subjects.php');
}

// Ambil data mata pelajaran untuk edit
$subject = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM mata_pelajaran WHERE id = ?");
    $stmt->execute([$id]);
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Ambil daftar guru untuk dropdown
$teachers = $pdo->query("SELECT * FROM guru")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Mata Pelajaran</title>
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
                        <a class="nav-link" aria-current="page" href="#">Home</a>
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
                            <a class="nav-link active" href="manage_subjects.php">
                                <i class="fas fa-book"></i> Manage Subjects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_grades.php">
                                <i class="fas fa-chart-line"></i> Manage Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Schedule
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
                    <h1 class="h2">Manajemen Mata Pelajaran</h1>
                </div>

                <!-- Form Mata Pelajaran -->
                <div class="card mb-4">
                    <div class="card-header">
                        <?= isset($subject) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="row g-3">
                            <input type="hidden" name="id" value="<?= $subject['id'] ?? '' ?>">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama Mata Pelajaran" value="<?= $subject['nama'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="guru_pengajar" class="form-label">Guru Pengajar</label>
                                <select class="form-select" name="guru_pengajar" required>
                                    <option value="" disabled <?= !isset($subject) ? 'selected' : '' ?>>Pilih Guru</option>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>" <?= (isset($subject) && $subject['guru_pengajar'] == $teacher['id']) ? 'selected' : '' ?>>
                                            <?= $teacher['nama'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><?= isset($subject) ? 'Update' : 'Tambah' ?> Mata Pelajaran</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Mata Pelajaran -->
                <div class="card">
                    <div class="card-header">
                        Daftar Mata Pelajaran
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Guru Pengajar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT mp.*, g.nama AS nama_guru FROM mata_pelajaran mp LEFT JOIN guru g ON mp.guru_pengajar = g.id");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['nama']}</td>
                                            <td>{$row['nama_guru']}</td>
                                            <td>
                                                <a href='manage_subjects.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='manage_subjects.php?delete={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit;
}

$error = null;
$students = [];
$class = [];
$unassigned_students = [];

try {
    if (isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];
    
        // Ambil data kelas
        $stmt = $pdo->prepare("SELECT kelas_level, kelas_type FROM kelas WHERE id = :class_id");
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
        $stmt->execute();
        $class = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($class) {
            // Ambil siswa yang ada di kelas ini
            $stmt = $pdo->prepare("
                SELECT s.id, s.nama, s.jenis_kelamin, s.alamat, s.email
                FROM siswa s
                WHERE s.kelas_id = :class_id
            ");
            $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Ambil siswa yang belum memiliki kelas
            $stmt = $pdo->prepare("
                SELECT id, nama
                FROM siswa
                WHERE kelas_id IS NULL
            ");
            $stmt->execute();
            $unassigned_students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Kelas dengan ID $class_id tidak ditemukan.";
        }
    } else {
        $error = "ID kelas tidak ditemukan.";
    }
    

    // Proses penambahan siswa ke kelas
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['students']) && isset($class_id)) {
        $selected_students = $_POST['students'];

        foreach ($selected_students as $student_id) {
            $updateStmt = $pdo->prepare("UPDATE siswa SET kelas_id = ? WHERE id = ?");
            $updateStmt->execute([$class_id, $student_id]);
        }

        header("Location: view_students.php?class_id=" . $class_id);
        exit;
    }

} catch (Exception $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Guru</title>
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
            <a class="navbar-brand" href="admin_dashboard.php"><b>Admin Dashboard</b></a>
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
                            <a class="nav-link" href="manage_period.php">
                                <i class="fas fa-calendar"></i> Manage Periods
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
                            <a class="nav-link" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Manage Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_classes.php">
                                <i class="fas fa-chalkboard"></i> Manage Classes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Daftar Siswa - Kelas 
                    <?= isset($class['kelas_level']) ? $class['kelas_level'] : 'N/A' ?> 
                    <?= isset($class['kelas_type']) ? $class['kelas_type'] : 'N/A' ?>
                </h1>
                </div>

                <!-- Display error message jika terjadi error -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>


                <h3>Tambah Siswa yang Ada ke Kelas</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label for="students" class="form-label">Pilih Siswa yang Akan Dimasukkan ke Kelas Ini</label>
                        <div id="students" class="form-check">
                            <?php foreach ($unassigned_students as $student): ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="students[]" value="<?= $student['id'] ?>" id="student<?= $student['id'] ?>">
                                    <label class="form-check-label" for="student<?= $student['id'] ?>"><?= $student['nama'] ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambahkan Siswa ke Kelas</button>
                </form>


                <h3 class="mt-4">Daftar Siswa di Kelas</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Siswa</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $index => $student): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $student['id'] ?></td>
                                        <td><?= $student['nama'] ?></td>
                                        <td><?= $student['jenis_kelamin'] ?></td>
                                        <td><?= $student['alamat'] ?></td>
                                        <td><?= $student['email'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Tidak ada siswa terdaftar di kelas ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

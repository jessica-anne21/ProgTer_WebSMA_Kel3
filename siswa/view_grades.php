<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$user = $_SESSION['user'];
$student_id = $user['id'];

$stmt = $pdo->prepare("
    SELECT mp.nama AS mata_pelajaran, 
           n.nilai_tugas AS nilai_tugas, 
           n.nilai_ujian AS nilai_ujian
    FROM nilai n
    JOIN mata_pelajaran mp ON n.id_mata_pelajaran = mp.id
    WHERE n.id_siswa = ?
");
$stmt->execute([$student_id]);
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>View Grades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="siswa_style.css"> 
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="siswa_dashboard.php"><b>Dashboard Siswa</b></a>
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
                            <a class="nav-link" href="siswa_dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_schedule.php">
                                <i class="fas fa-calendar"></i> View Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="view_grades.php">
                                <i class="fas fa-chart-line"></i> View Grades
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_reportcard.php">
                                <i class="fas fa-chart-bar"></i> View Report Card
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Nilai Saya</h1>
                </div>

                <!-- Grades Table -->
                <div class="card">
                    <div class="card-header">
                        Daftar Nilai
                    </div>
                    <div class="card-body">
                        <?php if (!empty($grades)): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Nilai Tugas</th>
                                        <th>Nilai Ujian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($grades as $grade): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grade['mata_pelajaran']) ?></td>
                                            <td><?= htmlspecialchars($grade['nilai_tugas']) ?></td>
                                            <td><?= htmlspecialchars($grade['nilai_ujian']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Anda belum memiliki nilai untuk mata pelajaran apa pun.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
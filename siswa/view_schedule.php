<?php
session_start();
include('../includes/db.php'); 

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$user = $_SESSION['user'];
$student_id = $user['id'];

$query_jadwal = "
    SELECT DISTINCT j.hari, j.jam_mulai, j.jam_selesai, j.ruangan, 
           mp.nama AS nama_mata_pelajaran, g.nama AS nama_guru
    FROM jadwal j
    JOIN mata_pelajaran mp ON j.id_mata_pelajaran = mp.id
    JOIN guru g ON j.id_guru = g.id
    JOIN siswa_mapel sm ON sm.id_mata_pelajaran = mp.id
    WHERE sm.id_siswa = :student_id
    ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), j.jam_mulai
";


$stmt_jadwal = $pdo->prepare($query_jadwal);
$stmt_jadwal->bindParam(':student_id', $student_id, PDO::PARAM_INT);
$stmt_jadwal->execute();
$result_jadwal = $stmt_jadwal->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>View Schedule</title>
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
                            <a class="nav-link active" href="view_schedule.php">
                                <i class="fas fa-calendar"></i> View Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_grades.php">
                                <i class="fas fa-chart-line"></i> View Grades
                            </a>
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
                    <h1 class="h2">Jadwal Saya</h1>
                </div>

                <!-- Tabel Jadwal -->
                <div class="card">
                    <div class="card-header">
                        Daftar Jadwal
                    </div>
                    <div class="card-body">
                        <?php if (!empty($result_jadwal)): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th> 
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Ruangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($result_jadwal as $jadwal): ?>
                                        <tr>
                                            <td><?= ($jadwal['nama_mata_pelajaran']) ?></td>
                                            <td><?= ($jadwal['nama_guru']) ?></td> 
                                            <td><?= ($jadwal['hari']) ?></td>
                                            <td><?= ($jadwal['jam_mulai']) ?></td>
                                            <td><?= ($jadwal['jam_selesai']) ?></td>
                                            <td><?= ($jadwal['ruangan']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No schedule found for your class.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

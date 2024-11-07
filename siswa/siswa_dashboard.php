<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php'); 
    exit();
}

$user = $_SESSION['user']; 

if (!isset($user['nama'])) {
    $id = $user['id']; 
    $stmt = $pdo->prepare("SELECT nama FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    $student_name = $student ? $student['nama'] : 'Siswa';
} else {
    $student_name = $user['nama'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="siswa_style.css"> 
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>Dashboard Siswa</b></a>
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

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Halo, <?= htmlspecialchars($student_name) ?>!</h1>
                </div>

                <!-- Content Area -->
                <div class="card mb-4">
                    <div class="card-header">
                        Info Dashboard
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di dashboard Anda. Gunakan sidebar untuk mengakses jadwal, nilai, mata pelajaran, dan raport Anda.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


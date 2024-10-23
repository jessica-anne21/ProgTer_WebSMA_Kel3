<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

// Query to count the total number of teachers
$stmt_teachers = $pdo->query("SELECT COUNT(*) AS total_teachers FROM guru");
$total_teachers = $stmt_teachers->fetch(PDO::FETCH_ASSOC)['total_teachers'];

// Query to count the total number of students
$stmt_students = $pdo->query("SELECT COUNT(*) AS total_students FROM siswa");
$total_students = $stmt_students->fetch(PDO::FETCH_ASSOC)['total_students'];

// Query to count the total number of subjects
$stmt_subjects = $pdo->query("SELECT COUNT(*) AS total_subjects FROM mata_pelajaran");
$total_subjects = $stmt_subjects->fetch(PDO::FETCH_ASSOC)['total_subjects'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
                            <a class="nav-link active" href="admin_dashboard.php">
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
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Dashboard Summary Cards -->
                <div class="row">
                    <!-- Total Teachers -->
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">
                                <i class="fas fa-chalkboard-teacher"></i> Total Teachers
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $total_teachers ?></h5>
                                <p class="card-text">Total number of teachers in the system.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Students -->
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">
                                <i class="fas fa-user-graduate"></i> Total Students
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $total_students ?></h5>
                                <p class="card-text">Total number of students in the system.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Subjects -->
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">
                                <i class="fas fa-book"></i> Total Subjects
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $total_subjects ?></h5>
                                <p class="card-text">Total number of subjects available.</p>
                            </div>
                        </div>
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

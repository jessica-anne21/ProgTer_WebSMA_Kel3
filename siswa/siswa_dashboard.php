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
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>Dashboard Siswa</b></a>
            <a class="nav-link" href="../index.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Halo, <?= htmlspecialchars($student_name) ?>!</h2>
        <p>Selamat datang di dashboard Anda.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

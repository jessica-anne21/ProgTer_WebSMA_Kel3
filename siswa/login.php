<?php
include '../includes/db.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; 
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user; 
        header('Location: siswa_dashboard.php'); 
        exit();
    } else {
        $error = "ID Siswa atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #001f3f;
            color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            max-width: 400px;
            padding: 2rem;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            color: #001f3f;
        }
        .login-card .card-title {
            font-weight: bold;
            color: #001f3f;
        }
        .login-card .btn-primary {
            background-color: #001f3f;
            border: none;
            width: 100%;
        }
        .login-card .btn-primary:hover {
            background-color: #001537;
        }

    </style>
</head>
<body>
    <div class="login-card card">
        <h2 class="card-title text-center">Login Siswa</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= ($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group mb-3">
                <label for="id">ID Siswa</label>
                <input type="text" id="id" name="id" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

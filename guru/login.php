<?php
include '../includes/db.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM guru WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nama' => $user['nama'],
            'role' => $user['role'], // Ambil role dari database
            'email' => $user['email']
        ];

        // Proses verifikasi role
        if ($user['role'] === 'guru_wali') {
            header('Location: guru_dashboard.php'); 
        } else {
            header('Location: guru_biasa_dashboard.php'); 
        }
        exit();
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Guru</title>
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
        .register-link {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #001f3f;
            text-decoration: none;
        }
        .register-link:hover {
            color: #001537;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card card">
        <h2 class="card-title text-center">Login Guru</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register_guru.php" class="register-link">Register Now</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
        $_SESSION['user'] = 'admin';
        header('Location: ../admin/admin_dashboard.php'); 
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #001f3f;
            color: white;
        }
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            color: #001f3f;
        }
        .login-card .card-title {
            text-align: center;
            font-weight: bold;
        }
        .login-card .btn-primary {
            background-color: #001f3f;
            border: none;
        }
        .login-card .btn-primary:hover {
            background-color: #001537;
        }
        .register-link {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #001f3f;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card card">
        <h2 class="card-title">Login Admin</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger text-center"><?= ($error) ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include '../includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $stmt = $pdo->prepare("INSERT INTO guru (nama, telepon, email, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nama, $telepon, $email, $password])) {
        echo "Akun guru berhasil dibuat!";
    } else {
        echo "Terjadi kesalahan saat membuat akun: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #001f3f;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            color: #001f3f;
        }
        h2 {
            text-align: center;
            color: #001f3f;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #001f3f;
            border: none;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #001537;
        }
        .login-link {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #001f3f;
            text-decoration: none;
        }
        .login-link:hover {
            color: #001537;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Register Guru</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" name="telepon">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="login-link">Login</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

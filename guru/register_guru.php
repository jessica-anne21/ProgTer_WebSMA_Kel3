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
        }
        .register-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .register-card {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            color: #001f3f;
        }
        .register-card .card-title {
            text-align: center;
            font-weight: bold;
        }
        .register-card .btn-primary {
            background-color: #001f3f;
            border: none;
        }
        .register-card .btn-primary:hover {
            background-color: #001537;
        }
        .back-link {
            text-align: center;
            display: block;
            margin-top: 1rem;
            color: #001f3f;
            text-decoration: none;
        }
        .back-link:hover {
            color: #001537;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card card">
            <h2 class="card-title">Register Guru</h2>
            <form action="register_process.php" method="post">
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="telepon">Telepon</label>
                    <input type="text" id="telepon" name="telepon" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <a href="login.php" class="back-link">Back to Login</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

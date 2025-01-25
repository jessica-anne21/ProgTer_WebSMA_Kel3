<?php
include '../includes/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $jabatan = $_POST['jabatan'];
    $alamat = $_POST['alamat'];

    $stmt = $pdo->prepare("INSERT INTO guru (nama, telepon, email, password, jabatan, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nama, $telepon, $email, $password, $jabatan, $alamat])) {
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
            max-width: 600px;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            color: #001f3f;
        }
        h2 {
            text-align: center;
            color: #001f3f;
            font-weight: bold;
            margin-bottom: 1rem;
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
            margin-top: 0.5rem;
            color: #001f3f;
            text-decoration: none;
        }
        .login-link:hover {
            color: #001537;
            text-decoration: underline;
        }
        .row .col-md-6 {
            padding-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register Guru</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" name="telepon">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="2" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Register</button>
            <a href="login.php" class="login-link">Login</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

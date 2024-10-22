<?php
session_start();
// Simulasi login, Anda bisa menghubungkan ke database untuk autentikasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek username dan password (hardcode untuk contoh)
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin') {
        $_SESSION['user'] = 'admin';
        header('Location: ../admin/admin_dashboard.php');
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container-1">    
        <h1>Login</h1>
        <?php if (isset($error)) echo $error; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

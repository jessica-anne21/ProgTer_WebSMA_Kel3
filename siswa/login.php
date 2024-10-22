<?php
session_start();
include('../includes/db.php'); // Make sure this points to the correct database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to get the user with the role 'guru' and the entered username
    $query = "SELECT * FROM users WHERE username='$username' AND role='guru' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // If the user is found and the password is correct
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Set session role as 'guru'
        header('Location: ../guru/guru_dashboard.php'); // Redirect to Guru's dashboard
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa</title>
    <link rel="stylesheet" href="../assets/style.css"> 
</head>
<body>
    <div class="container-1">    
        <h1>Login Siswa</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="NIS" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

    </div>
</body>
</html>

<?php
session_start();
include('../includes/db.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'guru'; // Set role to 'guru'

    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        // Hash the password for secure storage
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the new user into the database
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $role;
            header('Location: ../guru/guru_dashboard.php'); // Redirect to guru dashboard after successful registration
            exit();
        } else {
            $error = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Guru</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Make sure this points to your CSS file -->
</head>
<body>
    <div class="container-1">    
        <h1>Register Guru</h1>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php" class="text-success">Login disini</a></p>
    </div>
</body>
</html>

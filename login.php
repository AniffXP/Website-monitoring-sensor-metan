<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }

    $stmt->close();
    $koneksi->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login - Sistem Monitoring Sensor Metan PT Pupuk Sriwidjaja Palembang">
    <title>Login - Sensor Monitoring System</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <img src="assets/img/pupuk.jpg" alt="Logo PT Pusri">
                <h1>Sensor Monitoring</h1>
                <p>PT Pupuk Sriwidjaja Palembang</p>
            </div>
            
            <h2>Selamat Datang</h2>
            <p class="login-subtitle">Silakan masuk ke akun Anda</p>
            
            <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="textbox">
                    <label for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Masukkan username" 
                        required
                        autocomplete="username"
                    >
                </div>
                
                <div class="textbox">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Masukkan password" 
                        required
                        autocomplete="current-password"
                    >
                </div>
                
                <button type="submit" class="btn">Masuk</button>
            </form>
            
            <div class="login-footer">
                <p>&copy; <?php echo date('Y'); ?> PT Pupuk Sriwidjaja Palembang</p>
            </div>
        </div>
    </div>
</body>
</html>

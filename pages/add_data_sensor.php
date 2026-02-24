<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $koordinat = $_POST['koordinat'];

    $query = "INSERT INTO tbjenissensor (id, nama, koordinat) VALUES ('$id', '$nama', '$koordinat')";
    if ($koneksi->query($query) === TRUE) {
        header("Location: daily_monitoring.php");
        exit();
    } else {
        $error = "Error: " . $koneksi->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi Sensor - Sensor Monitoring System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="dashboard.php">
                <img src="../assets/img/pupuk.jpg" class="header-logo" alt="Logo PT Pusri Palembang">
            </a>
            <nav class="navigation">
                <a href="daily_monitoring.php" class="nav-link">Daily Monitoring</a>
            </nav>
            <div class="user-menu">
                <div class="user-avatar" onclick="toggleDropdown()">
                    <img src="../assets/img/1.png" alt="User" class="avatar-img">
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <a href="../logout.php" class="logout">Keluar</a>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Lokasi Sensor</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="add_data_sensor.php">
                        <div class="form-group">
                            <label class="form-label" for="id">ID</label>
                            <input type="text" class="form-input" id="id" name="id" placeholder="Masukkan ID" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama Lokasi</label>
                            <input type="text" class="form-input" id="nama" name="nama" placeholder="Contoh: Pusri TI" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="koordinat">Koordinat</label>
                            <input type="text" class="form-input" id="koordinat" name="koordinat" placeholder="Contoh: -2.9682017, 104.8004501" required>
                            <p class="form-help">Format: latitude, longitude</p>
                        </div>
                        
                        <div class="form-actions">
                            <a href="daily_monitoring.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan Lokasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <script src="../assets/js/main.js"></script>
</body>
</html>

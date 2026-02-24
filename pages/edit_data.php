<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$row = null;
if (isset($_GET['waktu'])) {
    $waktu = $_GET['waktu'];
    $query = "SELECT * FROM tbdatasensor WHERE waktu='$waktu'";
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waktu_old = $_POST['waktu_old'];
    $waktu = $_POST['waktu'];
    $nilaiakurasi = $_POST['nilaiakurasi'];

    $query = "UPDATE tbdatasensor SET waktu='$waktu', nilaiakurasi='$nilaiakurasi' WHERE waktu='$waktu_old'";
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
    <title>Edit Data Sensor - Sensor Monitoring System</title>
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
                    <h3 class="card-title">Edit Data Akurasi Sensor</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($row): ?>
                    <form method="POST" action="edit_data.php?waktu=<?php echo urlencode($waktu); ?>">
                        <input type="hidden" name="waktu_old" value="<?php echo htmlspecialchars($row['waktu']); ?>">
                        
                        <div class="form-group">
                            <label class="form-label" for="id">ID Sensor</label>
                            <input type="text" class="form-input" id="id" value="<?php echo htmlspecialchars($row['id']); ?>" disabled>
                            <p class="form-help">ID tidak dapat diubah</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="waktu">Waktu</label>
                            <input type="datetime-local" class="form-input" id="waktu" name="waktu" 
                                   value="<?php echo date('Y-m-d\TH:i', strtotime($row['waktu'])); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nilaiakurasi">Nilai Akurasi (ppm)</label>
                            <input type="number" step="0.01" class="form-input" id="nilaiakurasi" name="nilaiakurasi" 
                                   value="<?php echo htmlspecialchars($row['nilaiakurasi']); ?>" required>
                        </div>
                        
                        <div class="form-actions">
                            <a href="daily_monitoring.php" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="alert alert-error">Data tidak ditemukan!</div>
                    <a href="daily_monitoring.php" class="btn btn-secondary">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
    <script src="../assets/js/main.js"></script>
</body>
</html>

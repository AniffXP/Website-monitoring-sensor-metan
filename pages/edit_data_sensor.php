<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$row = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM tbjenissensor WHERE id='$id'";
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $koordinat = $_POST['koordinat'];

    $query = "UPDATE tbjenissensor SET nama='$nama', koordinat='$koordinat' WHERE id='$id'";
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
    <title>Edit Lokasi Sensor - Sensor Monitoring System</title>
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
                    <h3 class="card-title">Edit Lokasi Sensor</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($row): ?>
                    <form method="POST" action="edit_data_sensor.php?id=<?php echo urlencode($id); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        
                        <div class="form-group">
                            <label class="form-label" for="id_display">ID</label>
                            <input type="text" class="form-input" id="id_display" value="<?php echo htmlspecialchars($row['id']); ?>" disabled>
                            <p class="form-help">ID tidak dapat diubah</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama Lokasi</label>
                            <input type="text" class="form-input" id="nama" name="nama" 
                                   value="<?php echo htmlspecialchars($row['nama']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="koordinat">Koordinat</label>
                            <input type="text" class="form-input" id="koordinat" name="koordinat" 
                                   value="<?php echo htmlspecialchars($row['koordinat']); ?>" required>
                            <p class="form-help">Format: latitude, longitude</p>
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

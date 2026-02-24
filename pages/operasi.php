<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$pageTitle = "Operasi";
include '../includes/db.php';

// Query data
$query1 = "SELECT * FROM tbdatasensor ORDER BY waktu DESC";
$result1 = $koneksi->query($query1);
$sensorData = [];
while ($row = $result1->fetch_assoc()) {
    $sensorData[] = $row;
}

$query2 = "SELECT * FROM tbjenissensor";
$result2 = $koneksi->query($query2);
$sensorList = [];
while ($row = $result2->fetch_assoc()) {
    $sensorList[] = $row;
}

$koneksi->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Sensor Monitoring System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="dashboard.php" class="logo-link">
                <img src="../assets/img/pupuk.jpg" class="header-logo" alt="Logo PT Pusri Palembang">
            </a>
            
            <nav class="navigation" id="main-nav">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="daily_monitoring.php" class="nav-link">Daily Monitoring</a>
                <a href="operasi.php" class="nav-link active">Operasi</a>
            </nav>
            
            <div class="user-menu">
                <div class="user-avatar" onclick="toggleDropdown()">
                    <img src="../assets/img/1.png" alt="User" class="avatar-img">
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <div class="user-dropdown-email">PT Pupuk Sriwidjaja Palembang</div>
                    </div>
                    <a href="../logout.php" class="logout">Keluar</a>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title"><span class="highlight">Operasi</span></h1>
            <p class="page-subtitle">Data operasional sensor metan</p>
        </div>
        
        <div class="grid grid-2 gap-lg">
            <!-- Sensor Data Table -->
            <div class="table-container" style="margin-bottom: 0;">
                <div class="table-header">
                    <h3 class="table-title">Data Akurasi Sensor</h3>
                </div>
                <div class="table-wrapper" style="max-height: 500px; overflow-y: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Waktu</th>
                                <th>Nilai Akurasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sensorData as $data): ?>
                            <tr>
                                <td><span class="badge badge-primary"><?php echo htmlspecialchars($data['id']); ?></span></td>
                                <td><?php echo htmlspecialchars($data['waktu']); ?></td>
                                <td><strong><?php echo htmlspecialchars($data['nilaiakurasi']); ?></strong> ppm</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Sensor List Table -->
            <div class="table-container" style="margin-bottom: 0;">
                <div class="table-header">
                    <h3 class="table-title">Daftar Sensor</h3>
                </div>
                <div class="table-wrapper" style="max-height: 500px; overflow-y: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Koordinat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sensorList as $sensor): ?>
                            <tr>
                                <td><span class="badge badge-success"><?php echo htmlspecialchars($sensor['id']); ?></span></td>
                                <td><strong><?php echo htmlspecialchars($sensor['nama']); ?></strong></td>
                                <td><code style="font-size: 11px;"><?php echo htmlspecialchars($sensor['koordinat']); ?></code></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <footer style="background: var(--white); padding: 20px; margin-top: 40px; text-align: center; border-top: 1px solid var(--gray-200);">
        <p style="color: var(--text-secondary); font-size: 13px;">
            &copy; <?php echo date('Y'); ?> PT Pupuk Sriwidjaja Palembang
        </p>
    </footer>
    
    <script src="../assets/js/main.js"></script>
</body>
</html>

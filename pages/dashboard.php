<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$pageTitle = "Dashboard";
include '../includes/db.php';

// Query data from the database
$query = "SELECT * FROM tbdatasensor ORDER BY waktu DESC";
$result = $koneksi->query($query);

$sensorData = [];
while ($row = $result->fetch_assoc()) {
    $sensorData[] = $row;
}

// Calculate statistics
$totalData = count($sensorData);
$totalPressure = 0;
$maxValue = 0;
$minValue = PHP_FLOAT_MAX;

foreach ($sensorData as $data) {
    $val = floatval($data['nilaiakurasi']);
    $totalPressure += $val;
    if ($val > $maxValue) $maxValue = $val;
    if ($val < $minValue) $minValue = $val;
}

$averagePressure = $totalData > 0 ? $totalPressure / $totalData : 0;
if ($minValue == PHP_FLOAT_MAX) $minValue = 0;

// Count sensors
$querySensor = "SELECT COUNT(*) as total FROM tbjenissensor";
$resultSensor = $koneksi->query($querySensor);
$totalSensors = $resultSensor->fetch_assoc()['total'];

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
                <a href="dashboard.php" class="nav-link active">Dashboard</a>
                <a href="daily_monitoring.php" class="nav-link">Daily Monitoring</a>
                <a href="operasi.php" class="nav-link">Operasi</a>
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
            <h1 class="page-title"><span class="highlight">Dashboard</span></h1>
            <p class="page-subtitle">Ringkasan data sensor metan</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-icon">TD</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $totalData; ?></div>
                    <div class="stat-label">Total Data Sensor</div>
                </div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-icon">LS</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $totalSensors; ?></div>
                    <div class="stat-label">Lokasi Sensor</div>
                </div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-icon">RR</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo number_format($averagePressure, 2); ?></div>
                    <div class="stat-label">Rata-rata (ppm)</div>
                </div>
            </div>
            
            <div class="stat-card info">
                <div class="stat-icon">NT</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo number_format($maxValue, 2); ?></div>
                    <div class="stat-label">Nilai Tertinggi (ppm)</div>
                </div>
            </div>
        </div>
        
        <!-- Chart -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Grafik Akurasi Sensor Metan</h3>
            </div>
            <canvas id="sensorChart" height="100"></canvas>
        </div>
        
        <!-- Recent Data Table -->
        <div class="table-container mt-xl">
            <div class="table-header">
                <h3 class="table-title">Data Terbaru</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Waktu</th>
                            <th>Nilai Akurasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count = 0;
                        foreach ($sensorData as $data): 
                            if ($count >= 5) break;
                            $count++;
                            $val = floatval($data['nilaiakurasi']);
                            $status = $val > 80 ? 'success' : ($val > 50 ? 'warning' : 'danger');
                            $statusText = $val > 80 ? 'Baik' : ($val > 50 ? 'Sedang' : 'Rendah');
                        ?>
                        <tr>
                            <td><span class="badge badge-primary"><?php echo htmlspecialchars($data['id']); ?></span></td>
                            <td><?php echo htmlspecialchars($data['waktu']); ?></td>
                            <td><strong><?php echo htmlspecialchars($data['nilaiakurasi']); ?></strong> ppm</td>
                            <td><span class="badge badge-<?php echo $status; ?>"><?php echo $statusText; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <footer style="background: var(--white); padding: 20px; margin-top: 40px; text-align: center; border-top: 1px solid var(--gray-200);">
        <p style="color: var(--text-secondary); font-size: 13px;">
            &copy; <?php echo date('Y'); ?> PT Pupuk Sriwidjaja Palembang - Sistem Monitoring Sensor Metan
        </p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        const sensorData = <?php echo json_encode($sensorData); ?>;
        
        function formatDate(dateString) {
            const options = { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
        
        const labels = sensorData.map(data => formatDate(data.waktu));
        const dataValues = sensorData.map(data => parseFloat(data.nilaiakurasi));
        
        const ctx = document.getElementById('sensorChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.reverse(),
                datasets: [{
                    label: 'Nilai Akurasi (ppm)',
                    data: dataValues.reverse(),
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { font: { family: 'Inter', size: 12 } }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Inter' },
                        bodyFont: { family: 'Inter' },
                        padding: 10,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    y: {
                        grid: { color: '#e5e7eb' },
                        ticks: { font: { family: 'Inter', size: 11 } },
                        title: {
                            display: true,
                            text: 'Nilai Akurasi (ppm)',
                            font: { family: 'Inter', size: 12 }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

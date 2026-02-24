<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$pageTitle = "Daily Monitoring";
include '../includes/db.php';

// Query sensor data
$query1 = "SELECT * FROM tbdatasensor ORDER BY waktu DESC";
$result1 = $koneksi->query($query1);

// Query sensor locations
$query2 = "SELECT * FROM tbjenissensor";
$result2 = $koneksi->query($query2);

$locations = [];
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .monitoring-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            align-items: start;
        }
        .tables-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .map-column {
            position: sticky;
            top: 100px;
        }
        .map-box {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
        }
        .map-box-header {
            padding: 12px 16px;
            background: var(--card-header-gradient);
            color: white;
        }
        .map-box-header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        #map {
            height: 500px;
            width: 100%;
        }
        @media (max-width: 1024px) {
            .monitoring-layout {
                grid-template-columns: 1fr;
            }
            .map-column {
                position: static;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="dashboard.php" class="logo-link">
                <img src="../assets/img/pupuk.jpg" class="header-logo" alt="Logo PT Pusri Palembang">
            </a>
            
            <nav class="navigation" id="main-nav">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="daily_monitoring.php" class="nav-link active">Daily Monitoring</a>
                <a href="operasi.php" class="nav-link">Operasi</a>
            </nav>
            
            <div class="user-menu">
                <div class="user-avatar" onclick="toggleDropdown()">
                    <img src="../assets/img/1.png" alt="User" class="avatar-img">
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <div class="user-dropdown-email">PT PuPupuk Sriwidjajasri Palembang</div>
                    </div>
                    <a href="../logout.php" class="logout">Keluar</a>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title"><span class="highlight">Daily Monitoring</span></h1>
            <p class="page-subtitle">Pantau data harian sensor metan</p>
        </div>
        
        <div class="monitoring-layout">
            <!-- Data Tables Column -->
            <div class="tables-column">
                <!-- Sensor Data Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">Akurasi Data Sensor</h3>
                        <button class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white;" onclick="addData('tbdatasensor')">
                            + Tambah
                        </button>
                    </div>
                    <div class="table-wrapper">
                        <?php if ($result1 && $result1->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Waktu</th>
                                    <th>Nilai Akurasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result1->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="badge badge-primary"><?php echo htmlspecialchars($row['id']); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['nilaiakurasi']); ?></strong> ppm</td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-sm btn-primary" onclick="editData('tbdatasensor', '<?php echo htmlspecialchars($row['waktu']); ?>')">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteData('tbdatasensor', '<?php echo htmlspecialchars($row['waktu']); ?>')">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="card-body text-center text-muted">
                            <p>Belum ada data sensor.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Sensor Locations Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">Lokasi Sensor</h3>
                        <button class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white;" onclick="addData('tbjenissensor')">
                            + Tambah
                        </button>
                    </div>
                    <div class="table-wrapper">
                        <?php if ($result2 && $result2->num_rows > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Koordinat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result2->fetch_assoc()): 
                                    $coords = explode(',', $row['koordinat']);
                                    if (count($coords) == 2) {
                                        $locations[] = [
                                            'lat' => floatval(trim($coords[0])),
                                            'lng' => floatval(trim($coords[1])),
                                            'nama' => htmlspecialchars($row['nama'])
                                        ];
                                    }
                                ?>
                                <tr>
                                    <td><span class="badge badge-success"><?php echo htmlspecialchars($row['id']); ?></span></td>
                                    <td><strong><?php echo htmlspecialchars($row['nama']); ?></strong></td>
                                    <td><code style="font-size: 11px;"><?php echo htmlspecialchars($row['koordinat']); ?></code></td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-sm btn-primary" onclick="editData('tbjenissensor', <?php echo $row['id']; ?>)">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteData('tbjenissensor', <?php echo $row['id']; ?>)">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="card-body text-center text-muted">
                            <p>Belum ada lokasi sensor.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Map Column -->
            <div class="map-column">
                <div class="map-box">
                    <div class="map-box-header">
                        <h3>Peta Lokasi Sensor</h3>
                    </div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </main>
    
    <footer style="background: var(--white); padding: 20px; margin-top: 40px; text-align: center; border-top: 1px solid var(--gray-200);">
        <p style="color: var(--text-secondary); font-size: 13px;">
            &copy; <?php echo date('Y'); ?> PT Pupuk Sriwidjaja Palembang
        </p>
    </footer>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        var locations = <?php echo json_encode($locations); ?>;
        
        // Initialize map
        if (locations.length > 0) {
            var map = L.map('map').setView([locations[0].lat, locations[0].lng], 12);
        } else {
            var map = L.map('map').setView([-2.990934, 104.755731], 12);
        }
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        
        var colors = ['#2563eb', '#0d9488', '#f59e0b', '#ef4444', '#8b5cf6'];
        
        locations.forEach(function(loc, index) {
            var color = colors[index % colors.length];
            var markerHtml = '<div style="background:' + color + ';width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.3);border:2px solid white;"><span style="color:white;font-size:10px;font-weight:600;">' + (index + 1) + '</span></div>';
            
            var customIcon = L.divIcon({
                className: 'custom-marker',
                html: markerHtml,
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });
            
            L.marker([loc.lat, loc.lng], { icon: customIcon })
                .addTo(map)
                .bindPopup('<div style="font-family:Inter,sans-serif;"><strong>' + loc.nama + '</strong><br><small style="color:#64748b;">' + loc.lat.toFixed(4) + ', ' + loc.lng.toFixed(4) + '</small></div>');
        });
    </script>
</body>
</html>
<?php $koneksi->close(); ?>

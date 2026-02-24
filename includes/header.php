<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page for active nav highlighting
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring Sensor Metan - PT Pusri Palembang">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Sensor Monitoring System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <?php if (isset($additionalCSS)): ?>
    <style><?php echo $additionalCSS; ?></style>
    <?php endif; ?>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="index.php">
                <img src="assets/img/pupuk.jpg" class="header-logo" alt="Logo PT Pusri Palembang">
            </a>
            
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <nav class="navigation" id="main-nav">
                <a href="index.php" class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
                    🏠 Beranda
                </a>
                <a href="pages/dashboard.php" class="nav-link <?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>">
                    📊 Dashboard
                </a>
                <a href="pages/daily_monitoring.php" class="nav-link <?php echo $currentPage === 'daily_monitoring.php' ? 'active' : ''; ?>">
                    📅 Daily Monitoring
                </a>
                <a href="pages/operasi.php" class="nav-link <?php echo $currentPage === 'operasi.php' ? 'active' : ''; ?>">
                    ⚙️ Operasi
                </a>
                <a href="pages/lingkungan.php" class="nav-link <?php echo $currentPage === 'lingkungan.php' ? 'active' : ''; ?>">
                    🗺️ Peta Lokasi
                </a>
            </nav>
            
            <div class="user-menu">
                <div class="user-icon" onclick="toggleDropdown()" role="button" tabindex="0">
                    <?php 
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
                    echo strtoupper(substr($username, 0, 2)); 
                    ?>
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name">
                            <?php echo htmlspecialchars($username); ?>
                        </div>
                        <div class="user-dropdown-email">PT Pusri Palembang</div>
                    </div>
                    <a href="index.php">🏠 Beranda</a>
                    <a href="pages/dashboard.php">📊 Dashboard</a>
                    <a href="logout.php" class="logout">🚪 Keluar</a>
                </div>
            </div>
        </div>
    </header>
    
    <main class="main-content">

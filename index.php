<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Redirect langsung ke Daily Monitoring
header("Location: pages/daily_monitoring.php");
exit();
?>

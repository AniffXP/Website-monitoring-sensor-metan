<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (isset($_GET['waktu'])) {
    $waktu = $_GET['waktu'];
    $query = "DELETE FROM tbdatasensor WHERE waktu='$waktu'";
    $koneksi->query($query);
}

header("Location: ../index.php");
exit();
?>

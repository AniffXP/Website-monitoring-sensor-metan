<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM tbjenissensor WHERE id='$id'";
    $koneksi->query($query);
}

header("Location: ../index.php");
exit();
?>

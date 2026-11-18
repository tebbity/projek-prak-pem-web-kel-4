<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}
include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM lapangan WHERE id_lapangan = '$id'");

header("Location: index.php");
exit;
?>
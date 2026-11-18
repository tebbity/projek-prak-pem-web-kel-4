<?php
include '../cek_login.php';
include '../koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM lapangan WHERE id_lapangan = '$id'");

header("Location: index.php");
exit;
?>
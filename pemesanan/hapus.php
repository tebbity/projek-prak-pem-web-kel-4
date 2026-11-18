<?php
include '../koneksi.php';

$id = $_GET['id'];

// hapus dulu pembayaran milik pemesanan ini (kalau ada)
mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_pemesanan = '$id'");

// baru hapus pemesanannya
mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_pemesanan = '$id'");

header("Location: index.php");
exit;
?>
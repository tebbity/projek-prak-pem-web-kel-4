<?php
include '../koneksi.php';

$id = $_GET['id'];


$q = mysqli_query($koneksi, "SELECT id_pemesanan FROM pembayaran WHERE id_pembayaran = '$id'");
$row = mysqli_fetch_array($q);
$id_pemesanan = $row['id_pemesanan'];

mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_pembayaran = '$id'");


$q = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total_bayar FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'");
$b = mysqli_fetch_array($q);

$q2 = mysqli_query($koneksi, "SELECT total_harga FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'");
$p = mysqli_fetch_array($q2);

if ($b['total_bayar'] >= $p['total_harga']) {
    $status = 'lunas';
} else {
    $status = 'belum';
}
mysqli_query($koneksi, "UPDATE pemesanan SET status_bayar = '$status' WHERE id_pemesanan = '$id_pemesanan'");

header("Location: index.php");
exit;
?>
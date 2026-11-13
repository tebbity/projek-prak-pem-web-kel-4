<?php
$koneksi = mysqli_connect("localhost", "root", "", "penyewaan_lap_badminton");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
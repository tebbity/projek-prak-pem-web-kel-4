<?php
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM lapangan");
while ($row = mysqli_fetch_assoc($data)) {
    echo $row['nama_lapangan'] . " - Rp " . $row['harga_per_jam'] . "<br>";
}
?>
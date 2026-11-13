<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama    = $_POST['nama_lapangan'];
    $lantai  = $_POST['jenis_lantai'];
    $harga   = $_POST['harga_per_jam'];
    $status  = $_POST['status'];

     mysqli_query($koneksi, "INSERT INTO lapangan (nama_lapangan, jenis_lantai, harga_per_jam, status)
                            VALUES ('$nama', '$lantai', '$harga', '$status')");

                            header("Location: index.php");
                            exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan</title>
</head>
<body>
    <h2>Tambah Lapangan</h2>
    <form method="POST">
    Nama Lapangan:<br>
    <input type="text" name="nama_lapangan" required><br><br>

    Jenis Lantai:<br>
    <input type="text" name="jenis_lantai"><br><br>

    Harga per Jam:<br>
    <input type="text" name="harga_per_jam" required><br><br>

    Status:<br>
    <select name="status">
        <option value="aktif">aktif</option>
        <option value="perbaikan">perbaikan</option>
    </select><br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="index.php">Batal</a>
</form>
    
</body>
</html>
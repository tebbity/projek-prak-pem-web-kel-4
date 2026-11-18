<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];

    mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_hp)
                            VALUES ('$nama', '$no_hp')");
    
    header("Location: index.php");
    exit;             
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
</head>
<body>
    <h2>Tambah Pelanggan</h2>
    <form method="POST">
        Nama:<br>
        <input type="text" name="nama" required<br><br>

        No HP:<br>
        <input type="text" name="no_hp"><br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Batal</a>
</from> 
</body>
</html>
<?php
include '../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id'");
$row = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $nama  = $_POST['nama'];
    $no_hp = $_POST['no_hp'];

    $hasil = mysqli_query($koneksi, "UPDATE pelanggan SET
        nama = '$nama',
        no_hp = '$no_hp'
        WHERE id_pelanggan = '$id'");

    if (!$hasil) {
        die("Gagal update: " . mysqli_error($koneksi));
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
</head>
<body>
    <h2>Edit Pelanggan</h2>
    <form method="POST">
        Nama:<br>
        <input type="text" name="nama" value="<?= $row['nama'] ?>" required><br><br>

        No HP:<br>
        <input type="text" name="no_hp" value="<?= $row['no_hp'] ?>"><br><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
    
    
    
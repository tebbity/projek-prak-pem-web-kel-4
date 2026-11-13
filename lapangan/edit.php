<?php
include '../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = '$id'");
$row = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama_lapangan'];
    $lantai = $_POST['jenis_lantai'];
    $harga  = $_POST['harga_per_jam'];
    $status = $_POST['status'];

    mysqli_query($koneksi, "UPDATE lapangan SET
    nama_lapangan = '$nama',
    jenis_lantai  = '$lantai',
    harga_per_jam = '$harga',
    status = '$status'
    WHERE id_lapangan = '$id' ");

    header("Location: index.php");
    exit;    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Lapangan</title>
</head>
<body>
    <h2>Edit Lapangan</h2>
    <form method="POST">
        Nama Lapangan:<br>
        <input type="text" name="nama_lapangan" value="<?= $row['nama_lapangan'] ?>" required><br><br>

        Jenis Lantai:<br>
        <input type="text" name="jenis_lantai" value="<?= $row['jenis_lantai'] ?>"><br><br>

        Harga per Jam:<br>
        <input type="number" name="harga_per_jam" value="<?= $row['harga_per_jam'] ?>" required><br><br>

        Status:<br>
        <select name="status">
            <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : '' ?>>aktif</option>
            <option value="perbaikan" <?= $row['status'] == 'perbaikan' ? 'selected' : '' ?>>perbaikan</option>
        </select><br><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
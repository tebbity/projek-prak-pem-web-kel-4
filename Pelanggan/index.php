<?php
include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
</head>
<body>
    <h2>Data Pelanggan</h2>
    <a href="tambah.php">+ Tambah Pelanggan</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Aksi</th>
</tr>
<?php $no = 1; while ($row = mysqli_fetch_array($data)) {?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['no_hp'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['id_pelanggan'] ?>">Edit</a>
        <a href="hapus.php?id=<?= $row['id_pelanggan'] ?>"onclick="return confirm('Yakin hapus?')">Hapus</a>
</td>
</tr>
<?php } ?>
</table>

   
</body>
</html>
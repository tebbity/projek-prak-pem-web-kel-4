<?php
include '../cek_login.php';
include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lapangan</title>
</head>
<body>
    <h2>Data Lapangan</h2>
    <a href="tambah.php">+ Tambah Lapangan</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jenis Lantai</th>
            <th>Harga/Jam</th>
            <th>Status</th>
            <th>Aksi</th>
</tr>
<?php $no = 1; while ($row = mysqli_fetch_assoc($data)) { ?>
<tr> 
    <td><?= $no++ ?></td>
    <td>
        <?php if ($row['foto']) { ?>
        <img src="../uploads/<?= $row['foto'] ?>" width="80">
        <?php } else { echo "-"; } ?>
</td>
<td><?= $row['nama_lapangan'] ?></td>
<td><?= $row['jenis_lantai'] ?></td>
<td>Rp <?= number_format($row['harga_per_jam'], 0, ',', '.') ?></td>
<td><?= $row['status'] ?></td>
<td>
    <a href="edit.php?id=<?= $row['id_lapangan'] ?>">Edit</a>
    <a href="hapus.php?id=<?= $row['id_lapangan'] ?>" onclik="return confirm('Yakin hapus?')">Hapus</a>
</td>
</tr>
<?php } ?>
</table>

    
</body>
</html>
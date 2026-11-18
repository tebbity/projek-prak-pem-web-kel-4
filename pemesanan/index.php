<?php
include '../koneksi.php';

$data = mysqli_query($koneksi, "SELECT pemesanan.*, pelanggan.nama, lapangan.nama_lapangan
    FROM pemesanan
    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan
    ORDER BY pemesanan.tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pemesanan</title>
</head>
<body>
    <h2>Data Pemesanan</h2>
    <a href="tambah.php">+ Tambah Pemesanan</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Total</th>
            <th>Status Bayar</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_array($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['nama_lapangan'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></td>
            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            <td><?= $row['status_bayar'] ?></td>
            <td><?= $row['status_pemesanan'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_pemesanan'] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id_pemesanan'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
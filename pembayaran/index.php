<?php
include '../koneksi.php';

$data = mysqli_query($koneksi, "SELECT pembayaran.*, pelanggan.nama, lapangan.nama_lapangan, pemesanan.tanggal
    FROM pembayaran
    JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan
    ORDER BY pembayaran.tanggal_bayar DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pembayaran</title>
</head>
<body>
    <h2>Data Pembayaran</h2>
    <a href="tambah.php">+ Tambah Pembayaran</a>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Lapangan</th>
            <th>Tanggal Main</th>
            <th>Tanggal Bayar</th>
            <th>Jumlah</th>
            <th>Metode</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_array($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['nama_lapangan'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['tanggal_bayar'] ?></td>
            <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
            <td><?= $row['metode_bayar'] ?></td>
            <td><?= $row['keterangan'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_pembayaran'] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id_pembayaran'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
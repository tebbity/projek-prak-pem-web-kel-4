<?php
include '../koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT pembayaran.*, pelanggan.nama, lapangan.nama_lapangan, pemesanan.tanggal
    FROM pembayaran
    JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan
    WHERE pembayaran.id_pembayaran = '$id'");
$row = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $jumlah     = $_POST['jumlah_bayar'];
    $metode     = $_POST['metode_bayar'];
    $keterangan = $_POST['keterangan'];
    $id_pemesanan = $row['id_pemesanan'];

    mysqli_query($koneksi, "UPDATE pembayaran SET
        jumlah_bayar = '$jumlah',
        metode_bayar = '$metode',
        keterangan = '$keterangan'
        WHERE id_pembayaran = '$id'");

    
    $q = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total_bayar FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'");
    $b = mysqli_fetch_array($q);

    $q2 = mysqli_query($koneksi, "SELECT total_harga FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'");
    $p = mysqli_fetch_array($q2);

    if ($b['total_bayar'] >= $p['total_harga']) {
        $status = 'lunas';
    } else {
        $status = 'belum';
    }
    mysqli_query($koneksi, "UPDATE pemesanan SET status_bayar = '$status' WHERE id_pemesanan = '$id_pemesanan'");

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pembayaran</title>
</head>
<body>
    <h2>Edit Pembayaran</h2>
    <form method="POST" autocomplete="off">
        Pelanggan:<br>
        <input type="text" value="<?= $row['nama'] ?> - <?= $row['nama_lapangan'] ?> (<?= $row['tanggal'] ?>)" disabled size="40"><br><br>

        Jumlah Bayar:<br>
        <input type="number" name="jumlah_bayar" value="<?= $row['jumlah_bayar'] ?>" required><br><br>

        Metode (tunai / transfer):<br>
        <input type="text" name="metode_bayar" value="<?= $row['metode_bayar'] ?>" required><br><br>

        Keterangan:<br>
        <input type="text" name="keterangan" value="<?= $row['keterangan'] ?>"><br><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
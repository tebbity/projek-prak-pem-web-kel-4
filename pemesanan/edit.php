<?php
include '../koneksi.php';

$id = $_GET['id'];
$pesan = "";

// ambil data pemesanan + nama pelanggan + nama lapangan
$data = mysqli_query($koneksi, "SELECT pemesanan.*, pelanggan.nama, lapangan.nama_lapangan
    FROM pemesanan
    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan
    WHERE pemesanan.id_pemesanan = '$id'");
$row = mysqli_fetch_array($data);

// untuk saran (datalist)
$lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE status = 'aktif'");

if (isset($_POST['update'])) {
    $nama_lapangan   = $_POST['nama_lapangan'];
    $tanggal         = $_POST['tanggal'];
    $jam_mulai       = $_POST['jam_mulai'];
    $jam_selesai     = $_POST['jam_selesai'];
    $status_bayar    = $_POST['status_bayar'];
    $status_pesanan  = $_POST['status_pemesanan'];

    $q = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE nama_lapangan = '$nama_lapangan'");
    $l = mysqli_fetch_array($q);

    $durasi = (strtotime($jam_selesai) - strtotime($jam_mulai)) / 3600;

    if (!$l) {
        $pesan = "Lapangan tidak ditemukan, pilih dari saran yang muncul!";
    } elseif ($durasi <= 0) {
        $pesan = "Jam selesai harus lebih besar dari jam mulai!";
    } else {
        $id_lapangan = $l['id_lapangan'];
        $total = $durasi * $l['harga_per_jam'];

        mysqli_query($koneksi, "UPDATE pemesanan SET
            id_lapangan = '$id_lapangan',
            tanggal = '$tanggal',
            jam_mulai = '$jam_mulai',
            jam_selesai = '$jam_selesai',
            total_harga = '$total',
            status_bayar = '$status_bayar',
            status_pemesanan = '$status_pesanan'
            WHERE id_pemesanan = '$id'");

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemesanan</title>
</head>
<body>
    <h2>Edit Pemesanan</h2>
    <p style="color:red;"><?= $pesan ?></p>
    <form method="POST">
        Pelanggan:<br>
        <input type="text" value="<?= $row['nama'] ?>" disabled><br><br>

        Nama Lapangan:<br>
        <input type="text" name="nama_lapangan" list="daftar_lapangan" value="<?= $row['nama_lapangan'] ?>" required>
        <datalist id="daftar_lapangan">
            <?php while ($l = mysqli_fetch_array($lapangan)) { ?>
                <option value="<?= $l['nama_lapangan'] ?>">
            <?php } ?>
        </datalist><br><br>

        Tanggal:<br>
        <input type="date" name="tanggal" value="<?= $row['tanggal'] ?>" required><br><br>

        Jam Mulai:<br>
        <input type="time" name="jam_mulai" value="<?= $row['jam_mulai'] ?>" required><br><br>

        Jam Selesai:<br>
        <input type="time" name="jam_selesai" value="<?= $row['jam_selesai'] ?>" required><br><br>

        Status Bayar:<br>
        <select name="status_bayar">
            <option value="belum" <?= $row['status_bayar'] == 'belum' ? 'selected' : '' ?>>belum</option>
            <option value="lunas" <?= $row['status_bayar'] == 'lunas' ? 'selected' : '' ?>>lunas</option>
        </select><br><br>

        Status Pemesanan:<br>
        <select name="status_pemesanan">
            <option value="dipesan" <?= $row['status_pemesanan'] == 'dipesan' ? 'selected' : '' ?>>dipesan</option>
            <option value="selesai" <?= $row['status_pemesanan'] == 'selesai' ? 'selected' : '' ?>>selesai</option>
            <option value="batal" <?= $row['status_pemesanan'] == 'batal' ? 'selected' : '' ?>>batal</option>
        </select><br><br>

        <button type="submit" name="update">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
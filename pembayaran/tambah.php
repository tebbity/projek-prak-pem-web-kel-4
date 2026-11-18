<?php
include '../koneksi.php';

$pesan = "";

if (isset($_POST['simpan'])) {
    $nama       = $_POST['nama_pelanggan'];
    $tanggal    = $_POST['tanggal'];
    $jumlah     = $_POST['jumlah_bayar'];
    $metode     = $_POST['metode_bayar'];
    $keterangan = $_POST['keterangan'];

    
    $sql = "SELECT pemesanan.* FROM pemesanan
        JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
        WHERE pelanggan.nama = '$nama'
        AND pemesanan.status_bayar = 'belum'
        AND pemesanan.status_pemesanan != 'batal'";

    if ($tanggal != '') {
        $sql .= " AND pemesanan.tanggal = '$tanggal'";
    }

    $cari = mysqli_query($koneksi, $sql);
    $jml  = mysqli_num_rows($cari);

    if ($jml == 0) {
        $pesan = "Tidak ada pemesanan belum lunas atas nama tersebut (cek nama atau tanggal).";
    } elseif ($jml > 1) {
        $pesan = "Ada lebih dari 1 pemesanan belum lunas. Isi tanggal main supaya jelas yang mana.";
    } else {
        $p = mysqli_fetch_array($cari);
        $id_pemesanan = $p['id_pemesanan'];

        mysqli_query($koneksi, "INSERT INTO pembayaran (id_pemesanan, jumlah_bayar, metode_bayar, keterangan)
            VALUES ('$id_pemesanan', '$jumlah', '$metode', '$keterangan')");

        $q = mysqli_query($koneksi, "SELECT SUM(jumlah_bayar) AS total_bayar FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'");
        $b = mysqli_fetch_array($q);

        if ($b['total_bayar'] >= $p['total_harga']) {
            mysqli_query($koneksi, "UPDATE pemesanan SET status_bayar = 'lunas' WHERE id_pemesanan = '$id_pemesanan'");
        }

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
</head>
<body>
    <h2>Tambah Pembayaran</h2>
    <p style="color:red;"><?= $pesan ?></p>
    <form method="POST" autocomplete="off">
        Nama Pelanggan:<br>
        <input type="text" name="nama_pelanggan" autocomplete="off" required><br><br>

        Tanggal Main (isi kalau pelanggan punya lebih dari 1 pemesanan):<br>
        <input type="date" name="tanggal"><br><br>

        Jumlah Bayar:<br>
        <input type="number" name="jumlah_bayar" required><br><br>

        Metode (tunai / transfer):<br>
        <input type="text" name="metode_bayar" autocomplete="off" required><br><br>

        Keterangan (misal DP / Pelunasan):<br>
        <input type="text" name="keterangan" autocomplete="off"><br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
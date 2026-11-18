<?php
include '../koneksi.php';

$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$lapangan  = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE status = 'aktif'");
$pesan = "";

if (isset($_POST['simpan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp          = $_POST['no_hp'];
    $nama_lapangan  = $_POST['nama_lapangan'];
    $tanggal        = $_POST['tanggal'];
    $jam_mulai      = $_POST['jam_mulai'];
    $jam_selesai    = $_POST['jam_selesai'];

    // cari lapangan berdasarkan nama yang diketik
    $q = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE nama_lapangan = '$nama_lapangan' AND status = 'aktif'");
    $l = mysqli_fetch_array($q);

    $durasi = (strtotime($jam_selesai) - strtotime($jam_mulai)) / 3600;

    if (!$l) {
        $pesan = "Lapangan tidak ditemukan, pilih dari saran yang muncul!";
    } elseif ($durasi <= 0) {
        $pesan = "Jam selesai harus lebih besar dari jam mulai!";
    } else {
        // cari pelanggan, kalau belum ada tambahkan baru
        $cek = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE nama = '$nama_pelanggan'");
        if (mysqli_num_rows($cek) > 0) {
            $p = mysqli_fetch_array($cek);
            $id_pelanggan = $p['id_pelanggan'];
        } else {
            mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_hp) VALUES ('$nama_pelanggan', '$no_hp')");
            $id_pelanggan = mysqli_insert_id($koneksi);
        }

        $id_lapangan = $l['id_lapangan'];
        $total = $durasi * $l['harga_per_jam'];

        mysqli_query($koneksi, "INSERT INTO pemesanan
            (id_pelanggan, id_lapangan, id_user, tanggal, jam_mulai, jam_selesai, total_harga, status_bayar, status_pemesanan)
            VALUES
            ('$id_pelanggan', '$id_lapangan', 1, '$tanggal', '$jam_mulai', '$jam_selesai', '$total', 'belum', 'dipesan')");

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pemesanan</title>
</head>
<body>
    <h2>Tambah Pemesanan</h2>
    <p style="color:red;"><?= $pesan ?></p>
    <form method="POST">
        Nama Pelanggan:<br>
        <input type="text" name="nama_pelanggan" list="daftar_pelanggan" required>
        <datalist id="daftar_pelanggan">
            <?php while ($p = mysqli_fetch_array($pelanggan)) { ?>
                <option value="<?= $p['nama'] ?>">
            <?php } ?>
        </datalist><br><br>

        No HP (isi kalau pelanggan baru):<br>
        <input type="text" name="no_hp"><br><br>

        Nama Lapangan:<br>
        <input type="text" name="nama_lapangan" list="daftar_lapangan" required>
        <datalist id="daftar_lapangan">
            <?php while ($l = mysqli_fetch_array($lapangan)) { ?>
                <option value="<?= $l['nama_lapangan'] ?>">
            <?php } ?>
        </datalist><br><br>

        Tanggal:<br>
        <input type="date" name="tanggal" required><br><br>

        Jam Mulai:<br>
        <input type="time" name="jam_mulai" required><br><br>

        Jam Selesai:<br>
        <input type="time" name="jam_selesai" required><br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
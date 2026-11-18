<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["status_login"]) || $_SESSION["status_login"] != true) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];

// 1. PROSES TAMBAH BOOKING (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, trim($_POST['nama_pelanggan']));
    $no_hp          = mysqli_real_escape_string($koneksi, trim($_POST['no_hp']));
    $id_lapangan    = mysqli_real_escape_string($koneksi, $_POST['id_lapangan']);
    $tanggal        = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam_mulai      = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai    = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);

    // Validasi jam selesai harus lebih besar dari jam mulai
    if ($jam_selesai <= $jam_mulai) {
        echo "<script>
                alert('Jam selesai harus lebih besar dari jam mulai.');
                window.history.back();
              </script>";
        exit();
    }

    // Cek jadwal sewa yang bentrok
    $cek_jadwal = mysqli_query($koneksi, "SELECT * FROM pemesanan 
        WHERE id_lapangan = '$id_lapangan' 
        AND tanggal = '$tanggal' 
        AND (jam_mulai < '$jam_selesai' AND jam_selesai > '$jam_mulai')");

    if (mysqli_num_rows($cek_jadwal) > 0) {
        echo "<script>
                alert('Jadwal sewa bentrok dengan pemesanan lain.');
                window.history.back();
              </script>";
        exit();
    }

    // Hitung total harga sewa
    $lap_res = mysqli_query($koneksi, "SELECT harga_per_jam FROM lapangan WHERE id_lapangan = '$id_lapangan'");
    $lap_row = mysqli_fetch_assoc($lap_res);
    $durasi = (strtotime($jam_selesai) - strtotime($jam_mulai)) / 3600;
    $total_harga = $durasi * $lap_row['harga_per_jam'];

    // Cek atau simpan data pelanggan
    $cek_pelanggan = mysqli_query($koneksi, "SELECT id_pelanggan FROM pelanggan WHERE nama = '$nama_pelanggan' AND no_hp = '$no_hp'");
    if (mysqli_num_rows($cek_pelanggan) > 0) {
        $pelanggan_row = mysqli_fetch_assoc($cek_pelanggan);
        $id_pelanggan = $pelanggan_row['id_pelanggan'];
    } else {
        mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_hp) VALUES ('$nama_pelanggan', '$no_hp')");
        $id_pelanggan = mysqli_insert_id($koneksi);
    }

    // Simpan data pemesanan
    $insert = "INSERT INTO pemesanan (id_pelanggan, id_lapangan, id_user, tanggal, jam_mulai, jam_selesai, total_harga, status_bayar, status_pemesanan) 
               VALUES ('$id_pelanggan', '$id_lapangan', '$id_user', '$tanggal', '$jam_mulai', '$jam_selesai', '$total_harga', 'belum', 'dipesan')";

    if (mysqli_query($koneksi, $insert)) {
        echo "<script>
                alert('Pemesanan berhasil.');
                window.location = 'sewa.php';
              </script>";
        exit();
    } else {
        $error_msg = addslashes(mysqli_error($koneksi));
        echo "<script>
                alert('Error: $error_msg');
                window.location = 'sewa.php';
              </script>";
        exit();
    }
}

// 2. PROSES AKSI TOMBOL TABEL (GET: lunas, selesai, hapus/batalkan)
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $aksi = $_GET['aksi'];
    $id_pemesanan = mysqli_real_escape_string($koneksi, $_GET['id']);

    if ($aksi == 'lunas' && $role == 'admin') {
        mysqli_query($koneksi, "UPDATE pemesanan SET status_bayar = 'lunas' WHERE id_pemesanan = '$id_pemesanan'");
        echo "<script>alert('Status pembayaran diubah menjadi Lunas.'); window.location = 'sewa.php';</script>";
        exit();
    } elseif ($aksi == 'selesai' && $role == 'admin') {
        mysqli_query($koneksi, "UPDATE pemesanan SET status_pemesanan = 'selesai' WHERE id_pemesanan = '$id_pemesanan'");
        echo "<script>alert('Status pemesanan ditandai Selesai.'); window.location = 'sewa.php';</script>";
        exit();
    } elseif ($aksi == 'hapus') {
        if ($role == 'admin') {
            mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_pemesanan = '$id_pemesanan'");
        } else {
            // User hanya bisa membatalkan pesanannya sendiri yang belum lunas
            mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_pemesanan = '$id_pemesanan' AND id_user = '$id_user' AND status_bayar = 'belum'");
        }
        echo "<script>alert('Pemesanan berhasil dihapus/dibatalkan.'); window.location = 'sewa.php';</script>";
        exit();
    }
}

header("Location: sewa.php");
exit();
?>
<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION["status_login"]) || $_SESSION["status_login"] != true){
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

$lapangan_query = mysqli_query($koneksi, "SELECT * FROM lapangan");

if($role == 'admin'){
    $sewa_query = "SELECT pemesanan.*, pelanggan.nama AS nama_pelanggan, pelanggan.no_hp, lapangan.nama_lapangan, lapangan.jenis_lantai FROM pemesanan
                    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
                    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan 
                    ORDER BY pemesanan.id_pemesanan DESC";
} else {
    $sewa_query = "SELECT pemesanan.*, pelanggan.nama AS nama_pelanggan, pelanggan.no_hp, lapangan.nama_lapangan, lapangan.jenis_lantai FROM pemesanan
                    JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan
                    JOIN lapangan ON pemesanan.id_lapangan = lapangan.id_lapangan 
                    WHERE pemesanan.id_user = '$id_user'
                    ORDER BY pemesanan.id_pemesanan DESC";
}
$data_sewa = mysqli_query($koneksi, $sewa_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sewa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light text-dark">
   <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sistem Penyewaan Lapangan Badminton</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>   
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lapangan/index.php">Data Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sewa.php">Data Sewa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Konten -->
    <div class="container mt-5">
        <div class="row g-4">
            <!-- Form Booking / Tambah Data Sewa -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">
                            <?= ($role == 'admin') ? 'Input Sewa (Admin)' : 'Booking Lapangan'; ?>
                        </h4>
                        <form action="sewa_proses.php" method="POST">
                            <div class="mb-3">
                                <label for="nama_pelanggan" class="form-label">Nama Pemesan</label>
                                <?php if ($role == 'admin'): ?>
                                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama pelanggan" required>
                                <?php else: ?>
                                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="<?= htmlspecialchars($nama); ?>" readonly>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_lapangan" class="form-label">Lapangan & Jenis Lantai</label>
                                <select class="form-select" id="id_lapangan" name="id_lapangan" required>
                                    <option value="">-- Pilih Lapangan --</option>
                                    <?php while ($lap = mysqli_fetch_assoc($lapangan_query)): ?>
                                        <option value="<?= $lap['id_lapangan']; ?>">
                                            <?= $lap['nama_lapangan']; ?> - <?= $lap['jenis_lantai']; ?> (Rp <?= number_format($lap['harga_per_jam'], 0, ',', '.'); ?>/jam)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Sewa</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <?= ($role == 'admin') ? 'Simpan Sewa' : 'Pesan Sekarang'; ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Sewa -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">
                            <?= ($role == 'admin') ? 'Semua Daftar Pemesanan' : 'Riwayat Sewa Saya'; ?>
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pemesan</th>
                                        <th>Lapangan</th>
                                        <th>Jadwal</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    if (mysqli_num_rows($data_sewa) > 0):
                                        while ($row = mysqli_fetch_assoc($data_sewa)): 
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($row['nama_pelanggan']); ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($row['no_hp']); ?></small>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($row['nama_lapangan']); ?><br>
                                            <small class="text-muted"><?= htmlspecialchars($row['jenis_lantai']); ?></small>
                                        </td>
                                        <td>
                                            <?= $row['tanggal']; ?><br>
                                            <small><?= substr($row['jam_mulai'], 0, 5); ?> - <?= substr($row['jam_selesai'], 0, 5); ?></small>
                                        </td>
                                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php if ($row['status_bayar'] == 'lunas'): ?>
                                                <span class="badge bg-success">Lunas</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                            <?php endif; ?>
                                            <br>
                                            <span class="badge bg-secondary mt-1"><?= ucfirst($row['status_pemesanan']); ?></span>
                                        </td>
                                        <td>
                                            <?php if ($role == 'admin'): ?>
                                                <?php if ($row['status_bayar'] != 'lunas'): ?>
                                                    <a href="sewa_proses.php?aksi=lunas&id=<?= $row['id_pemesanan']; ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Konfirmasi pelunasan pesanan ini?')">Lunasi</a>
                                                <?php endif; ?>
                                                <?php if ($row['status_pemesanan'] != 'selesai'): ?>
                                                    <a href="sewa_proses.php?aksi=selesai&id=<?= $row['id_pemesanan']; ?>" class="btn btn-info btn-sm text-white mb-1" onclick="return confirm('Tandai pesanan selesai?')">Selesai</a>
                                                <?php endif; ?>
                                                <a href="sewa_proses.php?aksi=hapus&id=<?= $row['id_pemesanan']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Hapus data sewa ini?')">Hapus</a>
                                            <?php else: ?>
                                                <?php if ($row['status_bayar'] == 'belum' && $row['status_pemesanan'] == 'dipesan'): ?>
                                                    <a href="sewa_proses.php?aksi=hapus&id=<?= $row['id_pemesanan']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Batalkan pesanan ini?')">Batalkan</a>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        endwhile;
                                    else: 
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data pemesanan.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
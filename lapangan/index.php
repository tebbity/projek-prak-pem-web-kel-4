<?php
session_start();
include '../koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM lapangan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lapangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
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
                        <a class="nav-link active" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../lapangan/index.php">Data Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../sewa.php">Data Sewa</a>
                    </li>
                    <?php if(isset($_SESSION["status_login"]) && $_SESSION["status_login"] == true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Data Lapangan</h2>
        <?php
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Lapangan</a>
        <?php endif; ?>
        <table class="table table-bordered">
            <thead>
                <tr class="table-light">
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jenis Lantai</th>
                    <th>Harga/Jam</th>
                    <th>Status</th>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM lapangan");
                while($row = mysqli_fetch_array($query)) { ?>
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
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <td>
                            <a href="edit.php?id=<?= $row['id_lapangan'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $row['id_lapangan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php } ?>
            </tbody>            
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
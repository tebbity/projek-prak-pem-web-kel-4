<?php
session_start();
/*if(isset($_SESSION["status_login"]) && $_SESSION["status_login"] == true){
    header("Location: index.php");
    exit();
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lapangan</title>
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
                        <a class="nav-link" href="lapangan.php">Data Lapangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sewa.php">Data Sewa</a>
                    </li>
                    <?php if(isset($_SESSION["status_login"]) && $_SESSION["status_login"] == true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Konten -->
    <div class="container mt-5">
        <?php
        if(isset($_GET["pesan"]) && $_GET["pesan"] == "gagal"){
            echo '<div class="alert alert-danger" role="alert">Akses ditolak! Silakan login terlebih dahulu.</div>';
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Data Lapangan</h2>
            </div>

    <div class="row">
        <!-- Form Tambah Data Lapangan -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Tambah Data Lapangan</h2>
                    <form action="lapangan_process.php" method="POST">
                        <div class="mb-3">
                            <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
                            <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Lapangan -->
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Daftar Lapangan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lapangan</th>
                            <th>Harga Sewa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <!-- Data contoh sementara sebelum disambungkan ke database oleh temanmu -->
                                <tr>
                                    <td>1</td>
                                    <td>Lapangan 1</td>
                                    <td>Rp 50.000</td>
                                    <td>
                                        <a href="edit_lapangan.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus_lapangan.php?id=1" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lapangan 2</td>
                                    <td>Rp 60.000</td>
                                    <td>
                                        <a href="edit_lapangan.php?id=2" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus_lapangan.php?id=2" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Lapangan 3</td>
                                    <td>Rp 45.000</td>
                                    <td>
                                        <a href="edit_lapangan.php?id=3" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus_lapangan.php?id=3" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
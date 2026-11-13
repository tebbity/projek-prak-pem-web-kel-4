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
            <!-- Form Tambah Data Sewa -->
            <div class="col-md-4">
                 <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Tambah Data Sewa</h2>
                        <form action="sewa_process.php" method="POST">
                            <div class="mb-3">
                                <label for="id_lapangan" class="form-label">Lapangan</label>
                                <select class="form-select" id="id_lapangan" name="id_lapangan" required>
                                    <option value="">Pilih Lapangan</option>
                                    <!-- Opsi lapangan akan diisi dari database -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Data Sewa -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Data Sewa</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Sewa</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data sewa akan diisi dari database -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama    = $_POST['nama_lapangan'];
    $lantai  = $_POST['jenis_lantai'];
    $harga   = $_POST['harga_per_jam'];
    $status  = $_POST['status'];

    //Proses upload foto
    $foto = $_FILES['foto']['name'];
    $nama_baru = time() . "_" . $foto;
    move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $nama_baru);

     mysqli_query($koneksi, "INSERT INTO lapangan (nama_lapangan, jenis_lantai, harga_per_jam, status, foto)
                            VALUES ('$nama', '$lantai', '$harga', '$status', '$nama_baru)");

                            header("Location: index.php");
                            exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light text-dark">
    <div class="container mt-5">
        <h2>Tambah Lapangan</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
                <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" required>
            </div>
            <div class="mb-3">
                <label for="jenis_lantai" class="form-label">Jenis Lantai</label>
                <input type="text" class="form-control" id="jenis_lantai" name="jenis_lantai">
            </div>
            <div class="mb-3">
                <label for="harga_per_jam" class="form-label">Harga per Jam</label>
                <input type="text" class="form-control" id="harga_per_jam" name="harga_per_jam" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="aktif">aktif</option>
                    <option value="perbaikan">perbaikan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Lapangan</label>
                <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .jpeg, .png" required>
            </div>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
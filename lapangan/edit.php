<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php");
    exit();
}
include '../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM lapangan WHERE id_lapangan = '$id'");
$row = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama_lapangan'];
    $lantai = $_POST['jenis_lantai'];
    $harga  = $_POST['harga_per_jam'];
    $status = $_POST['status'];

    if (!empty($_FILES['foto']['name'])) {
        $foto      = $_FILES['foto']['name'];
        $nama_baru = time() . "_" . $foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $nama_baru);

        if (!empty($row['foto']) && file_exists("../uploads/" . $row['foto'])) {
            unlink("../uploads/" . $row['foto']);
        }

        mysqli_query($koneksi, "UPDATE lapangan SET
            nama_lapangan = '$nama',
            jenis_lantai  = '$lantai',
            harga_per_jam = '$harga',
            status        = '$status',
            foto          = '$nama_baru'
            WHERE id_lapangan = '$id'");
    } else {
        mysqli_query($koneksi, "UPDATE lapangan SET
            nama_lapangan = '$nama',
            jenis_lantai  = '$lantai',
            harga_per_jam = '$harga',
            status        = '$status'
            WHERE id_lapangan = '$id'");
    }

    header("Location: index.php");
    exit;    
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lapangan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light text-dark">
    <div class="container mt-5">
    <h2>Edit Lapangan</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
            <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" value="<?= $row['nama_lapangan'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="jenis_lantai" class="form-label">Jenis Lantai</label>
            <input type="text" class="form-control" id="jenis_lantai" name="jenis_lantai" value="<?= $row['jenis_lantai'] ?>">
        </div>
        <div class="mb-3">
            <label for="harga_per_jam" class="form-label">Harga per Jam</label>
            <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" value="<?= $row['harga_per_jam'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : '' ?>>aktif</option>
                <option value="perbaikan" <?= $row['status'] == 'perbaikan' ? 'selected' : '' ?>>perbaikan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Lapangan (Kosongkan jika tidak ingin diganti)</label><br>
            <?php if (!empty($row['foto'])): ?>
                <img src="../uploads/<?= $row['foto'] ?>" width="100" class="mb-2 rounded"><br>
            <?php endif; ?>
            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png">
        </div>
        
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="../script.js"></script>
</body>
</html>
<?php
session_start();
include 'koneksi.php';

$pesan = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    $cek = mysqli_num_rows($data);

    if ($cek > 0) {
        $row = mysqli_fetch_array($data);
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];
        header("Location: lapangan/index.php");
        exit;
    } else {
        $pesan = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <p style="color:red;"><?= $pesan ?></p>
    <form method="POST">
        Username:<br>
        <input type="text" name="username" required><br><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
if(isset($_SESSION["status_login"]) && $_SESSION["status_login"] == true){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penyewaan Lapangan Badminton</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light text-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <?php
                        if(isset($_GET["pesan"]) && $_GET["pesan"] == "gagal"){
                            echo '<div class="alert alert-danger" role="alert">Login gagal! Username atau password salah.</div>';
                        }
                        ?>
                        <form action="login_proses.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php" class="text-decoration-none">Belum punya akun?</a>
                            <br>
                            <a href="index.php" class="text-decoration-none">Kembali ke Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
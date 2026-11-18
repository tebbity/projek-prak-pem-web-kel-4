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
</body>
</html>
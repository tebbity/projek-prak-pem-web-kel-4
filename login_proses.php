<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password']));

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            $_SESSION["status_login"] = true;
            $_SESSION["id_user"] = $user['id_user'];
            $_SESSION["nama"] = $user['nama'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["role"] = $user['role'];
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Password salah.');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan.');</script>";
    }
}
?>
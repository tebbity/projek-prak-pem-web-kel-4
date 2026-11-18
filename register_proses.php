<?php
include 'koneksi.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $query = "INSERT INTO users (username, password, nama, role) VALUES ('$username', '$hashed_password', '$nama', 'pelanggan')";
    
    if(mysqli_query($koneksi, $query)) {
        echo "<script>alert('User registered successfully.');</script>";
        header("Location: login.php");
        exit;
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
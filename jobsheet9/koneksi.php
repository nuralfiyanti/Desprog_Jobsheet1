<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "prakwebdb";

// buat koneksi
$connect = mysqli_connect($host, $username, $password, $database);

// cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

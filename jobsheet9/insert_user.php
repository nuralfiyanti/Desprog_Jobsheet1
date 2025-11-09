<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "prakwebdb";

//koneksi ke database
$connect = mysqli_connect($host, $username, $password, $database);

// cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Data yang dimasukkan
$user = "admin";
$pass = md5("admin"); 

// memasukkan data ke tabel user
$query = "INSERT INTO user (username, password) VALUES ('$user', '$pass')";

// jalankan query
if (mysqli_query($connect, $query)) {
    echo "Data user berhasil dimasukkan!";
} else {
    echo "Error: " . mysqli_error($connect);
}

mysqli_close($connect);
?>

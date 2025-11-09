<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "prakwebdb";

// koneksi
$connect = mysqli_connect($host, $username, $password, $database);

//cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// buat tabel user
$query = "CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
)";

// jalankan query tabel
if (mysqli_query($connect, $query)) {
    echo "Tabel user berhasil dibuat!";
} else {
    echo "Error saat membuat tabel: " . mysqli_error($connect);
}

mysqli_close($connect);
?>

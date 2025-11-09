<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$database = "prakwebdb";

$connect = mysqli_connect($host, $db_user, $db_pass, $database);
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

//autoincrement 
$username_user = 'admin';
$password_user = md5('123'); 

$query = "INSERT INTO user (username, password) VALUES ('$username_user', '$password_user')";

if (mysqli_query($connect, $query)) {
    echo "Data user berhasil dimasukkan!";
} else {
    echo "Error saat insert: " . mysqli_error($connect);
}

mysqli_close($connect);
?>

<?php
// koneksi.php - koneksi ke PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "crud_film";
$user = "postgres";
$password = "12345678";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("Koneksi ke database gagal: " . pg_last_error());
}
?>

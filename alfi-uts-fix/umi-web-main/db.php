<?php
$host = "localhost";
$port = "5432";
$dbname = "moviedb";
$user = "postgres";
$password = "12345678"; // Pastikan ini kata sandi Anda

try {
    // Membuat Data Source Name (DSN) untuk PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    // Membuat instance PDO
    $pdo = new PDO($dsn, $user, $password);
    
    // Mengatur mode error untuk menampilkan exception jika terjadi kesalahan SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    // Menggunakan json_encode konsisten dengan file api.php Anda
    die(json_encode(["ok" => false, "message" => "Koneksi database gagal: " . $e->getMessage()]));
}
?>
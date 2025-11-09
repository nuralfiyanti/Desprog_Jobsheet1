<?php
$host = "localhost";
$port = "5432";
$dbname = "moviedb";
$user = "postgres";
$password = "12345678"; 

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["ok" => false, "message" => "Koneksi database gagal: " . $e->getMessage()]));
}
?>

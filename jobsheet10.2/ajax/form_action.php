<?php
session_start();
include 'koneksi.php';
include 'csrf.php';

header('Content-Type: application/json');

// Mengambil dan membersihkan data input
$id = trim(stripslashes(strip_tags(htmlspecialchars($_POST['id'] ?? '', ENT_QUOTES))));
$nama = trim(stripslashes(strip_tags(htmlspecialchars($_POST['nama'] ?? '', ENT_QUOTES))));
$jenis_kelamin = trim(stripslashes(strip_tags(htmlspecialchars($_POST['jenis_kelamin'] ?? '', ENT_QUOTES))));
$alamat = trim(stripslashes(strip_tags(htmlspecialchars($_POST['alamat'] ?? '', ENT_QUOTES))));
$no_telp = trim(stripslashes(strip_tags(htmlspecialchars($_POST['no_telp'] ?? '', ENT_QUOTES))));


if (empty($nama) || empty($jenis_kelamin) || empty($alamat) || empty($no_telp)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
    exit();
}

if (empty($id)) {
    // --- CREATE (INSERT)
    $query = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp) VALUES (?, ?, ?, ?)";
    $sql = $db1->prepare($query);
    if ($sql === false) {
        
        http_response_code(500);
        exit(json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement INSERT: ' . $db1->error]));
    }
    // Bind parameter: ssss = 4 string
    $sql->bind_param("ssss", $nama, $jenis_kelamin, $alamat, $no_telp);
} else {
    // --- UPDATE ---
    $query = "UPDATE anggota SET nama=?, jenis_kelamin=?, alamat=?, no_telp=? WHERE id=?";
    $sql = $db1->prepare($query);
    if ($sql === false) {
        
        http_response_code(500);
        exit(json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan statement UPDATE: ' . $db1->error]));
    }
    $sql->bind_param("ssssi", $nama, $jenis_kelamin, $alamat, $no_telp, $id);
}

$execute_result = $sql->execute();

if ($execute_result) {
    echo json_encode(['status' => 'success', 'message' => 'Data berhasil diproses.']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Gagal memproses data: ' . $sql->error]);
}

$sql->close();
$db1->close();
?>
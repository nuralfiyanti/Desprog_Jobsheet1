<?php
include 'koneksi.php';
header('Content-Type: application/json');

$id = $_POST['id'] ?? '';
$nama = $_POST['nama'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$no_telp = $_POST['no_telp'] ?? '';

if ($nama == "" || $jenis_kelamin == "" || $alamat == "" || $no_telp == "") {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
    exit;
}

if ($id == "") {
    $sql = $db1->prepare("INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $nama, $jenis_kelamin, $alamat, $no_telp);
} else {
    $sql = $db1->prepare("UPDATE anggota SET nama=?, jenis_kelamin=?, alamat=?, no_telp=? WHERE id=?");
    $sql->bind_param("ssssi", $nama, $jenis_kelamin, $alamat, $no_telp, $id);
}

if ($sql->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $sql->error]);
}

$sql->close();
$db1->close();

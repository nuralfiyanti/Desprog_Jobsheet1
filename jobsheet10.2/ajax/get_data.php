<?php
include 'koneksi.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'ID tidak ditemukan.']));
}

$id = $_POST['id'];

$query = "SELECT id, nama, jenis_kelamin, alamat, no_telp FROM anggota WHERE id=?";
$sql = $db1->prepare($query);

$sql->bind_param('i', $id);
$sql->execute();
$res = $sql->get_result();
$data = [];

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $data = $row;
}

$sql->close();
$db1->close();

echo json_encode($data);

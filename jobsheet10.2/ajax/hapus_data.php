<?php
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
    exit;
}

$id = $_POST['id'];

$query = "DELETE FROM anggota WHERE id=?";
$sql = $db1->prepare($query);
$sql->bind_param('i', $id);

if ($sql->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $sql->error]);
}

$sql->close();
$db1->close();
?>

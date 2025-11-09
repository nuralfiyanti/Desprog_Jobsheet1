<?php
include 'koneksi.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $id = (int)$id;
    $res = pg_query_params($conn, 'DELETE FROM film WHERE id=$1', array($id));
}
header('Location: index.php');
exit;
?>

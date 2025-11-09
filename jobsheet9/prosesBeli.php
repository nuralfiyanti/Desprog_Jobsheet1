<?php
if (isset($_POST["beliNovel"]) && isset($_POST["beliBuku"])) {
    // Menyimpan data pembelian ke cookie
    setcookie("beliNovel", $_POST["beliNovel"]);
    setcookie("beliBuku", $_POST["beliBuku"]);

    // Arahkan ke halaman keranjang belanja
    header("Location: keranjangBelanja.php");
    exit;
}
?>

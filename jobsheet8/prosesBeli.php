<?php
if (isset($_POST["beliNovel"]) && isset($_POST["beliBuku"])) {
    // Simpan nilai ke cookie selama 1 jam
    setcookie("beliNovel", $_POST["beliNovel"], time() + 3600);
    setcookie("beliBuku", $_POST["beliBuku"], time() + 3600);

    // Arahkan ke halaman keranjang belanja
    header("Location: keranjangBelanja.php");
    }
?>

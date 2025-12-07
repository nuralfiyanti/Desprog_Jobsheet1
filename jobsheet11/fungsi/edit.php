<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!empty($_SESSION['username'])) {

    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    require '../fungsi/anti_injection.php';

    if (!empty($_GET['jabatan']) && $_GET['jabatan'] == 'edit') {

        $id         = antiinjection($koneksi, $_POST['id']);
        $jabatan    = antiinjection($koneksi, $_POST['jabatan']);
        $keterangan = antiinjection($koneksi, $_POST['keterangan']);

        $query = "UPDATE jabatan 
                  SET nama_jabatan='$jabatan', keterangan='$keterangan' 
                  WHERE id='$id'";

        if (mysqli_query($koneksi, $query)) {
            pesan('success', "Jabatan berhasil diubah.");
        } else {
            pesan('danger', "Gagal mengubah jabatan karena: " . mysqli_error($koneksi));
        }

        header("Location: ../index.php?page=jabatan");
        exit;
    }
}
?>

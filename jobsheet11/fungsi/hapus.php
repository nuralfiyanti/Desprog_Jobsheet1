<?php
session_start();

if (!empty($_SESSION['username'])) {

    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    require '../fungsi/anti_injection.php';

// Hapus Data Jabatan
    if (!empty($_GET['jabatan'])) {

        $id = antiinjection($koneksi, $_GET['id']);

        $query = "DELETE FROM jabatan WHERE id = '$id'";

        if (mysqli_query($koneksi, $query)) {
            pesan('success', "Jabatan telah terhapus.");
        } else {
            pesan('danger', "Jabatan tidak terhapus karena: " . mysqli_error($koneksi));
        }

        header("Location: ../index.php?page=jabatan");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}

// Hapus Data Anggota
if (!empty($_GET['anggota'])) {

    $id = antiinjection($koneksi, $_GET['id']);

    $query = "DELETE FROM user WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {

        $query2 = "DELETE FROM anggota WHERE user_id = '$id'";

        if (mysqli_query($koneksi, $query2)) {
            pesan('success', "Anggota telah terhapus.");
        } else {
            pesan(
                'warning',
                "Data login terhapus, tetapi data anggota tidak terhapus karena: " . mysqli_error($koneksi)
            );
        }

    } else {
        pesan(
            'danger',
            "Data anggota tidak terhapus karena: " . mysqli_error($koneksi)
        );
    }
}

header("Location: ../index.php?page=anggota");
exit;
?>

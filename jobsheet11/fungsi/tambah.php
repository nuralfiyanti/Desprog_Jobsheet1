<?php
session_start();

if (!empty($_SESSION['username'])) {

    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    require '../fungsi/anti_injection.php';

    if (!empty($_POST['jabatan'])) {

        $jabatan    = antiinjection($koneksi, $_POST['jabatan']); 
        $keterangan = antiinjection($koneksi, $_POST['keterangan']);

        // PERBAIKAN UTAMA → kolom harus sesuai database
        $query  = "INSERT INTO jabatan (nama_jabatan, keterangan) 
                   VALUES ('$jabatan', '$keterangan')";
        $hasil  = mysqli_query($koneksi, $query);

        if ($hasil) {
            pesan('success', "Jabatan berhasil ditambahkan");
        } else {
            pesan('danger', "Gagal menambahkan jabatan: " . mysqli_error($koneksi));
        }

        header("Location: ../index.php?page=jabatan");
        exit;

    } else {
        pesan('danger', "Form tidak berisi data");
        header("Location: ../index.php?page=jabatan");
        exit;
    }

} else {
    header("Location: ../login.php");
    exit;
}
?>

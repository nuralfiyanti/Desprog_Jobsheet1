<?php
session_start();

require '../config/koneksi.php';
require '../fungsi/pesan_kilat.php';
require '../fungsi/anti_injection.php';

// TAMBAH JABATAN
if (isset($_GET['jabatan']) && $_GET['jabatan'] == 'tambah') {

    if (!empty($_POST['jabatan'])) {

        $jabatan    = antiinjection($koneksi, $_POST['jabatan']); 
        $keterangan = antiinjection($koneksi, $_POST['keterangan']);

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
}

// TAMBAH ANGGOTA

elseif (isset($_GET['anggota']) && $_GET['anggota'] == 'tambah') {

    $username      = antiinjection($koneksi, $_POST['username']);
    $password      = antiinjection($koneksi, $_POST['password']);
    $level         = antiinjection($koneksi, $_POST['level']);
    $jabatan       = antiinjection($koneksi, $_POST['jabatan']);
    $nama          = antiinjection($koneksi, $_POST['nama']);
    $jenis_kelamin = antiinjection($koneksi, $_POST['jenis_kelamin']);
    $alamat        = antiinjection($koneksi, $_POST['alamat']);
    $no_telp       = antiinjection($koneksi, $_POST['no_telp']);

    $salt = bin2hex(random_bytes(16));
    $combined_password = $salt . $password;
    $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

    $query1 = "INSERT INTO user (username, password, salt, level) 
               VALUES ('$username', '$hashed_password', '$salt', '$level')";

    if (mysqli_query($koneksi, $query1)) {

        $last_id = mysqli_insert_id($koneksi);

        $query2 = "INSERT INTO anggota 
                  (nama, jenis_kelamin, alamat, no_telp, user_id, jabatan_id)
                  VALUES 
                  ('$nama', '$jenis_kelamin', '$alamat', '$no_telp', '$last_id', '$jabatan')";

        if (mysqli_query($koneksi, $query2)) {
            pesan('success', "Anggota baru berhasil ditambahkan.");
        } else {
            pesan('warning', "Gagal menambahkan anggota, tetapi data login tersimpan. Error: " . mysqli_error($koneksi));
        }

    } else {
        pesan('danger', "Gagal menambahkan data login user: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?page=anggota");
    exit;
}

else {
    pesan('danger', 'Akses tidak valid');
    header("Location: ../index.php");
    exit;
}
?>

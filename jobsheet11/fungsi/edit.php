<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//jabatan
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

    //anggota
    elseif (!empty($_GET['anggota'])) {

    $user_id       = antiinjection($koneksi, $_POST['id']);
    $nama          = antiinjection($koneksi, $_POST['nama']);
    $jabatan       = antiinjection($koneksi, $_POST['jabatan']);
    $jenis_kelamin = antiinjection($koneksi, $_POST['jenis_kelamin']);
    $alamat        = antiinjection($koneksi, $_POST['alamat']);
    $no_telp       = antiinjection($koneksi, $_POST['no_telp']);
    $username      = antiinjection($koneksi, $_POST['username']);

    $query_anggota = "UPDATE anggota SET
                        nama = '$nama',
                        jenis_kelamin = '$jenis_kelamin',
                        alamat = '$alamat',
                        no_telp = '$no_telp',
                        jabatan_id = '$jabatan'
                      WHERE user_id = '$user_id'";

    if (mysqli_query($koneksi, $query_anggota)) {

        if (!empty($_POST['password'])) {

            $password = $_POST['password'];
            $salt = bin2hex(random_bytes(16));
            $combined_password = $salt . $password;
            $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

            $query_user = "UPDATE user SET 
                            username = '$username',
                            password = '$hashed_password',
                            salt = '$salt'
                           WHERE id = '$user_id'";

            if (mysqli_query($koneksi, $query_user)) {
                pesan('success', "Anggota Telah Diubah.");
            } else {
                pesan('warning', "Data anggota berhasil diubah, tetapi password gagal diubah: " . mysqli_error($koneksi));
            }

        } else {

            $query_user = "UPDATE user SET username = '$username' WHERE id = '$user_id'";

            if (mysqli_query($koneksi, $query_user)) {
                pesan('success', "Anggota Telah Diubah.");
            } else {
                pesan('warning', "Data anggota berhasil diubah, tetapi username gagal diubah: " . mysqli_error($koneksi));
            }
        }

    } else {
        pesan('danger', "Gagal mengubah anggota: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?page=anggota");
    exit;
}

}
?>

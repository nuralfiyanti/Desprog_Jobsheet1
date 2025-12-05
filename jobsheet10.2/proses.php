<?php
include('koneksi.php');

if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {

    // Ambil data dari form
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Query insert
    $query = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp)
              VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telp')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>

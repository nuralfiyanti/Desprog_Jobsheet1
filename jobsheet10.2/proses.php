<?php
include('koneksi.php');

/* ----------------------- TAMBAH DATA ----------------------- */
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


/* ----------------------- UBAH DATA ----------------------- */
elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'ubah') {

    if (isset($_POST['id'])) {

        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        $query = "UPDATE anggota 
                  SET nama='$nama', 
                      jenis_kelamin='$jenis_kelamin', 
                      alamat='$alamat', 
                      no_telp='$no_telp'
                  WHERE id=$id";

        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($koneksi);
        }

    } else {
        echo "ID tidak valid.";
    }

    mysqli_close($koneksi);
}


/* ----------------------- HAPUS DATA ----------------------- */
elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $query = "DELETE FROM anggota WHERE id = $id";

        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Gagal menghapus data: " . mysqli_error($koneksi);
        }

    } else {
        echo "ID tidak valid.";
    }

    mysqli_close($koneksi);
}


/* -------------- JIKA AKSI TIDAK DIKENALI -------------- */
else {
    header("Location: index.php");
    exit();
}

?>

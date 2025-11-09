<?php
include "koneksi.php"; 

$username = $_POST['username'];
$password = md5($_POST['password']); 

// Cek data login di tabel user
$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($connect, $query);

// Hitung jumlah baris 
$cek = mysqli_num_rows($result);

if ($cek > 0) {
    echo "Anda berhasil login. Silakan menuju ";
    echo '<a href="homeAdmin.html">Halaman HOME</a>';
} else {
    echo "Anda gagal login. Silakan ";
    echo '<a href="loginForm.html">Login kembali</a><br>';
    echo mysqli_error($connect);
}
?>

<?php
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']); 

$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    if ($row['level'] == 1) {
        echo "Anda berhasil login sebagai Admin. Silakan menuju ";
        echo '<a href="homeAdmin.html">Halaman HOME</a>';
    } else if ($row['level'] == 2) {
        echo "Anda berhasil login sebagai Guest. Silakan menuju ";
        echo '<a href="homeGuest.html">Halaman HOME</a>';
    }
} else {
    echo "Anda gagal login. Silakan ";
    echo '<a href="loginForm.html">Login kembali</a><br>';
    echo mysqli_error($connect);
}
?>

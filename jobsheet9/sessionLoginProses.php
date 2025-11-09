<?php
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = mysqli_query($connect, $sql);
$cek = mysqli_num_rows($result);

if ($cek > 0) {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['status'] = 'login';
    echo "Anda berhasil login, silakan menuju ";
    echo '<a href="homeSession.php">Halaman Home</a>';
} else {
    echo "Gagal login, silakan login lagi ";
    echo '<a href="sessionLoginForm.html">Halaman Login</a><br>';
    echo mysqli_error($connect);
}
?>

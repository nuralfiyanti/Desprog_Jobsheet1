<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include "config/koneksi.php";
include "fungsi/pesan_kilat.php";
include "fungsi/anti_injection.php";

$username = antiinjection($koneksi, $_POST['username']);
$password = antiinjection($koneksi, $_POST['password']);

$query = "SELECT username, level, salt, password AS hashed_password 
          FROM user 
          WHERE username = '$username'";

$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
mysqli_close($koneksi);

if ($row) {

    $salt = $row['salt'];
    $hashed_password = $row['hashed_password'];

    $combined_password = $salt . $password;

    if (password_verify($combined_password, $hashed_password)) {

        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];

        header("Location: index.php");
        exit;

    } else {

        pesan('danger', "Login gagal. Password Anda salah.");
        header("Location: login.php");
        exit;
    }

} else {

    pesan('warning', "Username tidak ditemukan.");
    header("Location: login.php");
    exit;
}
?>

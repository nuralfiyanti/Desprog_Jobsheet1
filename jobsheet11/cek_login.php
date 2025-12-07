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

if ($row) {

    $salt = $row['salt'];
    $hashed_password = $row['hashed_password'];

    // gabungkan salt + password input user
    $combined_password = $salt . $password;

    // verifikasi hash
    if (password_verify($combined_password, $hashed_password)) {

        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];

        header("Location: index.php");
        exit;
    } else {

        pesan('danger', "Password salah.");
        header("Location: login.php");
        exit;
    }

} else {

    pesan('warning', "Username tidak ditemukan.");
    header("Location: login.php");
    exit;
}
?>

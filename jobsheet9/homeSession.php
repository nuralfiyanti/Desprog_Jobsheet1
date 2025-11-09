<!DOCTYPE html>
<html>
<head>
    <title>Home Session</title>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['status']) && $_SESSION['status'] == 'login') {
    echo "Selamat datang, " . $_SESSION['username'] . "!<br>";
    echo '<a href="sessionLogout.php">Log Out</a>';
} else {
    echo "Anda belum login. Silakan ";
    echo '<a href="sessionLoginForm.html">Log In</a>';
}
?>
</body>
</html>

<?php
// cek form sudah disubmit
if (isset($_POST['submit'])) {
    $input = $_POST['input'];
    
    // cek input dengan htmlspecialchars
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    echo "Input yang aman: " . $input . "<br>";

    // cek apakah input email ada
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        // validasi email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Email valid: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        } else {
            echo "Email tidak valid!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contoh HTML Aman dengan Validasi Email</title>
</head>
<body>
    <h2>Masukkan sesuatu dan email Anda:</h2>
    <form method="post" action="">
        <input type="text" name="input" placeholder="Ketik sesuatu" required><br><br>
        <input type="email" name="email" placeholder="Masukkan email" required><br><br>
        <input type="submit" name="submit" value="Kirim">
    </form>
</body>
</html>

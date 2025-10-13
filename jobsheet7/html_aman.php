<?php
// cek form sudah disubmit
if (isset($_POST['submit'])) {
    $input = $_POST['input'];

    // cek input dengan htmlspecialchars
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    echo "Input yang aman: " . $input;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contoh HTML Aman</title>
</head>
<body>
    <h2>Masukkan sesuatu:</h2>
    <form method="post" action="">
        <input type="text" name="input" placeholder="Ketik sesuatu" required>
        <input type="submit" name="submit" value="Kirim">
    </form>
</body>
</html>



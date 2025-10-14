<!DOCTYPE html>
<html>
<head>
    <title>HTML Injection + Validasi Email</title>
</head>
<body>
    <h2>Form Input dan Validasi Email</h2>

    <?php
    $input = '';
    $email = '';
    $msg = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // ambil dan trim input untuk menghapus spasi berlebih
        $input = isset($_POST['input']) ? trim($_POST['input']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        // sanitasi input teks agar aman dari HTML injection
        $safe_input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

        // email
        if ($email === '') {
            $msg .= "<p style='color:orange'>Email belum diisi.</p>";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
            $safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $msg .= "<p style='color:green'>Email valid: <strong>{$safe_email}</strong></p>";
            $msg .= "<p>Input aman: {$safe_input}</p>";
         
        } else {
            // email tidak valid
            $msg .= "<p style='color:red'>Format email tidak valid. Contoh yang benar: nama@domain.com</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="input">Input Teks:</label><br>
        <input type="text" name="input" id="input" value="<?php echo htmlspecialchars($input); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <hr>
    <!-- tampilkan pesan hasil validasi / sanitasi -->
    <?php if (!empty($msg)) echo $msg; ?>
</body>
</html>

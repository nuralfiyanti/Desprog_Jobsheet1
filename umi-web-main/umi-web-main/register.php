<?php
session_start();
require_once "db.php";

$error_message = '';
$success_message = '';

// Jika sudah login, lempar ke halaman index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Validasi Sederhana
    if (empty($fullname) || empty($email) || empty($password)) {
        $error_message = "Please fill out all fields.";
    } elseif ($password !== $confirm) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        try {
            // Cek apakah email sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error_message = "Email already registered.";
            } else {
                // Buat user baru (cocokkan metode server.js)
                // 1. Buat salt (16 bytes, diubah ke hex string 32 karakter)
                $salt = bin2hex(random_bytes(16));
                
                // 2. Buat hash (pbkdf2, sha256, 310000 iterasi, 32 bytes raw output)
                $password_hash_raw = hash_pbkdf2('sha256', $password, $salt, 310000, 32, true);
                
                // 3. Ubah hash raw ke hex (64 karakter) untuk disimpan
                $password_hash_hex = bin2hex($password_hash_raw);

                // 4. Simpan ke database
                $stmt_insert = $pdo->prepare("INSERT INTO users (fullname, email, password_hash, salt) VALUES (?, ?, ?, ?)");
                $stmt_insert->execute([$fullname, $email, $password_hash_hex, $salt]);

                // Redirect ke login dengan pesan sukses
                // Kita bisa gunakan sesi singkat (flash message)
                $_SESSION['register_success'] = 'Account created — you can now log in';
                header("Location: login.php");
                exit;
            }

        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}

// Cek jika ada pesan sukses dari registrasi
if (isset($_SESSION['register_success'])) {
    $success_message = $_SESSION['register_success'];
    unset($_SESSION['register_success']); // Hapus pesan setelah ditampilkan
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Movie Ticketing</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="booking.php">Book Tickets</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="login">
            <div class="container login-wrapper">
                <div class="login-copy">
                    <h2>Hi! Welcome</h2>
                    <p>Sign up to manage your reservations, view upcoming showtimes, and keep track of your favourite movies.</p>
                </div>
                
                <?php // --- PERUBAHAN FORM --- ?>
                <form id="register-form" class="login-form" method="POST" action="register.php" novalidate>
                    <label for="fullname">Full name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Your full name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>

                    <div class="label-row">
                        <label for="password">Password</label>
                        <small class="muted">min 6 characters</small>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Choose a password" required minlength="6">

                    <label for="confirm">Confirm password</label>
                    <input type="password" id="confirm" name="confirm" placeholder="Re-enter your password" required minlength="6">

                    <?php if (!empty($error_message)): ?>
                    <div id="form-error" role="alert" style="color:#b91c1c;font-weight:600">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($success_message)): ?>
                    <div role="alert" style="color:green;font-weight:600">
                        <?= htmlspecialchars($success_message) ?>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn">Create account</button>
                    <p class="form-footer">Already have an account? <a href="login.php" class="link">Log in</a></p>
                </form>
                <?php // --- AKHIR PERUBAHAN (Script JS dihapus) --- ?>
            </div>
        </section>
    </main>
</body>
</html>
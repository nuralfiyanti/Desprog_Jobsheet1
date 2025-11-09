<?php
session_start();
require_once "db.php";

$error_message = '';

// Jika sudah login, lempar ke halaman index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika user ditemukan
        if ($user) {
            // Verifikasi password (mencocokkan metode hash dari server.js)
            // Node.js: crypto.pbkdf2Sync(password, salt, 310000, 32, 'sha256').toString('hex')
            // PHP: hash_pbkdf2('sha256', $password, $salt, 310000, 32, true) -> lalu ubah ke hex
            
            $salt = $user['salt'];
            $password_hash_db = $user['password_hash'];
            
            $computed_hash_raw = hash_pbkdf2('sha256', $password, $salt, 310000, 32, true);
            $computed_hash_hex = bin2hex($computed_hash_raw);

            // Gunakan hash_equals untuk perbandingan yang aman
            if (hash_equals($password_hash_db, $computed_hash_hex)) {
                // Password cocok! Buat sesi
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect ke halaman utama
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Invalid credentials";
            }
        } else {
            $error_message = "Invalid credentials";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <li><a href="login.php" aria-current="page">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="login">
            <div class="container login-wrapper">
                <div class="login-copy">
                    <h2>Welcome back</h2>
                    <p>Sign in to manage your reservations, view upcoming showtimes, and keep track of your favourite movies.</p>
                </div>
                
                <?php // --- PERUBAHAN FORM --- ?>
                <form id="login-form" class="login-form" method="POST" action="login.php">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>

                    <div class="label-row">
                        <label for="password">Password</label>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>

                    <?php if (!empty($error_message)): ?>
                    <div id="login-error" role="alert" style="color:#b91c1c;font-weight:600">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn">Log in</button>
                    <p class="form-footer">New here? <a href="register.php" class="link">Create an account</a></p>
                </form>
                <?php // --- AKHIR PERUBAHAN (Script JS dihapus) --- ?>
                
            </div>
        </section>
    </main>
</body>
</html>
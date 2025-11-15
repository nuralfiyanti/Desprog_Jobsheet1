<?php
session_start();
require_once "db.php";

$error_message = '';

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Ambil user berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $password_hash_db = $user['password_hash'];

            // Hash input password sama seperti saat INSERT (password + email)
            $computed_hash_hex = hash('sha256', $password . $user['email']);

            // Bandingkan hasil hash dengan yang ada di database
            if (hash_equals($password_hash_db, $computed_hash_hex)) {
                // Simpan data user di session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Arahkan sesuai role
                if ($user['role'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $error_message = "Email atau password salah.";
            }
        } else {
            $error_message = "Email atau password salah.";
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
    <title>Login | Movie Ticketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🎬 Movie Ticketing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="booking.php">Book Tickets</a></li>
        <li class="nav-item"><a class="nav-link active text-warning fw-semibold" href="login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main -->
<main class="container" style="margin-top: 100px;">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
          <div class="text-center mb-4">
            <h2 class="fw-bold">Welcome Back</h2>
            <p class="text-muted mb-0">Sign in to continue your journey.</p>
          </div>

          <form method="POST" action="login.php">
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password</label>
              <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger text-center fw-semibold" role="alert">
                <?= htmlspecialchars($error_message) ?>
              </div>
            <?php endif; ?>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-warning btn-lg fw-semibold text-dark">Log In</button>
            </div>

            <p class="text-center mt-3 mb-0 text-muted">
              New here? <a href="register.php" class="fw-semibold text-decoration-none text-dark">Create an account</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

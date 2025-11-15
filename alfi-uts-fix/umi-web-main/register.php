<?php
session_start();
require_once "db.php";

$error_message = '';
$success_message = '';

// Jika user sudah login, arahkan ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Cek apakah email sudah digunakan
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error_message = "Email is already registered.";
        } else {
            // Hash password dengan cara yang sama seperti di login.php
            $password_hash = bin2hex(hash('sha256', $password . $email, true));

            // Simpan ke database (default role = 'user')
            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password_hash, role) VALUES (?, ?, ?, 'user')");
            $stmt->execute([$fullname, $email, $password_hash]);

            $success_message = "Registration successful! You can now log in.";
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
    <title>Register | Movie Ticketing</title>
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
        <li class="nav-item"><a class="nav-link active text-warning fw-semibold" href="register.php">Register</a></li>
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
            <h2 class="fw-bold">Create an Account</h2>
            <p class="text-muted mb-0">Join us and start booking your favorite movies easily!</p>
          </div>

          <form id="register-form" method="POST" action="register.php">
            <div class="mb-3">
              <label for="fullname" class="form-label fw-semibold">Full Name</label>
              <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Your full name" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password</label>
              <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter a strong password" required>
            </div>

            <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger text-center fw-semibold" role="alert">
                <?= htmlspecialchars($error_message) ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
              <div class="alert alert-success text-center fw-semibold" role="alert">
                <?= htmlspecialchars($success_message) ?>
              </div>
            <?php endif; ?>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-warning btn-lg fw-semibold text-dark">Register</button>
            </div>

            <p class="text-center mt-3 mb-0 text-muted">
              Already have an account? <a href="login.php" class="fw-semibold text-decoration-none text-dark">Log in</a>
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

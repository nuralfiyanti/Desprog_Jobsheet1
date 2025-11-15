<?php
// 1. Mulai sesi dan cek login
session_start();
require_once "db.php";

// Cek jika user belum login, lempar ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// cek role admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Ambil data user dari sesi
$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['fullname'];

// 2. Ambil data pengguna dari database
try {
    $stmt = $pdo->query("SELECT id, fullname, email FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Tidak dapat mengambil data pengguna: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>👥 Admin - User List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🎬 Movie Ticketing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a href="booking.php" class="nav-link text-white">Bookings</a></li>
        <li class="nav-item"><a href="movies.php" class="nav-link text-white">Movies</a></li>
        <li class="nav-item"><a href="users.php" class="nav-link active text-warning fw-bold">Users</a></li>
        <li class="nav-item"><a href="admin.php" class="nav-link text-white">All Bookings</a></li>
        <li class="nav-item ms-3">
          <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
          <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container" style="margin-top: 100px;">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">👥 User List</h2>
        <span class="badge bg-dark text-warning fs-6"><?= count($users) ?> users</span>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($users) > 0): ?>
              <?php foreach ($users as $u): ?>
              <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['fullname']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" class="text-center text-muted py-4">No users found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!--Footer-->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

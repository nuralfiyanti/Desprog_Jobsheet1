<?php
// 1. Mulai sesi dan cek login
session_start();
require_once "db.php";

// Cek jika user belum login, lempar ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari sesi
$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['fullname'];

// 2. Ambil data booking dari database
try {
    $stmt = $pdo->query("
        SELECT b.id, u.fullname, m.title, b.seats, b.booked_at
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN movies m ON b.movie_id = m.id
        ORDER BY b.booked_at DESC
    ");
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Tidak dapat mengambil data booking: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - All Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Tambahan kecil untuk hover tombol logout */
    .btn-outline-warning:hover {
      background-color: #ffcc00;
      color: #000;
    }
  </style>
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
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a href="booking.php" class="nav-link text-white">Bookings</a></li>
        <li class="nav-item"><a href="movies.php" class="nav-link text-white">Movies</a></li>
        <li class="nav-item"><a href="users.php" class="nav-link text-white">Users</a></li>
        <li class="nav-item"><a href="admin.php" class="nav-link active text-warning fw-semibold">All Bookings</a></li>
        <li class="nav-item ms-3 d-flex align-items-center">
          <span class="text-white me-2 small">Hi, <?= htmlspecialchars($user_fullname) ?></span>
          <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container py-5 mt-5">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0 fw-semibold">🎟️ Daftar Semua Booking</h4>
    </div>
    <div class="card-body bg-light">
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle mb-0">
          <thead class="table-dark text-center">
            <tr>
              <th>ID</th>
              <th>Nama Pengguna</th>
              <th>Film</th>
              <th>Jumlah Tiket</th>
              <th>Waktu Booking</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($bookings) > 0): ?>
              <?php foreach ($bookings as $r): ?>
                <tr>
                  <td class="text-center"><?= htmlspecialchars($r['id']) ?></td>
                  <td><?= htmlspecialchars($r['fullname']) ?></td>
                  <td><?= htmlspecialchars($r['title']) ?></td>
                  <td class="text-center"><?= htmlspecialchars($r['seats']) ?></td>
                  <td><?= htmlspecialchars(date("d M Y, H:i:s", strtotime($r['booked_at']))) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-3">Tidak ada booking ditemukan.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!--Footer-->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

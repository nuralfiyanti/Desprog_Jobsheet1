<?php
session_start();
require_once "db.php";

// Cek jika user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek role admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['fullname'];

// Ambil data statistik dari database
try {
    $stmt_users = $pdo->query("SELECT COUNT(id) as total_users FROM users");
    $total_users = $stmt_users->fetchColumn();

    $stmt_movies = $pdo->query("SELECT COUNT(id) as total_movies FROM movies");
    $total_movies = $stmt_movies->fetchColumn();

    $stmt_bookings = $pdo->query("SELECT COUNT(id) as total_bookings FROM bookings");
    $total_bookings = $stmt_bookings->fetchColumn();
} catch (PDOException $e) {
    die("Tidak dapat mengambil data statistik: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-stat {
      transition: transform 0.2s;
    }
    .card-stat:hover {
      transform: translateY(-5px);
    }
  </style>
</head>
<body class="bg-light" style="padding-top: 70px; padding-bottom: 70px;">

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Konten Utama -->
<div class="container py-4">
  <h1 class="mb-4 fw-bold text-dark">🏠 Admin Dashboard</h1>
  <p class="text-muted mb-5">Selamat datang kembali, <span class="fw-semibold text-warning"><?= htmlspecialchars($user_fullname) ?></span>!</p>

  <div class="row g-4 mb-5">
    <div class="col-md-4">
      <div class="card bg-info text-white shadow card-stat">
        <div class="card-body">
          <h3 class="display-5 fw-bold"><?= $total_users ?></h3>
          <p class="fs-5 mb-2">Total Pengguna</p>
          <a href="users.php" class="text-white text-decoration-none">👥 Lihat Detail</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-success text-white shadow card-stat">
        <div class="card-body">
          <h3 class="display-5 fw-bold"><?= $total_movies ?></h3>
          <p class="fs-5 mb-2">Total Film Aktif</p>
          <a href="movies.php" class="text-white text-decoration-none">🎬 Kelola Film</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card bg-warning text-dark shadow card-stat">
        <div class="card-body">
          <h3 class="display-5 fw-bold"><?= $total_bookings ?></h3>
          <p class="fs-5 mb-2">Total Booking Tiket</p>
          <a href="booking.php" class="text-dark text-decoration-none">🎟 Kelola Booking</a>
        </div>
      </div>
    </div>
  </div>

  <hr class="my-5">

  <h2 class="mb-4 fw-bold">⚙️ Akses Cepat (CRUD)</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card border-primary shadow-sm h-100">
        <div class="card-header bg-primary text-white fw-bold">🎬 Manajemen Film</div>
        <div class="card-body">
          <p class="text-muted">Tambahkan, ubah, atau hapus daftar film yang sedang tayang.</p>
          <a href="movies.php" class="btn btn-primary">Go to Movies &rarr;</a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border-danger shadow-sm h-100">
        <div class="card-header bg-danger text-white fw-bold">🎟 Manajemen Booking</div>
        <div class="card-body">
          <p class="text-muted">Kelola data booking pengguna dengan mudah.</p>
          <a href="booking.php" class="btn btn-danger">Go to Bookings &rarr;</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

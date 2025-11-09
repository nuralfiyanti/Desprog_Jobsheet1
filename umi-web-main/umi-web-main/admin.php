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
    body { font-family: Arial; }
    .content-wrapper { margin: 40px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #aaa; padding: 8px; }
    th { background: #f3f3f3; }
  </style>
</head>
<body class="bg-light">

  <header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">🎟️ Admin Panel</h1>
      <nav>
        <ul class="nav align-items-center">
          <li class="nav-item"><a href="booking.php" class="nav-link text-white">Bookings</a></li>
          <li class="nav-item"><a href="movies.php" class="nav-link text-white">Movies</a></li>
          <li class="nav-item"><a href="users.php" class="nav-link text-white">Users</a></li>
          <li class="nav-item"><a href="admin.php" class="nav-link active text-warning fw-bold">All Bookings</a></li>
          <li class="nav-item ms-3">
            <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="content-wrapper">
    <h2>Daftar Semua Booking</h2>
    <table id="bookings" class="table table-bordered table-striped mt-3">
      <thead>
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
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td><?= htmlspecialchars($r['fullname']) ?></td>
              <td><?= htmlspecialchars($r['title']) ?></td>
              <td><?= htmlspecialchars($r['seats']) ?></td>
              <td><?= htmlspecialchars(date("d M Y, H:i:s", strtotime($r['booked_at']))) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align: center; color: #777;">Tidak ada booking ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
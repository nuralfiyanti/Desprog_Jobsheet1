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
  <title>Admin - Daftar Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial; }
    .content-wrapper { margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #888; padding: 8px 12px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body class="bg-light">

  <header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">👥 Admin Panel</h1>
      <nav>
        <ul class="nav align-items-center">
          <li class="nav-item"><a href="booking.php" class="nav-link text-white">Bookings</a></li>
          <li class="nav-item"><a href="movies.php" class="nav-link text-white">Movies</a></li>
          <li class="nav-item"><a href="users.php" class="nav-link active text-warning fw-bold">Users</a></li>
          <li class="nav-item"><a href="admin.php" class="nav-link text-white">All Bookings</a></li>
          <li class="nav-item ms-3">
            <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="content-wrapper">
    <h2>Daftar Pengguna</h2>
    <table id="userTable" class="table table-bordered table-striped mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Lengkap</th>
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
            <tr><td colspan="3" style="text-align: center; color: #777;">Tidak ada pengguna ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
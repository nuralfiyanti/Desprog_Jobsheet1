<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_fullname = $_SESSION['fullname'] ?? 'Guest';
$user_role = $_SESSION['role'] ?? 'guest';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🎬 Movie Ticketing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <?php if ($user_role === 'admin'): ?>
          <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
          <li class="nav-item"><a href="movies.php" class="nav-link">Movies</a></li>
          <li class="nav-item"><a href="users.php" class="nav-link">Users</a></li>
          <li class="nav-item"><a href="admin.php" class="nav-link">All Bookings</a></li>
        <?php elseif ($user_role === 'user'): ?>
          <li class="nav-item"><a href="movies.php" class="nav-link">Movies</a></li>
          <li class="nav-item"><a href="booking.php" class="nav-link">Bookings</a></li>
        <?php else: ?>
          <li class="nav-item"><a href="movies.php" class="nav-link">Movies</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link text-warning fw-semibold">Login</a></li>
        <?php endif; ?>

        <?php if ($user_role !== 'guest'): ?>
          <li class="nav-item ms-3">
            <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php
require_once "db.php";

// Ambil semua booking dari database
$stmt = $pdo->query("
    SELECT b.id, u.fullname, m.title, m.poster_url, b.seats, b.booked_at
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN movies m ON b.movie_id = m.id
    ORDER BY b.booked_at DESC
");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎟️ All Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .poster-thumb {
      max-width: 60px;
      height: 80px;
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
  </style>
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
        <li class="nav-item"><a class="nav-link text-white" href="booking.php">Book Tickets</a></li>
        <li class="nav-item"><a class="nav-link active text-warning fw-semibold" href="#">All Bookings</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container py-5 mt-5">
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0 fw-semibold">🎟️ All Movie Bookings</h4>
    </div>
    <div class="card-body bg-light">
      <?php if (count($bookings) > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle mb-0 text-center">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Poster</th>
                <th>Seats</th>
                <th>Booked At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $b): ?>
              <tr>
                <td><?= htmlspecialchars($b['id']) ?></td>
                <td><?= htmlspecialchars($b['fullname']) ?></td>
                <td><?= htmlspecialchars($b['title']) ?></td>
                <td>
                  <?php if (!empty($b['poster_url'])): ?>
                    <img src="<?= htmlspecialchars($b['poster_url']) ?>" alt="poster" class="poster-thumb">
                  <?php else: ?>
                    <span class="text-muted">No poster</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($b['seats']) ?></td>
                <td><?= date("d M Y, H:i", strtotime($b['booked_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-center text-muted py-3">No bookings found.</p>
      <?php endif; ?>
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

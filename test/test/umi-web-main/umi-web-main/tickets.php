<?php
require_once "db.php";

// Ambil semua booking dari database
$stmt = $pdo->query("
    SELECT b.id, u.fullname, m.title, m.poster, b.seats, b.booked_at
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
      max-width: 50px;
      max-height: 70px;
      object-fit: cover;
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">🎟️ All Bookings</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="booking.php">Book Tickets</a></li>
        <li class="nav-item"><a class="nav-link active text-warning fw-bold" href="#">View All</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h3 class="mb-4 text-center">All Movie Bookings</h3>

  <?php if (count($bookings) > 0): ?>
    <table class="table table-bordered table-striped align-middle text-center">
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
          <td><?= $b['id'] ?></td>
          <td><?= htmlspecialchars($b['fullname']) ?></td>
          <td><?= htmlspecialchars($b['title']) ?></td>
          <td>
            <?php if (!empty($b['poster'])): ?>
              <img src="assets/<?= htmlspecialchars($b['poster']) ?>" alt="" class="poster-thumb">
            <?php else: ?>
              <span class="text-muted">No poster</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($b['seats']) ?></td>
          <td><?= htmlspecialchars($b['booked_at']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-center text-muted">No bookings found.</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
require_once "db.php";

// Ambil data film dari database
try {
    $stmt = $pdo->query("SELECT * FROM movies ORDER BY id LIMIT 3");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $movies = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticketing</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<?php include 'navbar.php'; ?>


<!-- Hero Section -->
<section class="py-5 mt-5 bg-dark text-white">
  <div class="container">
    <div class="row align-items-center gy-4">
      <div class="col-lg-6">
        <h2 class="display-5 fw-bold mb-3">Catch the Latest Blockbusters Without the Queue</h2>
        <p class="lead mb-4">Pick a movie, choose your seats, and get ready for a great night out. Everything you need is just a click away.</p>
        <a href="booking.php" class="btn btn-warning btn-lg fw-semibold">🎟️ Book a Ticket</a>
      </div>
      <div class="col-lg-6 text-center">
        <img src="assets/movie1.jpg" class="img-fluid rounded shadow" alt="Cinema seats">
      </div>
    </div>
  </div>
</section>

<!-- Now Showing -->
<section class="py-5">
  <div class="container">
    <h2 class="mb-4 fw-bold text-center">🎥 Now Showing</h2>

    <?php if (empty($movies)): ?>
      <p class="text-center text-muted">No movies currently showing.</p>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($movies as $movie): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="<?= htmlspecialchars($movie['poster_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?> poster">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
              <p class="card-text text-muted mb-2">Duration: <?= htmlspecialchars($movie['duration_minutes']) ?> min</p>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-primary">Today · 7:30 PM</span>
                <span class="badge bg-secondary">PG-13</span>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!--Footer-->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

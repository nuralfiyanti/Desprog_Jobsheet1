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

// =============================================================
// 2. LOGIKA PENANGANAN POST (CREATE, UPDATE, DELETE)
// =============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'create_booking') {
            $movie_id = $_POST['movie_id'];
            $seats = $_POST['seats'];
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, movie_id, seats) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $movie_id, $seats]);
        }

        if ($action === 'delete_booking') {
            $booking_id = $_POST['booking_id'];
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
        }
        
        if ($action === 'update_booking') {
            $booking_id = $_POST['booking_id'];
            $seats = $_POST['seats'];
            $stmt = $pdo->prepare("UPDATE bookings SET seats = ? WHERE id = ?");
            $stmt->execute([$seats, $booking_id]);
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }
    
    header("Location: booking.php");
    exit;
}

// =============================================================
// 3. LOGIKA PENGAMBILAN DATA (READ)
// =============================================================
try {
    $movies = $pdo->query("SELECT * FROM movies ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);
    $bookings = $pdo->query("
        SELECT b.id, u.fullname, m.title, b.seats, b.booked_at
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN movies m ON b.movie_id = m.id
        ORDER BY b.booked_at DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Tidak dapat mengambil data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Tickets - Movie Ticketing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🎬 Movie Ticketing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
        <li class="nav-item"><a href="booking.php" class="nav-link text-warning fw-semibold">Book Tickets</a></li>
        <li class="nav-item"><a href="admin.php" class="nav-link text-white">All Bookings</a></li>
        <li class="nav-item"><a href="movies.php" class="nav-link text-white">Movies</a></li>
        <li class="nav-item ms-3 d-flex align-items-center">
          <span class="text-white me-2 small">Hi, <?= htmlspecialchars($user_fullname) ?></span>
          <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<main class="container py-5 mt-4">
  <section class="booking mb-5">
    <h2 class="fw-semibold mb-3">🎟 Choose a Movie</h2>
    <div class="row">
      <?php foreach ($movies as $movie): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
          <img src="<?= htmlspecialchars($movie['poster_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?>" style="max-height:250px;object-fit:cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
            <p class="card-text text-muted">Duration: <?= htmlspecialchars($movie['duration_minutes']) ?> min</p>
            <form method="POST" action="booking.php" class="mt-auto">
              <input type="hidden" name="action" value="create_booking">
              <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
              <div class="mb-2">
                <label for="seats-<?= $movie['id'] ?>" class="form-label">Number of Seats</label>
                <input type="number" id="seats-<?= $movie['id'] ?>" name="seats" class="form-control" min="1" max="10" value="1" required>
              </div>
              <button type="submit" class="btn btn-warning w-100 fw-bold">🎫 Book Now</button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if (empty($movies)): ?><p class="text-muted">No movies available.</p><?php endif; ?>
    </div>
  </section>

  <section>
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-dark text-white d-flex align-items-center">
        <h4 class="mb-0">📋 Booking List (All Users)</h4>
      </div>
      <div class="card-body bg-light">
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-dark text-center">
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Seats</th>
                <th>Booked At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $b): ?>
              <tr>
                <form method="POST" action="booking.php">
                  <input type="hidden" name="action" value="update_booking">
                  <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                  <td class="text-center"><?= $b['id'] ?></td>
                  <td><?= htmlspecialchars($b['fullname']) ?></td>
                  <td><?= htmlspecialchars($b['title']) ?></td>
                  <td><input type="number" name="seats" class="form-control form-control-sm" value="<?= htmlspecialchars($b['seats']) ?>" min="1" max="10"></td>
                  <td><?= date("d M Y, H:i", strtotime($b['booked_at'])) ?></td>
                  <td class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">✏️ Update</button>
                    <!-- Tombol delete memanggil form delete unik -->
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-<?= $b['id'] ?>')">🗑 Delete</button>
                  </td>
                </form>

                <!-- Form delete dengan ID unik -->
                <form id="delete-form-<?= $b['id'] ?>" method="POST" action="booking.php" style="display:none;">
                  <input type="hidden" name="action" value="delete_booking">
                  <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                </form>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($bookings)): ?><tr><td colspan="6" class="text-center text-muted py-3">No bookings found.</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<!--Footer-->
<footer class="text-center text-light py-3 border-top border-warning bg-black fixed-bottom">
  <p class="mb-0 small fw-semibold">
    &copy; <?= date('Y') ?> <span class="text-warning">Movie Ticketing</span> — All rights reserved.
  </p>
</footer>

<script>
function confirmDelete(formId) {
  if (confirm("Are you sure you want to delete this booking?")) {
    document.getElementById(formId).submit();
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

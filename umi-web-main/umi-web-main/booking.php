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
        // --- Aksi: Buat Booking Baru ---
        if ($action === 'create_booking') {
            $movie_id = $_POST['movie_id'];
            $seats = $_POST['seats'];
            
            // === PERUBAHAN PENTING: Gunakan $user_id dari sesi ===
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, movie_id, seats) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $movie_id, $seats]);
            // === AKHIR PERUBAHAN ===
        }

        // --- Aksi: Hapus Booking ---
        if ($action === 'delete_booking') {
            $booking_id = $_POST['booking_id'];
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
            $stmt->execute([$booking_id]);
        }
        
        // --- Aksi: Update Booking ---
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
    // Ambil daftar film
    $stmt_movies = $pdo->query("SELECT * FROM movies ORDER BY title");
    $movies = $stmt_movies->fetchAll(PDO::FETCH_ASSOC);

    // Ambil daftar booking (semua booking, seperti sebelumnya)
    $stmt_bookings = $pdo->query("
        SELECT b.id, u.fullname, m.title, b.seats, b.booked_at
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN movies m ON b.movie_id = m.id
        ORDER BY b.booked_at DESC
    ");
    $bookings = $stmt_bookings->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Tidak dapat mengambil data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎬 Movie Ticketing (PHP Native)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .movie-card img { max-height: 250px; object-fit: cover; }
    .table-form { display: flex; gap: 8px; justify-content: center; }
  </style>
</head>
<body class="bg-light">

  <header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">🎬 Movie Ticketing</h1>
      <nav>
        <ul class="nav align-items-center">
          <li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>
          <li class="nav-item"><a href="booking.php" class="nav-link active text-warning fw-bold">Book Tickets</a></li>
          <li class="nav-item"><a href="admin.php" class="nav-link text-white">View All</a></li>
          <li class="nav-item"><a href="movies.php" class="nav-link text-white">Manage Movies</a></li>
          <li class="nav-item ms-3">
            <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <main class="container mb-5">
    <section class="booking my-4">
      <h2 class="mb-3">🎟 Choose a Movie</h2>
      <div class="row" id="movie-list">
        <?php foreach ($movies as $movie): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm movie-card">
            <img src="<?= htmlspecialchars($movie['poster_url']) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($movie['title']) ?>">
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
        <?php if (empty($movies)): ?><p class="text-muted">No movies are currently showing.</p><?php endif; ?>
      </div>
    </section>

    <hr>

    <section class="mt-5">
      <h3>📋 Booking List (All Users)</h3>
      <table class="table table-bordered table-striped mt-3 align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Movie</th>
            <th>Seats</th>
            <th>Booked At</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody id="booking-table">
          <?php foreach ($bookings as $b): ?>
          <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['fullname']) ?></td>
            <td><?= htmlspecialchars($b['title']) ?></td>
            <form method="POST" action="booking.php" class="table-form">
              <input type="hidden" name="action" value="update_booking">
              <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
              <td>
                <input type="number" name="seats" class="form-control form-control-sm" value="<?= htmlspecialchars($b['seats']) ?>" min="1" max="10">
              </td>
              <td><?= date("d M Y, H:i", strtotime($b['booked_at'])) ?></td>
              <td class="text-center">
                <div class="table-form">
                  <button type="submit" class="btn btn-sm btn-primary">✏️ Update</button>
                  <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">🗑 Delete</button>
                </div>
              </td>
            </form>
            <form method="POST" action="booking.php" style="display: none;">
                <input type="hidden" name="action" value="delete_booking">
                <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
            </form>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($bookings)): ?><tr><td colspan="6" class="text-center text-muted">No bookings found.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </section>
  </main>

<script>
function confirmDelete(form) {
  if (confirm("Are you sure you want to delete this booking?")) {
    let deleteForm = form.nextElementSibling;
    if (deleteForm && deleteForm.elements['action'].value === 'delete_booking') {
        deleteForm.submit();
    } else {
        alert("Error finding delete form.");
    }
  }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
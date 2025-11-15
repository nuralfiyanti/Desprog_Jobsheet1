<?php
// 1. Mulai sesi dan cek login
session_start();
require_once "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// cek role admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['fullname'];

// =============================================================
// 2. LOGIKA PENANGANAN POST (CREATE, UPDATE, DELETE)
// =============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'create_movie') {
            $stmt = $pdo->prepare("INSERT INTO movies (title, duration_minutes, poster_url) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['title'], $_POST['duration'], $_POST['poster_url']]);
        }
        if ($action === 'delete_movie') {
            $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
            $stmt->execute([$_POST['movie_id']]);
        }
        if ($action === 'update_movie') {
            $stmt = $pdo->prepare("UPDATE movies SET title = ?, duration_minutes = ?, poster_url = ? WHERE id = ?");
            $stmt->execute([$_POST['title'], $_POST['duration'], $_POST['poster_url'], $_POST['movie_id']]);
        }
    } catch (PDOException $e) {
        if (str_contains($e->getMessage(), 'violates foreign key constraint')) {
            echo "<div class='alert alert-danger'>Error: Film tidak dapat dihapus karena sudah ada di data booking.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
        die();
    }
    header("Location: movies.php");
    exit;
}

// =============================================================
// 3. LOGIKA PENGAMBILAN DATA (READ)
// =============================================================
try {
    $stmt_movies = $pdo->query("SELECT * FROM movies ORDER BY id ASC");
    $movies = $stmt_movies->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Tidak dapat mengambil data film: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎬 Admin - Manage Movies</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .poster-preview { max-width: 60px; max-height: 90px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; }
    .card { border-radius: 1rem; }
    .table thead th { background-color: #212529; color: #fff; }
    .table tbody tr:hover { background-color: #fffbea; }
    .btn-warning { color: #212529; font-weight: 600; }
  </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<main class="container mt-5 mb-5">
 <section class="card shadow-sm border-0 p-4">
  <h2 class="fw-bold mb-4 text-dark">➕ Add New Movie</h2>
  <form method="POST" action="movies.php">
    <input type="hidden" name="action" value="create_movie">
    <div class="row g-3">
      <div class="col-md-5">
        <label for="title" class="form-label fw-semibold">Movie Title</label>
        <input type="text" id="title" name="title" class="form-control" required>
      </div>
      <div class="col-md-2">
        <label for="duration" class="form-label fw-semibold">Duration (min)</label>
        <input type="number" id="duration" name="duration" class="form-control" min="1" value="120" required>
      </div>
      <div class="col-md-5">
        <label for="poster_url" class="form-label fw-semibold">Poster URL</label>
        <input type="text" id="poster_url" name="poster_url" class="form-control" placeholder="assets/movie4.jpg" required>
      </div>
    </div>
    <div class="mt-4">
      <button type="submit" class="btn btn-warning px-4 fw-semibold">Add Movie</button>
    </div>
  </form>
</section>


  <section class="mt-5">
    <h3 class="fw-bold mb-3 text-dark">📋 Movie List</h3>
    <div class="table-responsive shadow-sm">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Duration (min)</th>
            <th>Poster (Preview & URL)</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($movies as $movie): ?>
<tr>
  <td><?= $movie['id'] ?></td>
  <td><?= htmlspecialchars($movie['title']) ?></td>
  <td><?= htmlspecialchars($movie['duration_minutes']) ?></td>
  <td>
    <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="Poster" class="poster-preview mb-2">
    <br>
    <?= htmlspecialchars($movie['poster_url']) ?>
  </td>
  <td class="text-center">
    <form method="POST" action="movies.php" style="display:inline-block;">
      <input type="hidden" name="action" value="update_movie">
      <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
      <button type="button" class="btn btn-sm btn-primary" onclick="showUpdateModal(<?= $movie['id'] ?>)">✏️ Update</button>
    </form>

    <form method="POST" action="movies.php" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this movie?');">
      <input type="hidden" name="action" value="delete_movie">
      <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
      <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>

          <?php if (empty($movies)): ?>
            <tr><td colspan="5" class="text-center text-muted">No movies found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
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
function confirmDelete(form) {
  if (confirm("Are you sure you want to delete this movie?")) {
    let deleteForm = form.nextElementSibling;
    if (deleteForm && deleteForm.elements['action'].value === 'delete_movie') {
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

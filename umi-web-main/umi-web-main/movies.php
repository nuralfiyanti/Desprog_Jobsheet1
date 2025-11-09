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
    // (Logika CRUD film sama seperti sebelumnya)
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
    .table-form { display: flex; gap: 8px; justify-content: start; }
    .action-cell { min-width: 190px; }
    .poster-preview { max-width: 60px; max-height: 90px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px; display: block; }
  </style>
</head>
<body class="bg-light">

  <header class="bg-dark text-white py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">🎬 Admin Panel</h1>
      <nav>
        <ul class="nav align-items-center">
          <li class="nav-item"><a href="booking.php" class="nav-link text-white">Bookings</a></li>
          <li class="nav-item"><a href="movies.php" class="nav-link active text-warning fw-bold">Movies</a></li>
          <li class="nav-item"><a href="users.php" class="nav-link text-white">Users</a></li>
          <li class="nav-item"><a href="admin.php" class="nav-link text-white">All Bookings</a></li>
          <li class="nav-item ms-3">
            <span class="navbar-text text-white me-2">Hi, <?= htmlspecialchars($user_fullname) ?></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm">Logout</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <main class="container mb-5">
    <section class="add-movie my-4 card p-4 shadow-sm">
      <h2 class="mb-3">➕ Add New Movie</h2>
      <form method="POST" action="movies.php">
        <input type="hidden" name="action" value="create_movie">
        <div class="row">
          <div class="col-md-5 mb-3"><label for="title" class="form-label">Movie Title</label><input type="text" id="title" name="title" class="form-control" required></div>
          <div class="col-md-2 mb-3"><label for="duration" class="form-label">Duration (min)</label><input type="number" id="duration" name="duration" class="form-control" min="1" value="120" required></div>
          <div class="col-md-5 mb-3"><label for="poster_url" class="form-label">Poster URL</label><input type="text" id="poster_url" name="poster_url" class="form-control" placeholder="assets/movie4.jpg" required></div>
        </div>
        <div class="text-end"><button type="submit" class="btn btn-success fw-bold">Add Movie</button></div>
      </form>
    </section>

    <hr>
    <section class="mt-5">
      <h3>📋 Movie List</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3 align-middle">
          <thead class="table-dark">
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
              <form method="POST" action="movies.php" class="table-form">
                <input type="hidden" name="action" value="update_movie">
                <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
                <td><?= $movie['id'] ?></td>
                <td><input type="text" name="title" class="form-control" value="<?= htmlspecialchars($movie['title']) ?>" required></td>
                <td><input type="number" name="duration" class="form-control" value="<?= htmlspecialchars($movie['duration_minutes']) ?>" min="1" required></td>
                <td>
                  <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="Poster" class="poster-preview" onerror="this.style.display='none'">
                  <input type="text" name="poster_url" class="form-control" value="<?= htmlspecialchars($movie['poster_url']) ?>" required>
                </td>
                <td class="text-center action-cell">
                  <div class="table-form">
                    <button type="submit" class="btn btn-sm btn-primary">✏️ Update</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this.form)">🗑 Delete</button>
                  </div>
                </td>
              </form>
              <form method="POST" action="movies.php" style="display: none;">
                  <input type="hidden" name="action" value="delete_movie">
                  <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
              </form>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($movies)): ?><tr><td colspan="5" class="text-center text-muted">No movies found.</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

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
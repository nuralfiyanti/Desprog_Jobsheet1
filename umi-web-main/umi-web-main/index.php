<?php
// Mulai sesi di setiap halaman
session_start();
require_once "db.php";

// Ambil data film dari database
try {
    $stmt = $pdo->query("SELECT * FROM movies ORDER BY id LIMIT 3");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Jika gagal, buat array kosong agar halaman tetap tampil
    $movies = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-K">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticketing</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container"> 
            <h1>Movie Ticketing</h1>
            <nav>
                <ul>
                    <li><a href="index.php" aria-current="page">Home</a></li>
                    <li><a href="booking.php">Book Tickets</a></li>
                    
                    <?php // --- PERUBAHAN NAVIGASI --- ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="admin.php">Admin</a></li>
                        <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['fullname']) ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                    <?php // --- AKHIR PERUBAHAN --- ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="hero">
            <div class="container hero-content">
                <div>
                    <h2>Catch the latest blockbusters without the queue</h2>
                    <p>Pick a movie, choose your seats, and get ready for a great night out. Everything you need is just a click away.</p>
                    <a class="btn" href="booking.php">Book a ticket</a>
                </div>
                <img src="assets/movie1.jpg" alt="Cinema seats">
            </div>
        </section>

        <section class="movies">
            <div class="container">
                <h2>Now Showing</h2>
                <div class="movie-list">
                    
                    <?php // --- PERUBAHAN DAFTAR FILM --- ?>
                    <?php if (empty($movies)): ?>
                        <p>No movies currently showing.</p>
                    <?php else: ?>
                        <?php foreach ($movies as $movie): ?>
                        <article class="movie">
                            <img src="<?= htmlspecialchars($movie['poster_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?> poster">
                            <div class="movie-details">
                                <h3><?= htmlspecialchars($movie['title']) ?></h3>
                                <p>Duration: <?= htmlspecialchars($movie['duration_minutes']) ?> min.</p>
                                <div class="tags">
                                    <span>Today · 7:30 PM</span>
                                    <span>PG-13</span>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php // --- AKHIR PERUBAHAN --- ?>

                </div>
            </div>
        </section>
    </main>
</body>
</html>
<?php
include 'koneksi.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $tahun = (int)($_POST['tahun'] ?? 0);
    $durasi = (int)($_POST['durasi'] ?? 0);

    if ($judul === '') $errors[] = 'Judul wajib diisi.';
    if ($genre === '') $errors[] = 'Genre wajib diisi.';
    if ($tahun <= 1800) $errors[] = 'Tahun tidak valid.';
    if ($durasi <= 0) $errors[] = 'Durasi harus lebih dari 0.';

    if (empty($errors)) {
        $stmt = pg_prepare($conn, 'ins_film', 'INSERT INTO film (judul, genre, tahun, durasi) VALUES ($1,$2,$3,$4)');
        $res = pg_execute($conn, 'ins_film', array($judul, $genre, $tahun, $durasi));
        if ($res) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data ke database.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Film</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Tambah Film</h4>

      <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($_POST['judul'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Genre</label>
          <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($_POST['tahun'] ?? '') ?>" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Durasi (menit)</label>
            <input type="number" name="durasi" class="form-control" value="<?= htmlspecialchars($_POST['durasi'] ?? '') ?>" required>
          </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>

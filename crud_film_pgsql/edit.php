<?php
include 'koneksi.php';
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}
$id = (int)$id;
$res = pg_query_params($conn, 'SELECT * FROM film WHERE id=$1', array($id));
$data = pg_fetch_assoc($res);
if (!$data) {
    header('Location: index.php');
    exit;
}
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
        $resup = pg_query_params($conn, 'UPDATE film SET judul=$1, genre=$2, tahun=$3, durasi=$4 WHERE id=$5', array($judul,$genre,$tahun,$durasi,$id));
        if ($resup) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Film</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Edit Film</h4>

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
          <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($_POST['judul'] ?? $data['judul']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Genre</label>
          <input type="text" name="genre" class="form-control" value="<?= htmlspecialchars($_POST['genre'] ?? $data['genre']) ?>" required>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($_POST['tahun'] ?? $data['tahun']) ?>" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Durasi (menit)</label>
            <input type="number" name="durasi" class="form-control" value="<?= htmlspecialchars($_POST['durasi'] ?? $data['durasi']) ?>" required>
          </div>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>

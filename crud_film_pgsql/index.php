<?php
include 'koneksi.php';
// Ambil semua film
$res = pg_query($conn, "SELECT * FROM film ORDER BY id DESC");
$films = [];
if ($res) {
    while ($row = pg_fetch_assoc($res)) $films[] = $row;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CRUD Film - PHP + PostgreSQL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="d-flex justify-content-between mb-3">
    <h2>Daftar Film</h2>
    <a href="tambah.php" class="btn btn-success">+ Tambah Film</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php if(count($films) === 0): ?>
        <div class="alert alert-info">Belum ada data film. Klik "Tambah Film" untuk menambahkan.</div>
      <?php else: ?>
        <table class="table table-striped table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th style="width:5%;">ID</th>
              <th>Judul</th>
              <th style="width:15%;">Genre</th>
              <th style="width:10%;">Tahun</th>
              <th style="width:12%;">Durasi (mnt)</th>
              <th style="width:18%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($films as $f): ?>
              <tr>
                <td><?= htmlspecialchars($f['id']) ?></td>
                <td><?= htmlspecialchars($f['judul']) ?></td>
                <td><?= htmlspecialchars($f['genre']) ?></td>
                <td><?= htmlspecialchars($f['tahun']) ?></td>
                <td><?= htmlspecialchars($f['durasi']) ?></td>
                <td>
                  <a href="edit.php?id=<?= urlencode($f['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="hapus.php?id=<?= urlencode($f['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus film ini?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

</div>
</body>
</html>

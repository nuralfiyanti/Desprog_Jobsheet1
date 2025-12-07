<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require '../../../../config/koneksi.php';
require '../../../../fungsi/pesan_kilat.php';
require '../../../../fungsi/anti_injection.php';

if (empty($_GET['id'])) {
    header("Location: ../../index.php?page=jabatan");
    exit;
}

$id = intval($_GET['id']);
$q  = mysqli_query($koneksi, "SELECT * FROM jabatan WHERE id = $id");

if (!$q || mysqli_num_rows($q) == 0) {
    $_SESSION['_flashdata']['danger'] = "Data tidak ditemukan.";
    header("Location: ../../index.php?page=jabatan");
    exit;
}

$row = mysqli_fetch_assoc($q);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Jabatan</title>

    <!-- Bootstrap bawaan jobsheet -->
    <link href="../../../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h4 class="mb-3">Edit Jabatan</h4>

    <div class="card">
        <div class="card-body">

            <form action="../../../../fungsi/edit.php?jabatan=edit" method="POST">

                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Jabatan</label>
                    <input type="text" name="jabatan" class="form-control"
                           value="<?= htmlspecialchars($row['nama_jabatan']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($row['keterangan']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="../../index.php?page=jabatan" class="btn btn-secondary">Batal</a>

            </form>

        </div>
    </div>

</div>

<script src="../../../../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

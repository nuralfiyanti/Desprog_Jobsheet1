<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// LOAD KONEKSI & FUNGSI
require 'config/koneksi.php';
require 'fungsi/pesan_kilat.php';
require 'fungsi/anti_injection.php';
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="../../../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aplikasi Kantor Alfi</title>

    <link href="../../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/custom/dashboard.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
<div class="row">

<?php 
// LOAD MENU
require 'template/menu.php'; 
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap
                 align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Jabatan</h1>
    </div>

    <div class="row mb-3">
        <div class="col-lg-2">
            <button type="button" class="btn btn-primary"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Tambah Jabatan
            </button>
        </div>
    </div>

    <?php 
    if (isset($_SESSION['_flashdata'])) { 
        echo "<br>";
        foreach ($_SESSION['_flashdata'] as $key => $val) { 
            echo get_flashdata($key);
        }
    }
    ?>

    <div class="table-responsive small">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jabatan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY id DESC");

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_jabatan']; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td>
                        <!-- EDIT -->
						<a href="admin/module/jabatan/edit/index.php?id=<?= $row['id']; ?>" 
							class="btn btn-warning btn-xs">
							<i class="fa fa-pencil-square-o"></i> Edit
						</a>

                        <!-- HAPUS -->
                        <a href="fungsi/hapus.php?jabatan=hapus&id=<?= $row['id']; ?>"
                           onclick="return confirm('Hapus Data Jabatan ?');"
                           class="btn btn-danger btn-xs">
                           <i class="fa fa-trash-o"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>

</main>
</div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

    <div class="modal-header">
        <h1 class="modal-title fs-5">Form Jabatan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

<form action="fungsi/tambah.php" method="POST">
    <div class="modal-body">

        <div class="mb-3">
            <label class="col-form-label">Nama Jabatan:</label>
            <input type="text" name="jabatan" class="form-control" required> 
        </div>

        <div class="mb-3">
            <label class="col-form-label">Keterangan:</label>
            <textarea class="form-control" name="keterangan"></textarea>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

</div>
</div>
</div>

<script src="../../../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

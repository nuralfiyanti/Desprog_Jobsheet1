<div class="container-fluid">
<div class="row">

<?php
require 'template/menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Anggota</h1>
    </div>

    <!-- Tombol tambah -->
    <div class="row mb-3">
        <div class="col-lg-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Tambah Anggota
            </button>
        </div>
    </div>

    <!-- Flash message -->
    <?php 
    if (isset($_SESSION['_flashdata'])) { 
        echo "<br>";
        foreach ($_SESSION['_flashdata'] as $key => $val) { 
            echo get_flashdata($key);
        }
    }
    ?>

    <!-- TABEL ANGGOTA -->
    <div class="table-responsive small">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
            $no = 1;
            $query = "SELECT a.*, j.nama_jabatan, u.username 
                      FROM anggota a 
                      JOIN jabatan j ON a.jabatan_id = j.id 
                      JOIN user u ON a.user_id = u.id 
                      ORDER BY a.id DESC";

            $result = mysqli_query($koneksi, $query);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['nama_jabatan']; ?></td>
                    <td><?= $row['username']; ?></td>

                    <td>
                        <a href="index.php?page=anggota/edit&id=<?= $row['user_id']; ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil-square-o"></i> Edit
                        </a>

                        <a href="fungsi/hapus.php?anggota=hapus&id=<?= $row['user_id']; ?>"
                           onclick="return confirm('Hapus data anggota?');"
                           class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- ======================= -->
    <!-- MODAL TAMBAH ANGGOTA -->
    <!-- ======================= -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="fungsi/tambah.php?anggota=tambah" method="POST">

                <div class="modal-body">

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="col-form-label">Nama:</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <!-- Jabatan -->
                    <div class="mb-3">
                        <label class="col-form-label">Jabatan:</label>
                        <select class="form-select" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            <?php
                            $q2 = "SELECT * FROM jabatan ORDER BY nama_jabatan ASC";
                            $r2 = mysqli_query($koneksi, $q2);
                            while ($row2 = mysqli_fetch_assoc($r2)) {
                            ?>
                                <option value="<?= $row2['id']; ?>">
                                    <?= $row2['nama_jabatan']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Jenis kelamin -->
                    <div class="mb-3">
                        <label class="col-form-label">Jenis Kelamin:</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" checked>
                            <label class="form-check-label">Laki-Laki</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="P">
                            <label class="form-check-label">Perempuan</label>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label class="col-form-label">Alamat:</label>
                        <textarea class="form-control" name="alamat"></textarea>
                    </div>

                    <!-- No Telp -->
                    <div class="mb-3">
                        <label class="col-form-label">No Telepon:</label>
                        <input type="number" name="no_telp" class="form-control">
                    </div>

                    <hr class="border border-primary border-2 opacity-75">

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="col-form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="col-form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <!-- Level -->
                    <div class="mb-3">
                        <label class="col-form-label">Level:</label>
                        <select class="form-select" name="level" required>
                            <option value="">Pilih Level</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-floppy-o"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
        </div>
    </div>


</main>
</div>
</div>

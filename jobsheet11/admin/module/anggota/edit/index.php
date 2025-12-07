<?php
require 'template/menu.php';
require 'config/koneksi.php';

$id = $_GET['id'];

$query = "SELECT * FROM anggota a
          JOIN jabatan j ON a.jabatan_id = j.id
          JOIN user u ON a.user_id = u.id
          WHERE a.user_id = '$id'";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);
?>

<div class="container-fluid">
    <div class="row">

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Anggota</h1>
</div>

<form action="fungsi/edit.php?anggota=edit" method="POST">

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">Form Edit Anggota</div>
            <div class="card-body">

                <input type="hidden" name="id" value="<?= $row['user_id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" value="<?= $row['nama']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <select class="form-select" name="jabatan">
                        <option>Pilih Jabatan</option>
                        <?php
                        $q2 = mysqli_query($koneksi, "SELECT * FROM jabatan ORDER BY nama_jabatan ASC");
                        while ($row2 = mysqli_fetch_assoc($q2)) {
                        ?>
                            <option value="<?= $row2['id']; ?>"
                                <?= ($row['jabatan_id'] == $row2['id']) ? 'selected' : '' ?>>
                                <?= $row2['nama_jabatan']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>

                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                               value="L" <?= ($row['jenis_kelamin'] === "L") ? 'checked' : '' ?>>
                        Laki-Laki
                    </label>

                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                               value="P" <?= ($row['jenis_kelamin'] === "P") ? 'checked' : '' ?>>
                        Perempuan
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat"><?= $row['alamat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telepon</label>
                    <input type="number" class="form-control" name="no_telp" value="<?= $row['no_telp']; ?>">
                </div>

            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">Form Edit Login Anggota</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?= $row['username']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                    <div class="form-text">Kosongi jika tidak ingin mengganti password.</div>
                </div>

            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah</button>
                <a href="index.php?page=anggota" class="btn btn-secondary"><i class="fa fa-times"></i> Batal</a>
            </div>
        </div>
    </div>
</div>

</form>

</main>

</div>
</div>

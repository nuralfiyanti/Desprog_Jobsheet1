<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include('koneksi.php');

// Ambil ID dari URL
$id = $_GET['id'];

// Query ambil data anggota berdasarkan ID
$query = "SELECT * FROM anggota WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$row = mysqli_fetch_assoc($result);

?>
<div class="container">
    <h2>Edit Data Anggota</h2>

    <form action="proses.php?aksi=ubah" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo $row['nama']; ?>" required>

        <label>Jenis Kelamin:</label>
        <div class="radio-group">
            <input type="radio" name="jenis_kelamin" value="L" id="laki" 
                <?php if ($row['jenis_kelamin'] === 'L') echo 'checked'; ?>>
            <label for="laki">Laki-laki</label>

            <input type="radio" name="jenis_kelamin" value="P" id="perempuan" 
                <?php if ($row['jenis_kelamin'] === 'P') echo 'checked'; ?>>
            <label for="perempuan">Perempuan</label>
        </div>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" id="alamat" value="<?php echo $row['alamat']; ?>" required>

        <label for="no_telp">No. Telp:</label>
        <input type="text" name="no_telp" id="no_telp" value="<?php echo $row['no_telp']; ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php" class="btn-kembali">Kembali</a>
    </form>
</div>

</body>
</html>

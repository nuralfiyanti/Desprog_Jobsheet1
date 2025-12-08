<?php
require_once 'Crud.php';

$crud = new Crud();
$id = $_GET['id']; // Ambil ID dari URL
$tampil = $crud->readById($id); // Ambil data berdasarkan ID

// Update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jabatan = $_POST['jabatan'];
    $keterangan = $_POST['keterangan'];

    $crud->update($id, $jabatan, $keterangan);
    header("Location: index.php"); // Redirect ke halaman utama setelah update
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jabatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Data Jabatan</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="jabatan">Jabatan:</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" 
                   value="<?php echo $tampil['nama_jabatan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea class="form-control" id="keterangan" name="keterangan" cols="30" rows="5" required><?php echo $tampil['keterangan']; ?></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $tampil['id']; ?>">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<!-- Script Bootstrap & jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Multi Upload Gambar</title>
</head>
<body>
    <h2>Unggah Gambar</h2>
    <form action="proses_upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple="multiple"
        accept=".jpg, .jpeg, .png, .gif, .svg, .webp">
        <input type="submit" value="Unggah" />
    </form>
</body>
</html>
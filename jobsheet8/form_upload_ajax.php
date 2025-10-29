<!DOCTYPE html>
<html>

<head>
    <title>Unggah Beberapa File</title>
</head>

<body>
    <form id="upload-form" action="upload_ajax.php" method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" id="file" multiple>
        <input type="submit" name="submit" value="Unggah">
    </form>

    <div id="status"></div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- File JavaScript -->
    <script src="upload.js"></script>
</body>
</html>

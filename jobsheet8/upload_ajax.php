<?php
if (isset($_FILES['files'])) {
    $upload_dir = "images/";

    // Buat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $errors = [];

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_size = $_FILES['files']['size'][$key];
        $file_tmp  = $_FILES['files']['tmp_name'][$key];

        // Ambil ekstensi file
        $temp = explode('.', $file_name);
        $file_ext = strtolower(end($temp));

        // Validasi ekstensi
        if (!in_array($file_ext, $allowed_ext)) {
            $errors[] = "Ekstensi file $file_name tidak diizinkan (hanya JPG, PNG, GIF).";
            continue;
        }

        // Validasi ukuran file (maks 2 MB)
        if ($file_size > 2097152) {
            $errors[] = "$file_name melebihi ukuran maksimum (2MB).";
            continue;
        }

        // Upload file
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            echo "<p>File $file_name berhasil diunggah</p>";
        } else {
            $errors[] = "Gagal mengunggah $file_name.";
        }
    }

    if (!empty($errors)) {
        echo "<p style='color:red;'>" . implode("<br>", $errors) . "</p>";
    }
}
?>

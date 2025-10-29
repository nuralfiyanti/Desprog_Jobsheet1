<?php
if (isset($_FILES['file'])) {
    $errors = [];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp  = $_FILES['file']['tmp_name'];

    // Ambil ekstensi file
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Tentukan ekstensi yang diperbolehkan
    $allowed_extensions = ["pdf", "doc", "docx", "txt"];

    // Validasi ekstensi
    if (!in_array($file_ext, $allowed_extensions)) {
        $errors[] = "Hanya file PDF, DOC, DOCX, atau TXT yang diperbolehkan.";
    }

    // Validasi ukuran file (maks 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        $errors[] = "Ukuran file tidak boleh lebih dari 2 MB.";
    }

    // Buat folder jika belum ada
    $upload_dir = "documents/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Proses upload jika tidak ada error
    if (empty($errors)) {
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            echo "<p style='color:green;'>File <b>$file_name</b> berhasil diunggah!</p>";
        } else {
            echo "<p style='color:red;'>Gagal mengunggah file.</p>";
        }
    } else {
        echo "<p style='color:red;'>" . implode("<br>", $errors) . "</p>";
    }
}
?>

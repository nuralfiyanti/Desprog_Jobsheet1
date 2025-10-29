<?php
if (isset($_FILES['file'])) {
    $errors = array();

    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp  = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    // Ambil ekstensi file
    $temp = explode('.', $file_name);
    $file_ext = strtolower(end($temp));

    $extensions = array("pdf", "doc", "docx", "txt");

    // Validasi ekstensi (gunakan NOT in_array)
    if (!in_array($file_ext, $extensions)) {
        $errors[] = "Ekstensi file yang diizinkan hanya PDF, DOC, DOCX, atau TXT.";
    }

    // Validasi ukuran file (maks 2MB)
    if ($file_size > 2097152) {
        $errors[] = "Ukuran file tidak boleh lebih dari 2 MB.";
    }

    // Jika tidak ada error, upload file
    if (empty($errors)) {
        if (move_uploaded_file($file_tmp, "documents/" . $file_name)) {
            echo "File berhasil diunggah.";
        } else {
            echo "Gagal mengunggah file.";
        }
    } else {
        echo implode(" ", $errors);
    }
}
?>

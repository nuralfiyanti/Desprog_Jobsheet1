<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Folder tempat file akan disimpan
$targetDirectory = "uploads/";

// Buat folder jika belum ada
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if (isset($_FILES["files"]["name"][0]) && $_FILES["files"]["name"][0] != "") {

    $allowedExtensions = array(
        "jpg", "jpeg", "png", "gif", "svg", "webp", 
        "pdf", "doc", "docx", "ppt", "pptx", "xls", "xlsx" 
    );

    $totalFiles = count($_FILES["files"]["name"]);

    for ($i = 0; $i < $totalFiles; $i++) {

        $fileName = $_FILES["files"]["name"][$i];
        $targetFile = $targetDirectory . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileError = $_FILES["files"]["error"][$i];
        $fileSize = $_FILES["files"]["size"][$i];

        if ($fileError === 0) {
 
            if (in_array($fileType, $allowedExtensions)) {
       
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $targetFile)) {
                    echo "File <b>$fileName</b> berhasil diunggah.<br>";
                } else {
                    echo "Gagal mengunggah file <b>$fileName</b>.<br>";
                }
            } else {
                echo "File <b>$fileName</b> ditolak: Ekstensi tidak diizinkan.<br>";
            }
        } else {
            echo "File <b>$fileName</b> gagal diunggah. Error code: $fileError<br>";
        }
    }

} else {
    echo "Tidak ada file yang diunggah.";
}
?>

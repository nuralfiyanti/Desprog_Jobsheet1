<?php
if(isset($_POST["submit"])){
    $targetdir = "uploads/"; 
    $targetfile = $targetdir . basename($_FILES["myfile"]["name"]);
    $filetype = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));
    
    $allowedExtensions = array("text", "pdf", "doc", "docx");
    $maxsize = 3*1024*1024; 

    if (in_array($filetype, $allowedExtensions) && $_FILES["myfile"]["size"] <= $maxsize){

        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetfile)){
            echo "File berhasil diunggah.<br>";
        }
        else{
            echo "Gagal mengunggah file.";
        }
    }
    else{
        echo "File tidak valid atau melebihi ukuran maximum yang diizinkan";
    }
}
?>
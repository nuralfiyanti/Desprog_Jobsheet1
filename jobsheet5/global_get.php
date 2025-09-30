<?php
$nama = @$_GET['nama']; // tanda @ agar tidak ada warning ketika key kosong
$usia = @$_GET['usia']; // tanda @ agar tidak ada warning ketika key kosong

echo "Halo {$nama}! Apakah benar anda berusia {$usia} tahun?"; 
?>

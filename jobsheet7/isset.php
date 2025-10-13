<?php
$umur;
// cek variabel $umur ada dan >= 18
if (isset($umur) && $umur >= 18) {
    echo "Anda sudah dewasa.";
} else {
    echo "Anda belum dewasa atau variabel 'umur' tidak ditemukan.";
}

echo "<br>"; 

$data = array("nama" => "Jane", "usia" => 25);

// cek elemen 'nama' ada di dalam array $data
if (isset($data["nama"])) {
    echo "Nama: " . $data["nama"];
} else {
    echo "Variabel 'nama' tidak ditemukan dalam array.";
}
?>
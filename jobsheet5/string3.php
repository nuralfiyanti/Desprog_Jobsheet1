<?php

$pesan = "saya arek malang";

# ubah variabel $pesan menjadi array dengan pemisah spasi
$pesanPerKata = explode(" ", $pesan);

# ubah setiap kata dalam array menjadi kebalikannya
$pesanPerKata = array_map(fn($kata) => strrev($kata), $pesanPerKata);

# gabungkan kembali array menjadi string dengan spasi
$pesan = implode(" ", $pesanPerKata);

echo $pesan . "<br>";

?>

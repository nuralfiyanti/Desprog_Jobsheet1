<?php
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali   = $a * $b;
$hasilBagi   = $a / $b;
$sisaBagi    = $a % $b;
$pangkat     = $a ** $b;

echo "Nilai a: {$a} <br>";
echo "Nilai b: {$b} <br><br>";

echo "Hasil Penjumlahan (a + b) = {$hasilTambah} <br>";
echo "Hasil Pengurangan (a - b) = {$hasilKurang} <br>";
echo "Hasil Perkalian (a * b) = {$hasilKali} <br>";
echo "Hasil Pembagian (a / b) = {$hasilBagi} <br>";
echo "Hasil Sisa Bagi (a % b) = {$sisaBagi} <br>";
echo "Hasil Pangkat (a ** b) = {$pangkat} <br>";
echo "<hr>";
echo "<h3>Operator Perbandingan</h3>";

$hasilSama            = $a == $b;
$hasilTidakSama       = $a != $b;
$hasilLebihKecil      = $a < $b;
$hasilLebihBesar      = $a > $b;
$hasilLebihKecilSama  = $a <= $b;
$hasilLebihBesarSama  = $a >= $b;

echo "a == b ? "; var_dump($hasilSama); echo "<br>";
echo "a != b ? "; var_dump($hasilTidakSama); echo "<br>";
echo "a < b ? "; var_dump($hasilLebihKecil); echo "<br>";
echo "a > b ? "; var_dump($hasilLebihBesar); echo "<br>";
echo "a <= b ? "; var_dump($hasilLebihKecilSama); echo "<br>";
echo "a >= b ? "; var_dump($hasilLebihBesarSama); echo "<br>";

echo "<hr>";
echo "<h3>Operator Logika</h3>";

$hasilAnd  = $a && $b;
$hasilOr   = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

echo "a && b = "; var_dump($hasilAnd); echo "<br>";
echo "a || b = "; var_dump($hasilOr); echo "<br>";
echo "!a = "; var_dump($hasilNotA); echo "<br>";
echo "!b = "; var_dump($hasilNotB); echo "<br>";

echo "<hr>";
echo "<h3>Operator Penugasan</h3>";

$a = 10; $b = 5;
$a += $b; echo "a += b → $a <br>";
$a -= $b; echo "a -= b → $a <br>";
$a *= $b; echo "a *= b → $a <br>";
$a /= $b; echo "a /= b → $a <br>";
$a %= $b; echo "a %= b → $a <br>";

?>

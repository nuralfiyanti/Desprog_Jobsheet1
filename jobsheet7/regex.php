<?php
$pattern = '/[a-z]/';
$text = 'This is a Sample Text.';
if (preg_match($pattern, $text)) {
    echo "Huruf kecil ditemukan!<br>";
} else {
    echo "Tidak ada huruf kecil!<br>";
}

$pattern = '/[0-9]+/'; 
$text = 'There are 123 apples.';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok!<br>";
}

$pattern = '/apple/';
$replacement = 'banana';
$text = 'I like apple pie.';
$new_text = preg_replace($pattern, $replacement, $text);
echo $new_text . "<br>";

$pattern = '/go*d/';
$text = 'god is good.';
if (preg_match($pattern, $text, $matches)) {
    echo "Cocokkan: " . $matches[0] . "<br>";
} else {
    echo "Tidak ada yang cocok!<br>";
}

$pattern = '/go?d/';
$text = 'gd god good.';
if (preg_match_all($pattern, $text, $matches)) {
    echo "Cocokkan 'go?d': " . implode(', ', $matches[0]) . "<br>";
} else {
    echo "Tidak ada yang cocok 'go?d'!<br>";
}

$pattern = '/go{1,2}d/';
$text = 'gd god good goood.';
if (preg_match_all($pattern, $text, $matches)) {
    echo "Cocokkan 'go{1,2}d': " . implode(', ', $matches[0]) . "<br>";
} else {
    echo "Tidak ada yang cocok 'go{1,2}d'!<br>";
}
?>
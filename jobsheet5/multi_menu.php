<?php
$menu = [
    [
        "nama" => "Beranda"
    ],
    [
        "nama" => "Berita",
        "subMenu" => [
            [
                "nama" => "Wisata",
                "subMenu" => [
                    [ "nama" => "Pantai" ],
                    [ "nama" => "Gunung" ]
                ]
            ],
            [ "nama" => "Kuliner" ],
            [ "nama" => "Hiburan" ]
        ]
    ],
    [
        "nama" => "Tentang"
    ],
    [
        "nama" => "Kontak"
    ],
];

// Fungsi rekursif untuk menampilkan menu
function tampilkanMenuBertingkat(array $menu) {
    echo "<ul>";
    foreach ($menu as $item) {
        echo "<li>{$item['nama']}";

        // Jika ada subMenu, panggil fungsi lagi
        if (isset($item['subMenu'])) {
            tampilkanMenuBertingkat($item['subMenu']);
        }

        echo "</li>";
    }
    echo "</ul>";
}

tampilkanMenuBertingkat($menu);
?>

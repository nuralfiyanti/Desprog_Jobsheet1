<?php
// Memulai session
session_start();

// Membuat Token Keamanan Ajax Request (Csrf Token)
if (empty($_SESSION['csrf_token'])) {
    // Membuat token acak dan menyimpannya di session
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
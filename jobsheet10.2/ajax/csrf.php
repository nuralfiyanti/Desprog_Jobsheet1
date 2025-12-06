<?php
// Memastikan session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Mengirimkan Token Keamanan (Jika belum ada, buat token baru)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Mengambil headers yang dikirim oleh AJAX
$headers = apache_request_headers();

// Cek apakah Csrf-Token ada di header dan bandingkan dengan session
if (isset($headers['Csrf-Token'])) {
    if ($headers['Csrf-Token'] !== $_SESSION['csrf_token']) {
        // Jika token tidak cocok, hentikan eksekusi
        http_response_code(403); // Forbidden
        exit(json_encode(['error' => 'Wrong CSRF token.']));
    }
} else {
    // Jika token tidak dikirim, hentikan eksekusi
    http_response_code(403); // Forbidden
    exit(json_encode(['error' => 'No CSRF token.']));
}
?>
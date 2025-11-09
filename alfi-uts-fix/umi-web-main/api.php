<?php
header("Content-Type: application/json");
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? $_GET['path'] : '';
$parts = explode('/', trim($path, '/'));
$resource = $parts[0] ?? '';
$id = $parts[1] ?? null;

// === MOVIES ===
if ($resource === 'movies' && $method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM movies ORDER BY id");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// === BOOKINGS ===
if ($resource === 'bookings') {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT b.id, u.fullname, m.title, b.seats, b.booked_at
                            FROM bookings b
                            JOIN users u ON b.user_id = u.id
                            JOIN movies m ON b.movie_id = m.id
                            ORDER BY b.booked_at DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $user_id = $input['user_id'] ?? null;
        $movie_id = $input['movie_id'] ?? null;
        $seats = $input['seats'] ?? null;

        if (!$user_id || !$movie_id || !$seats) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'message' => 'Missing data']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, movie_id, seats) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $movie_id, $seats]);
        echo json_encode(['ok' => true, 'message' => 'Booking successful']);
        exit;
    }

    if ($method === 'DELETE' && $id) {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['ok' => true, 'message' => 'Booking deleted']);
        exit;
    }

        // === UPDATE BOOKING ===
    if ($method === 'PUT' && $id) {
        $input = json_decode(file_get_contents('php://input'), true);
        $seats = $input['seats'] ?? null;

        if (!$seats) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'message' => 'Seats value required']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE bookings SET seats = ? WHERE id = ?");
        $stmt->execute([$seats, $id]);
        echo json_encode(['ok' => true, 'message' => 'Booking updated successfully']);
        exit;
    }

}

http_response_code(404);
echo json_encode(['ok' => false, 'message' => 'Not found']);
exit;
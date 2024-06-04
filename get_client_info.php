<?php
require('app/database/db.php');

// Проверка роли администратора
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('location: ' . BASE_URL);
    exit();
}

$client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;

if ($client_id) {
    // Получение информации о клиенте
    $user = selectOne('users', ['users_id' => $client_id]);

    // Получение информации о детях клиента
    $kids = selectAll('kid', ['users_id' => $client_id]);

    // Получение информации о временных промежутках
    $bookings = $pdo->prepare("
        SELECT start_time, end_time
        FROM bookings
        WHERE user_id = :user_id
    ");
    $bookings->execute(['user_id' => $client_id]);
    $bookings = $bookings->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'user' => $user,
        'kids' => $kids,
        'bookings' => $bookings
    ]);
} else {
    echo json_encode(['error' => 'Invalid client ID']);
}
?>

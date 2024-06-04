<?php
include("path.php");
require('app/database/db.php');

// Проверка аутентификации администратора
if (!isset($_SESSION['users_id']) || $_SESSION['role_id'] != 0) {
    header('location: ' . LOGIN_URL);
    exit();
}

$errMsg = '';
$successMsg = '';

// Получить всех пользователей с role_id = 1
$users = $pdo->query("SELECT users_id, name, surname FROM users WHERE role_id = 1")->fetchAll(PDO::FETCH_ASSOC);

// Получить всех инструкторов
$instructors = $pdo->query("
    SELECT i.instructor_id, u.name, u.surname
    FROM instructor i
    JOIN users u ON i.users_id = u.users_id
")->fetchAll(PDO::FETCH_ASSOC);

// Получить все услуги
$services = $pdo->query("
    SELECT service_id, name, price, type
    FROM service
")->fetchAll(PDO::FETCH_ASSOC);

// Получить выбранные значения из формы
$selected_user_id = isset($_POST['users_id']) ? $_POST['users_id'] : null;
$selected_kid_id = isset($_POST['kid_id']) ? $_POST['kid_id'] : null;
$selected_instructor_id = isset($_POST['instructor_id']) ? $_POST['instructor_id'] : null;
$selected_service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;

// Получить всех детей выбранного пользователя
$kids = [];
if ($selected_user_id) {
    $stmt = $pdo->prepare("SELECT kid_id, name, surname FROM kid WHERE users_id = :users_id");
    $stmt->execute(['users_id' => $selected_user_id]);
    $kids = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получить доступные временные промежутки
$time_windows = [];
if ($selected_instructor_id && $selected_service_id) {
    $query = "
        SELECT tw.time_window_id, tw.start_time, tw.end_time, tw.max_slots, 
               (SELECT COUNT(*) FROM bookings b WHERE b.time_window_id = tw.time_window_id) AS booked_slots
        FROM time_window tw
        WHERE tw.instructor_id = :instructor_id AND tw.max_slots > 
              (SELECT COUNT(*) FROM bookings b WHERE b.time_window_id = tw.time_window_id)
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['instructor_id' => $selected_instructor_id]);
    $time_windows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Обработка формы записи на тренировку
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['time_window_id'], $_POST['kid_id'])) {
    $time_window_id = $_POST['time_window_id'];
    $kid_id = $_POST['kid_id'];
    $time_window = selectOne('time_window', ['time_window_id' => $time_window_id]);

    if ($time_window) {
        // Проверка типа услуги и бронирований
        $service = selectOne('service', ['service_id' => $selected_service_id]);
        $booked_count = $pdo->query("
            SELECT COUNT(*) AS count FROM bookings WHERE time_window_id = $time_window_id
        ")->fetchColumn();

        if ($service['type'] == 'personal' && $booked_count >= 1) {
            $errMsg = "Вы записались на групповую тренировку.";
        } elseif ($booked_count >= $time_window['max_slots']) {
            $errMsg = "Этот временной слот уже полностью забронирован.";
        }

        if (!$errMsg) {
            $params = [
                'time_window_id' => $time_window_id,
                'users_id' => $selected_user_id,
                'kid_id' => $kid_id,
                'service_id' => $selected_service_id,
                'start_time' => $time_window['start_time'],
                'end_time' => $time_window['end_time'],
                'instructor_id' => $selected_instructor_id
            ];
            insert('bookings', $params);
            $successMsg = "Запись на тренировку успешно создана.";
            echo "<script>alert('$successMsg'); window.location.reload();</script>";
            exit();
        }
    } else {
        $errMsg = "Выбранный временной слот не найден.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>КапитанПупс</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">   
    <link rel="stylesheet" href="css/office_admin.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.main {
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.cont_tren {
    margin-top: 20px;
}

.error-message {
    color: red;
    margin-bottom: 20px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin: 10px 0 5px;
    font-weight: bold;
}

select, button {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button {
    background-color: #f9ac21;
    color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #f8b842;
}

select:focus, button:focus {
    outline: none;
    border-color: #f9ac21;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
    </style>
</head>
<body>



<div class="wrapper" action="log_of.php" method="post">
<div class="left">
        <div class="left-wrapper">

           <div class="left-title">Тренировки</div>
                <div class="left-menu">
                <a href="admin_info_schedule.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                        <path d="M21 5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5zM5 19V5h14l.002 14H5z"></path><path d="M7 7h1.998v2H7zm4 0h6v2h-6zm-4 4h1.998v2H7zm4 0h6v2h-6zm-4 4h1.998v2H7zm4 0h6v2h-6z"></path>
                    </svg>
                    Расписание
                    </a>
                    
                    <a href="admin_book_appointment.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                            <path d="M4 21a1 1 0 0 0 .24 0l4-1a1 1 0 0 0 .47-.26L21 7.41a2 2 0 0 0 0-2.82L19.42 3a2 2 0 0 0-2.83 0L4.3 15.29a1.06 1.06 0 0 0-.27.47l-1 4A1 1 0 0 0 3.76 21 1 1 0 0 0 4 21zM18 4.41 19.59 6 18 7.59 16.42 6zM5.91 16.51 15 7.41 16.59 9l-9.1 9.1-2.11.52z"></path>
                        </svg>
                    Записать
                    </a>
                </div>
            </div>
            <div class="left-wrapper">
                <div class="left-title">Аккаунты</div>
                <div class="left-menu">
                    <a href="admin_clients.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                            <path d="M3 2h2v20H3zm7 4h7v2h-7zm0 4h7v2h-7z"></path><path d="M19 2H6v20h13c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 18H8V4h11v16z"></path>
                        </svg>
                    Все клиенты
                    </a>
                    <a href="admin_add_clients.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                            <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 2c3.213 0 5.982 1.908 7.254 4.648a7.8 7.8 0 0 1-.895-.498c-.409-.258-.873-.551-1.46-.772-.669-.255-1.4-.378-2.234-.378s-1.565.123-2.234.377c-.587.223-1.051.516-1.472.781-.378.237-.703.443-1.103.594C9.41 8.921 8.926 9 8.33 9c-.595 0-1.079-.079-1.524-.248-.4-.151-.728-.358-1.106-.598-.161-.101-.34-.208-.52-.313C6.587 5.542 9.113 4 12 4zm0 16c-4.411 0-8-3.589-8-8 0-.81.123-1.59.348-2.327.094.058.185.11.283.173.411.26.876.554 1.466.776.669.255 1.399.378 2.233.378.833 0 1.564-.123 2.235-.377.587-.223 1.051-.516 1.472-.781.378-.237.703-.443 1.103-.595.445-.168.929-.247 1.525-.247s1.08.079 1.525.248c.399.15.725.356 1.114.602.409.258.873.551 1.46.773.363.138.748.229 1.153.291.049.357.083.717.083 1.086 0 4.411-3.589 8-8 8z"></path><circle cx="8.5" cy="13.5" r="1.5"></circle><circle cx="15.5" cy="13.5" r="1.5"></circle>
                        </svg>
                    Создание аккаунтов
                    </a>
                    <a href="<?php echo BASE_CONCAT_URL . "logout.php"; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);">
                            <path d="M5 5v14a1 1 0 0 0 1 1h3v-2H7V6h2V4H6a1 1 0 0 0-1 1zm14.242-.97-8-2A1 1 0 0 0 10 3v18a.998.998 0 0 0 1.242.97l8-2A1 1 0 0 0 20 19V5a1 1 0 0 0-.758-.97zM15 12.188a1.001 1.001 0 0 1-2 0v-.377a1 1 0 1 1 2 .001v.376z"></path>
                        </svg>
                     Выйти
                    </a>
                </div>
        </div>
    </div>

    <main class="main">

    <h1>Запись на тренировку (администратор)</h1>
<div class="cont_tren">
    <?php if ($errMsg): ?>
        <p style="color: red;"><?= htmlspecialchars($errMsg) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="users_id">Выберите пользователя:</label>
        <select id="users_id" name="users_id" required onchange="this.form.submit()">
            <option value="">-- Выберите пользователя --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['users_id']) ?>" <?= isset($selected_user_id) && $selected_user_id == $user['users_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if ($selected_user_id): ?>
            <label for="kid_id">Выберите ребенка:</label>
            <select id="kid_id" name="kid_id" required>
                <option value="">-- Выберите ребенка --</option>
                <?php foreach ($kids as $kid): ?>
                    <option value="<?= htmlspecialchars($kid['kid_id']) ?>" <?= isset($selected_kid_id) && $selected_kid_id == $kid['kid_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kid['name'] . ' ' . $kid['surname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <label for="instructor_id">Выберите инструктора:</label>
        <select id="instructor_id" name="instructor_id" required onchange="this.form.submit()">
            <option value="">-- Выберите инструктора --</option>
            <?php foreach ($instructors as $instructor): ?>
                <option value="<?= htmlspecialchars($instructor['instructor_id']) ?>" <?= isset($selected_instructor_id) && $selected_instructor_id == $instructor['instructor_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($instructor['name'] . ' ' . $instructor['surname']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="service_id">Выберите услугу:</label>
        <select id="service_id" name="service_id" required onchange="this.form.submit()">
            <option value="">-- Выберите услугу --</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= htmlspecialchars($service['service_id']) ?>" <?= isset($selected_service_id) && $selected_service_id == $service['service_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($service['name']) ?> (<?= htmlspecialchars($service['price']) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <?php if ($selected_instructor_id && $selected_service_id): ?>
            <label for="time_window_id">Выберите временной слот:</label>
            <select id="time_window_id" name="time_window_id" required>
                <option value="">-- Выберите временной слот --</option>
                <?php foreach ($time_windows as $time_window): ?>
                    <option value="<?= htmlspecialchars($time_window['time_window_id']) ?>">
                        <?= htmlspecialchars($time_window['start_time'] . ' - ' . $time_window['end_time'] . ' (Доступно мест: ' . ($time_window['max_slots'] - $time_window['booked_slots']) . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <button type="submit">Записать на тренировку</button>
    </form>
</div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>
    
</body>
</html>
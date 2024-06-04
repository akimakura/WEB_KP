<?php
include("path.php");
require('app/database/db.php');

// Проверка аутентификации администратора
if (!isset($_SESSION['users_id']) || $_SESSION['role_id'] != 2) {
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
</head>
<body>



        <div class="wrapper" action="log_of.php" method="post">
        <div class="left">
            <div class="left-wrapper">
                <div class="left-title">Тренировки</div>
                <div class="left-menu">
                    <a href="schedule.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2zm-4 2v11H8V8h8zm-1-4v2H9V4h6zM4 8h2v11H4V8zm14 11V8h2l.001 11H18z"></path>
                        </svg>
                     Предстоящие 
                    </a>
                    <a href="add_schedule.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)"><path d="M12 2c-4.963 0-9 4.038-9 9v8h.051c.245 1.691 1.69 3 3.449 3 1.174 0 2.074-.417 2.672-1.174a3.99 3.99 0 0 0 5.668-.014c.601.762 1.504 1.188 2.66 1.188 1.93 0 3.5-1.57 3.5-3.5V11c0-4.962-4.037-9-9-9zm7 16.5c0 .827-.673 1.5-1.5 1.5-.449 0-1.5 0-1.5-2v-1h-2v1c0 1.103-.897 2-2 2s-2-.897-2-2v-1H8v1c0 1.845-.774 2-1.5 2-.827 0-1.5-.673-1.5-1.5V11c0-3.86 3.141-7 7-7s7 3.14 7 7v7.5z"></path>
                            <circle cx="9" cy="10" r="2"></circle><circle cx="15" cy="10" r="2"></circle>
                        </svg>
                     Добавить окна
                    </a>
                </div>
            </div>
            <div class="left-wrapper">
                <div class="left-title">Categories</div>
                <div class="left-menu">
                    <a href="search_schedule.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                        </svg>
                        Список клиентов
                    </a>
                    <a href="pool_schedule.php">
                        <svg viewBox="0 0 512 512" fill="currentColor">
                            <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                            <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                        </svg>
                        Загруженность
                    </a>
                    <a href="clients_add_schedule.php">
                        <svg viewBox="0 0 512 512" fill="currentColor">
                            <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                            <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                        </svg>
                        Запись
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
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>
    
</body>
</html>              
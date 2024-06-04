<?php
include("path.php");
require('app/database/db.php');

// Проверка аутентификации пользователя
if (!isset($_SESSION['users_id'])) {
    header('location: ' . LOGIN_URL);
    exit();
}

$errMsg = '';
$user_id = $_SESSION['users_id'];

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

// Получить всех детей пользователя
$kids = $pdo->prepare("SELECT kid_id, name, surname FROM kid WHERE users_id = :users_id");
$kids->execute(['users_id' => $user_id]);
$kids = $kids->fetchAll(PDO::FETCH_ASSOC);

// Если выбран инструктор и услуга, получить его доступные слоты
$selected_instructor_id = isset($_POST['instructor_id']) ? $_POST['instructor_id'] : null;
$selected_service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;
$time_windows = [];
if ($selected_instructor_id && $selected_service_id) {
    $query = "
        SELECT tw.time_window_id, tw.start_time, tw.end_time, tw.max_slots, 
               (SELECT COUNT(*) FROM bookings b WHERE b.time_window_id = tw.time_window_id) AS booked_slots
        FROM time_window tw
        LEFT JOIN bookings b ON tw.time_window_id = b.time_window_id
        WHERE tw.instructor_id = :instructor_id AND tw.max_slots > 
              (SELECT COUNT(*) FROM bookings b WHERE b.time_window_id = tw.time_window_id)
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['instructor_id' => $selected_instructor_id]);
    $time_windows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['time_window_id'], $_POST['kid_id'])) {
    $time_window_id = $_POST['time_window_id'];
    $kid_id = $_POST['kid_id'];
    $time_window = selectOne('time_window', ['time_window_id' => $time_window_id]);

    if ($time_window) {
        // Проверка типа услуги и бронирований
        $service = selectOne('service', ['service_id' => $selected_service_id]);
        if ($service['type'] == 'personal') {
            $booked_count = $pdo->query("
                SELECT COUNT(*) AS count FROM bookings WHERE time_window_id = $time_window_id
            ")->fetchColumn();
            if ($booked_count >= 1) {
                $errMsg = "Этот временной слот уже забронирован для персональной тренировки.";
            }
        }

        if (!$errMsg) {
            $params = [
                'time_window_id' => $time_window_id,
                'users_id' => $user_id,
                'kid_id' => $kid_id,
                'service_id' => $selected_service_id,
                'start_time' => $time_window['start_time'],
                'end_time' => $time_window['end_time'],
                'instructor_id' => $selected_instructor_id
            ];
            insert('bookings', $params);
            header('location: appointments.php');
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
    <link rel="stylesheet" href="css/log_of.css">
</head>
<body>

<div class="wrapper" action="log_of.php" method="post">
        <div class="left">
            <div class="left-wrapper">
                <div class="left-title">Тренировки</div>
                <div class="left-menu">
                    <a href="appointments.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2zm-4 2v11H8V8h8zm-1-4v2H9V4h6zM4 8h2v11H4V8zm14 11V8h2l.001 11H18z"></path>
                        </svg>
                     Мои записи
                    </a>
                    <a href="book_appointment.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                        </svg>
                     Записаться
                    </a>
                </div>
            </div>
            <div class="left-wrapper">
                <div class="left-title">Профиль</div>
                <div class="left-menu">
                    <a href="profile.php">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)"><path d="M12 2c-4.963 0-9 4.038-9 9v8h.051c.245 1.691 1.69 3 3.449 3 1.174 0 2.074-.417 2.672-1.174a3.99 3.99 0 0 0 5.668-.014c.601.762 1.504 1.188 2.66 1.188 1.93 0 3.5-1.57 3.5-3.5V11c0-4.962-4.037-9-9-9zm7 16.5c0 .827-.673 1.5-1.5 1.5-.449 0-1.5 0-1.5-2v-1h-2v1c0 1.103-.897 2-2 2s-2-.897-2-2v-1H8v1c0 1.845-.774 2-1.5 2-.827 0-1.5-.673-1.5-1.5V11c0-3.86 3.141-7 7-7s7 3.14 7 7v7.5z"></path>
                            <circle cx="9" cy="10" r="2"></circle><circle cx="15" cy="10" r="2"></circle>
                        </svg>
                     Мой Профиль
                    </a>
                    <!-- <a href="#">
                     <svg viewBox="0 0 512 512" fill="currentColor">
                      <circle cx="295.099" cy="327.254" r="110.96" transform="rotate(-45 295.062 327.332)" />
                      <path d="M471.854 338.281V163.146H296.72v41.169a123.1 123.1 0 01121.339 122.939c0 3.717-.176 7.393-.5 11.027zM172.14 327.254a123.16 123.16 0 01100.59-120.915L195.082 73.786 40.146 338.281H172.64c-.325-3.634-.5-7.31-.5-11.027z" />
                     </svg>
                     Graphic Design
                    </a> -->
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
            <div class="content">
                <h2 class="rol">Пользователь</h2> 
                <h1>Записаться на прием</h1>
                <form method="post">
                    <label for="instructor_id">Выберите инструктора:</label>
                    <select name="instructor_id" id="instructor_id" onchange="this.form.submit()" required>
                        <option value="">-- Выберите инструктора --</option>
                        <?php foreach ($instructors as $instructor): ?>
                            <option value="<?= htmlspecialchars($instructor['instructor_id']) ?>" <?= $selected_instructor_id == $instructor['instructor_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($instructor['name'] . ' ' . $instructor['surname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="service_id">Выберите услугу:</label>
                    <select name="service_id" id="service_id" onchange="this.form.submit()" required>
                        <option value="">-- Выберите услугу --</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= htmlspecialchars($service['service_id']) ?>" <?= $selected_service_id == $service['service_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($service['name'] . ' (' . $service['price'] . ' руб.)') ?> (<?= $service['type'] == 'personal' ? 'Персональная' : 'Групповая' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <?php if ($selected_instructor_id && $selected_service_id && $time_windows): ?>
                    <form method="post">
                        <input type="hidden" name="instructor_id" value="<?= htmlspecialchars($selected_instructor_id) ?>">
                        <input type="hidden" name="service_id" value="<?= htmlspecialchars($selected_service_id) ?>">
                        <label for="time_window_id">Выберите временной слот:</label>
                        <select name="time_window_id" id="time_window_id" required>
                            <?php foreach ($time_windows as $window): ?>
                                <option value="<?= htmlspecialchars($window['time_window_id']) ?>">
                                    <?= htmlspecialchars(strftime('%B %d %H:%M', strtotime($window['start_time'])) . ' - ' . strftime('%H:%M', strtotime($window['end_time']))) ?>
                                    (Свободных мест: <?= $window['max_slots'] - $window['booked_slots'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="kid_id">Выберите ребенка:</label>
                        <select name="kid_id" id="kid_id" required>
                            <?php foreach ($kids as $kid): ?>
                                <option value="<?= htmlspecialchars($kid['kid_id']) ?>"><?= htmlspecialchars($kid['name'] . ' ' . $kid['surname']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Записаться</button>
                    </form>
                <?php endif; ?>
                <?php if ($errMsg): ?>
                    <p><?= htmlspecialchars($errMsg) ?></p>
                <?php endif; ?>
            </div>
        </main>
        </div>
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>
    
</body>
</html>
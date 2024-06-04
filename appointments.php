<?php
include("path.php");
require('app/database/db.php');

// Проверка аутентификации пользователя
if (!isset($_SESSION['users_id'])) {
    header('location: ' . LOGIN_URL);
    exit();
}

$user_id = $_SESSION['users_id'];

// Получение всех записей пользователя
$query = "
    SELECT 
        b.bookings_id, 
        b.start_time, 
        b.end_time, 
        s.name AS service_name, 
        s.price, 
        s.type, 
        u.name AS instructor_name, 
        u.surname AS instructor_surname,
        k.name AS kid_name, 
        k.surname AS kid_surname
    FROM bookings b
    JOIN service s ON b.service_id = s.service_id
    JOIN time_window tw ON b.time_window_id = tw.time_window_id
    JOIN instructor i ON tw.instructor_id = i.instructor_id
    JOIN users u ON i.users_id = u.users_id
    JOIN kid k ON b.kid_id = k.kid_id
    WHERE b.users_id = :users_id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['users_id' => $user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
<form class="wrapper" action="log_of.php" method="post">
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
                <h1>Мои записи</h1>
                <?php if ($appointments): ?>
                    <table>
                        <tr>
                            <th>Услуга</th>
                            <th>Цена</th>
                            <th>Тип</th>
                            <th>Инструктор</th>
                            <th>Ребенок</th>
                            <th>Начало</th>
                            <th>Конец</th>
                        </tr>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['price']) ?></td>
                                <td><?= htmlspecialchars($appointment['type'] == 'personal' ? 'Персональная' : 'Групповая') ?></td>
                                <td><?= htmlspecialchars($appointment['instructor_name'] . ' ' . $appointment['instructor_surname']) ?></td>
                                <td><?= htmlspecialchars($appointment['kid_name'] . ' ' . $appointment['kid_surname']) ?></td>
                                <td><?= htmlspecialchars(strftime('%m-%d %H:%M', strtotime($appointment['start_time']))) ?></td>
                                <td><?= htmlspecialchars(strftime('%H:%M', strtotime($appointment['end_time']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>У вас нет записей.</p>
                <?php endif; ?>
            </div>
        </main>
        </form>
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
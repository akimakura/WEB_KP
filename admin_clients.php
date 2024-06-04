<?php
include("path.php");
require('app/database/db.php');

// Проверка роли инструктора
if ($_SESSION['role_id'] != 0) {
    header('location: ' . BASE_URL);
    exit();
}

$errMsg = '';
$searchResults = [];
$selectedClient = null;
$kids = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_client'])) {
    $searchTerm = trim($_POST['search_term']);
    
    if ($searchTerm !== '') {
        $searchResults = selectAll('users', [
            'OR' => [
                'name' => "%$searchTerm%",
                'surname' => "%$searchTerm%"
            ]
        ]);
    } else {
        $errMsg = "Введите имя или фамилию для поиска.";
    }
}

if (isset($_GET['users_id'])) {
    $users_id = $_GET['users_id'];
    $selectedClient = selectOne('users', ['users_id' => $users_id]);
    $kids = selectAll('kid', ['users_id' => $users_id]);
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
            <div class="content">
                <h2 class="rol">Админ</h2> 

                <h1>Поиск клиента</h1>
                <form method="post">
                    <label for="search_term">Имя или фамилия:</label>
                    <input type="text" id="search_term" name="search_term" required>
                    <button type="submit" name="search_client">Поиск</button>
                </form>

                <?php if ($errMsg): ?>
                    <p><?= $errMsg ?></p>
                <?php endif; ?>
                
                <?php if ($searchResults): ?>
                    <h2>Результаты поиска</h2>
                    <ul class="ul_record">
                        <?php foreach ($searchResults as $client): ?>
                            <li>
                                <a href="?users_id=<?= $client['users_id'] ?>">
                                    <?= htmlspecialchars($client['name']) ?> <?= htmlspecialchars($client['surname']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                        
                <?php if ($selectedClient): ?>
                    <h2>Информация о клиенте</h2>
                    <p>Имя: <?= htmlspecialchars($selectedClient['name']) ?></p>
                    <p>Фамилия: <?= htmlspecialchars($selectedClient['surname']) ?></p>
                    <p>Телефон: <?= htmlspecialchars($selectedClient['phone_number']) ?></p>
                    <p>Email: <?= htmlspecialchars($selectedClient['email']) ?></p>
                    <!-- Отображение других полей профиля -->
                
                    <h3>Дети клиента</h3>
                    <?php if ($kids): ?>
                        <ul class="ul_record">
                            <?php foreach ($kids as $kid): ?>
                                <li>
                                    <?= htmlspecialchars($kid['name']) ?> <?= htmlspecialchars($kid['surname']) ?>, возраст: <?= htmlspecialchars($kid['age']) ?>
                                    <?php if (!empty($kid['photo'])): ?>
                                        <br>
                                        <img src="<?= htmlspecialchars($kid['photo']) ?>" alt="Фото" style="max-width: 100px;">
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>У клиента нет зарегистрированных детей.</p>
                    <?php endif; ?>
                <?php endif; ?>
                
            </div>
        </main>
   </div>
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>


</body>
</html>
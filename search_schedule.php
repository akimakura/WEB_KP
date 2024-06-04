<?php
require('app/database/db.php');

// Проверка роли инструктора
if ($_SESSION['role_id'] != 2) {
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
            <div class="content">
                <h2 class="rol">Тренер</h2> 

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
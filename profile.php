<?php
include("path.php");
require('app/database/db.php');

// Проверка аутентификации пользователя
if (!isset($_SESSION['users_id'])) {
    header('location: ' . LOGIN_URL);
    exit();
}

$user_id = $_SESSION['users_id'];
$errMsg = '';

// Получение информации о пользователе
$user = selectOne('users', ['users_id' => $user_id]);

// Получение информации о детях пользователя
$kids = selectAll('kid', ['users_id' => $user_id]);

// Обработка запроса на изменение данных пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Обновление данных пользователя
    update('users', ['users_id' => $user_id], [
        'name' => $name,
        'surname' => $surname,
        'phone_number' => $phone_number,
        'email' => $email
    ]);

    // Перенаправление на эту же страницу после обновления
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Обработка запроса на добавление информации о ребенке
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_kid'])) {
    $kid_name = $_POST['kid_name'];
    $kid_surname = $_POST['kid_surname'];
    $kid_age = $_POST['kid_age'];

    // Проверка и загрузка файла
    if (isset($_FILES['kid_photo']) && $_FILES['kid_photo']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        
        // Создаем директорию если она не существует
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Генерация уникального имени файла
        $file_name = uniqid() . '-' . basename($_FILES['kid_photo']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['kid_photo']['tmp_name'], $file_path)) {
            // Добавление информации о ребенке в базу данных с фотографией
            insert('kid', [
                'users_id' => $user_id,
                'name' => $kid_name,
                'surname' => $kid_surname,
                'age' => $kid_age,
                'photo' => $file_path
            ]);
        } else {
            $errMsg = "Ошибка при загрузке файла.";
        }
    } else {
        // Добавление информации о ребенке в базу данных без фотографии
        insert('kid', [
            'users_id' => $user_id,
            'name' => $kid_name,
            'surname' => $kid_surname,
            'age' => $kid_age
        ]);
    }

    // Перенаправление на эту же страницу после добавления
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Обработка запроса на удаление ребенка
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_kid'])) {
    $kid_id = $_POST['kid_id'];

    // Удаление ребенка из базы данных
    delete('kid', ['kid_id' => $kid_id, 'users_id' => $user_id]);

    // Перенаправление на эту же страницу после удаления
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
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
                <h1>Мой профиль</h1>
    <h2>Информация о пользователе</h2>
    <form method="post">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>">
        <br>
        <label for="surname">Фамилия:</label>
        <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($user['surname']) ?>">
        <br>
        <label for="phone_number">Номер телефона:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>">
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
        <br>
        <!-- Другие поля профиля -->
        <button type="submit" name="update_profile">Обновить профиль</button>
    </form>

    <h2>Мои дети</h2>
    <?php if ($kids): ?>
        <ul class="ul_record">
            <?php foreach ($kids as $kid): ?>
                <li>
                    <?= htmlspecialchars($kid['name']) ?> <?= htmlspecialchars($kid['surname']) ?>, возраст: <?= htmlspecialchars($kid['age']) ?>
                    <?php if (!empty($kid['photo'])): ?>
                        <br>
                        <img src="<?= htmlspecialchars($kid['photo']) ?>" alt="Фото" style="max-width: 100px;">
                    <?php endif; ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="kid_id" value="<?= $kid['kid_id'] ?>">
                        <button type="submit" name="delete_kid" onclick="return confirm('Вы уверены, что хотите удалить этого ребенка?');">Удалить</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>У вас нет детей.</p>
    <?php endif; ?>

    <h3>Добавить информацию о ребенке</h3>
    <form method="post" enctype="multipart/form-data">
        <label for="kid_name">Имя ребенка:</label>
        <input type="text" id="kid_name" name="kid_name">
        <br>
        <label for="kid_surname">Фамилия ребенка:</label>
        <input type="text" id="kid_surname" name="kid_surname">
        <br>
        <label for="kid_age">Возраст ребенка:</label>
        <input type="date" id="kid_age" name="kid_age">
        <br>
        <label for="kid_photo">Фото (справка):</label>
        <input type="file" id="kid_photo" name="kid_photo">
        <br>
        <button type="submit" name="add_kid">Добавить ребенка</button>
    </form>
    <?php if ($errMsg): ?>
        <p><?= $errMsg ?></p>
    <?php endif; ?>
</body>
</html>

<?php
global $pdo;
include("app/database/db.php");

$errMsg = '';

// РЕГИСТРАЦИЯ
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])) {

    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $tel = $_POST['tel'];
    $password = trim($_POST['password']);
    

    if ($email === '' || $name === '' || $surname === '' || $tel === '' || $password === '') {
        $errMsg = "Заполните все поля!";
        $errMsg = htmlspecialchars($errMsg, ENT_QUOTES, 'UTF-8');
    }
    elseif (mb_strlen($password, 'UTF-8') < 4){
        $errMsg = "Err: Пароль должен быть более 4-x символов";
    }
    elseif (!(is_numeric($tel))){
        $errMsg = "Err: Введите корректный номер телефона";
    }
    else{
        $existence = selectOne('users', ['email' => $email]);
        if ($existence && $existence['email'] === $email){
            $errMsg = "Err: Пользователь с такой почтой существует";
        }
        else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $data_log = [
                'login' => $email,
                'password' => $pass_hash
            ];
            insert('data_log', $data_log);

            $email_data_log =  selectOne('data_log', ['login' => $email] );
            $data_log_id = $email_data_log['data_log_id'];
            
            $user_contacts = [
                'data_log_id' =>  $data_log_id,
                'name' => $name,
                'surname' => $surname,
                'phone_number' => $tel,
                'email' => $email
            ];
            $user_id = insert('users', $user_contacts);
            $user_data = selectOne('users', ['users_id' => $user_id]);

            $_SESSION['users_id'] = $user_data['users_id'];
            $_SESSION['role_id'] = $user_data['role_id'];
            header('location: ' . LOGIN_URL);
        }
    }
}
else {
    $email = '';
    $name = '';
    $surname = '';
    $tel = '';
}

// ВХОД В ЛК
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])) {
    $email = trim($_POST['email']);
    $password_log = trim($_POST['password_log']);

    if ($email === '' || $password_log === '') {
        $errMsg = "Заполните все поля!";
    } else {
        $existence = selectOne('data_log', ['login' => $email]);
        if ($existence && password_verify($password_log, $existence['password'])) {
            // Записываем данные в сессию
            $_SESSION['login'] = $existence['login'];

            // Подготовленный запрос
            $stmt = $pdo->prepare("
                SELECT u.role_id, i.instructor_id
                FROM data_log d
                JOIN users u ON d.data_log_id = u.data_log_id
                LEFT JOIN instructor i ON u.users_id = i.users_id
                WHERE d.login = :email
            ");
            // Передача значения параметра :email и выполнение запроса
            $stmt->execute(['email' => $email]);
            // Получение результата
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Записываем роль пользователя и instructor_id в сессию
            $_SESSION['role_id'] = $result['role_id'];
            if ($result['role_id'] == 2) { // Проверка, является ли пользователь инструктором
                $_SESSION['instructor_id'] = $result['instructor_id'];
            }

            // Проверка роли и редирект
            if ($result['role_id'] == 0) {
                header('location: ' . ADMIN_URL);
            } elseif ($result['role_id'] == 2) {
                header('location: ' . TRENER_URL);
            } else {
                header('location: ' . USER_URL);
            }
            exit();
        } else {
            $errMsg = "Почта или пароль введены неверно";
        }
    }
} else {
    $email = '';
}
?>
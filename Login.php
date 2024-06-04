<?php
    include("path.php");
    include("app/controllers/users.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Login.css">
</head>
<body>
    <div class="wrapper">
        <p class="err" ><?=$errMsg?></p>
        <form action="Login.php" method="post">
            <h1>Вход</h1>
        <div class="input-box">
            <input name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8')?>" type="email" id="InputEmail" placeholder="Логин" required>
            <i class='bx bx-user'></i>
        </div>

        <div class="input-box">
            <input name="password_log" type="password" id="InputPassword" placeholder="Пароль" required>
            <i class='bx bx-lock-alt' ></i>
        </div>

        <div class="remember">
            <a href="#">Забыли пароль?</a>
        </div>

        <button type="submit" class="btn" name="button-log">Войти</button>

        <div class="register-link">
            <p>Ещё не зарегестрированы? <a href="Register.php">Регистрация</a></p>
        </div>

        </form>
    </div>
</body>
</html>
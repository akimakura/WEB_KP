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
    <link rel="stylesheet" href="css/Register.css">
</head>
<body>
    <div class="wrapper">
        <form action="Register.php" method="post">
            <h1>Регистрация</h1>
        <div class="input-box">
            <input name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8')?>" type="email" id="InputEmail" placeholder="Почта" required>
            <i class='bx bx-user'></i>
        </div>

        <div class="input-box">
            <input name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?>" type="text" id="InputName" placeholder="Имя" required>
            <i class='bx bx-lock-alt' ></i>
        </div>

        <div class="input-box">
            <input name="surname" value="<?= htmlspecialchars($surname, ENT_QUOTES, 'UTF-8')?>" type="text" id="InputSurname" placeholder="Фамилия" required>
            <i class='bx bx-lock-alt' ></i>
        </div>

        <div class="input-box">
            <input name="tel" value="<?= htmlspecialchars($tel, ENT_QUOTES, 'UTF-8')?>" type="tel" id="InputTel" maxlength="11" placeholder="Номер-телефона" required>
            <i class='bx bx-lock-alt' ></i>
        </div>

        <div class="input-box">
            <input name="password" type="password" id="InputPassword" placeholder="Пароль" required>
            <i class='bx bx-lock-alt' ></i>
        </div>

        <div class="remember">
            <p class="err" ><?=$errMsg = htmlspecialchars($errMsg, ENT_QUOTES, 'UTF-8');?></p>
        </div>

        <button type="submit" class="btn" name="button-reg">Зарегестрироватсья</button>


        </form>
    </div>
</body>
</html>
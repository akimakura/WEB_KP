<?php
include("path.php");
include("app/controllers/users.php");
?>
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
<!--    <div class="wrapper">-->
        <form class="wrapper" action="log_of.php" method="post">
        <div class="left">
            <div class="left-wrapper">

                <div class="left-title">Тренировки</div>
                <div class="left-menu">
                    <a href="admin_clients.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v11c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2zm-4 2v11H8V8h8zm-1-4v2H9V4h6zM4 8h2v11H4V8zm14 11V8h2l.001 11H18z"></path>
                        </svg>
                    все клиенты
                    </a>
                    <a href="admin_book_appointment.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                            <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z"></path><path d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z"></path>
                        </svg>
                    Записать
                    </a>
                </div>
            </div>
            <div class="left-wrapper">
                <div class="left-title">Профиль</div>
                <div class="left-menu">
                    <a href="admin_info_schedule.php">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)"><path d="M12 2c-4.963 0-9 4.038-9 9v8h.051c.245 1.691 1.69 3 3.449 3 1.174 0 2.074-.417 2.672-1.174a3.99 3.99 0 0 0 5.668-.014c.601.762 1.504 1.188 2.66 1.188 1.93 0 3.5-1.57 3.5-3.5V11c0-4.962-4.037-9-9-9zm7 16.5c0 .827-.673 1.5-1.5 1.5-.449 0-1.5 0-1.5-2v-1h-2v1c0 1.103-.897 2-2 2s-2-.897-2-2v-1H8v1c0 1.845-.774 2-1.5 2-.827 0-1.5-.673-1.5-1.5V11c0-3.86 3.141-7 7-7s7 3.14 7 7v7.5z"></path>
                            <circle cx="9" cy="10" r="2"></circle><circle cx="15" cy="10" r="2"></circle>
                        </svg>
                    Мой Профиль
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
                

            </div>
        </main>
        </form>
<!--    </div>-->
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11
/swiper-bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
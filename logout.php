<?php
session_start();

include "path.php";

unset($_SESSION['login']);
unset($_SESSION['password']);
unset($_SESSION['role_id']);
unset($_SESSION['instructor_id']);

header('location:' . BASE_URL);


/*"<?php echo BASE_URL . "logout.php"; ?>"*/
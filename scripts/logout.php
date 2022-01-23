<?php

require "db.php";
unset($_SESSION['logged_user']);
setcookie('login', '', time(), '/');
setcookie('key', '', time(), '/');
header('Location: /');

?>

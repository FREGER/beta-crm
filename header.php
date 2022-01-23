<?
require "scripts/db.php";
?>
<?
if(!isset($user)){
    ?>
<a href="scripts/login.php">Логин</a>
<a href="scripts/signup.php">Регистрация</a>
<?
}else{

    ?>
    <div style="display:flex; background-color:grey; text-align:center;">
    <h1>Здравствуйте, <?echo($user->email);?></h1>
    <a href="scripts/logout.php"style="margin-top:30px;margin-left:30px;">Выйти</a>
    </div>
    <?
}
?>
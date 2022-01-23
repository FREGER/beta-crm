<?php
require "db.php";
$data = $_POST;
if( isset($data['do_reg']))
{
  header("Location: signup-log.php");
}
if( isset($data['do_login']))
{
  $errors = array();
  $user = R::findOne('users','email = ?', array($data['email']));

if($user)
{
  if(password_verify($data['password'], $user->password)){
    $_SESSION['logged_user'] = $user;
    if ( isset($data['remember']) and $data['remember'] == 'on' ) {
			setcookie('email', $user['email'], time()+60*60*24*30, '/'); //логин
      setcookie('key', trim($user['password']), time()+60*60*24*30, '/'); //случайная строка
    }header('Location: /');

    }else{
    $errors[] = 'Неверно введён пароль!';
  }
}else
{
  $errors[] = 'Пользователь не найден!';
}
if( empty($errors))
{}else
{
    //echo '<div id="errors"">'.array_shift($errors).'</div><hr>';
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>َСайт</title>
    <link rel="stylesheet" href="/css/login-reg.css">
    <link rel="stylesheet" href="/fonts/lato/lato.css">
    <script src="https://kit.fontawesome.com/d45622d32e.js" crossorigin="anonymous"></script>
  </head>
  <body>
<div class="form">
<div class="inform">

<form class="box" action="/scripts/login-reg.php" method="post">
<h1>Добро пожаловать в CRM.<br>
Войдите, чтобы начать работу</h1>

<?if($_GET["reg"] == "true"){
  ?><p id="ent">Вы успешно зарегистрировались! Войдите в свой аккаунт</p><?
}elseif(($_GET["reg"] == "restore")){
  ?>
  <p id="ent">Вы успешно сменили свой пароль! Войдите в свой аккаунт</p>
  <?
} else{
  if(!isset($errors)){
?>
<p id="ent">Enter your details to proceed further</p>
<?}else{
?>
<p id="ent"><?echo($errors[0])?></p>
<?
}?>
<?}?>
<p class="for">Email</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="email" name="email" placeholder="Start typing…" value="<?php echo @$data['email']?>">
  <img src="/iconz/email.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
  <p class="for">Пароль</p>
  <div style="display:flex;position:relative;width:361px;">
  <input type="password" name="password" placeholder="Start typing…">
  <img src="/iconz/lock.svg" class="pass_ic">
 
  </div>
  <hr class="hr">
  <div style="display:flex; margin-top:30px;">
  <div><label for="remember"><input type="checkbox" name="remember" id="remember" checked><span class="remember"> Запомнить меня</label></div>
<a id="restore" href="restore.php">Восстановить пароль</a>
</div>
  <input type="submit"name="do_login" value="Войти" class="sub_br">
  <input type="submit"name="do_reg"value="Регистрация"  class="sub_nbr">
  
</form>
</div>
</div>
<div>
    <img src="/iconz/login.png" class="img">
</div>

  </body>
</html>

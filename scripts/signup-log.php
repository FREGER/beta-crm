<?php
require "db.php";
$data = $_POST;

if( isset($data['redirect']))
{
  header("Location: login-reg.php");
}



if( isset($data['reset']))
{
    unset($_SESSION["login"]);
    unset($_SESSION["email"]);
    unset($_SESSION["phone"]);
    unset($_SESSION["name"]);
    unset($_SESSION["password"]);
    unset($_POST['reset']);
  }

if (isset($data['do_reg1']))
{

    if (trim($data['login']) == '')
    {
        $errors[] = 'Введите имя аккаунта!';
    }
    if (trim($data['phone']) == '')
    {
        $errors[] = 'Введите номер телефона!';
    }
    if(R::count('users', 'login = ?', array($data['login'])) > 0)
    {
        $errors[] = "Логин занят!";
    }
    if(R::count('users', 'email = ?', array($data['email'])) > 0)
    {
        $errors[] = "Почта занята!";
    }
    if( empty($errors))
    {
        $_SESSION["login"] = $_POST["login"];
        $_SESSION["phone"] = $_POST["phone"];
    }
}

if (isset($data['do_reg']))
{
if (trim($data['email']) == '')
{
    $errors[] = 'Введите почту!';
}
if (trim($data['name']) == '')
{
    $errors[] = 'Введите имя!';
}
if (trim($data['password']) == '')
{
    $errors[] = 'Введите пароль!';
}
if (strlen($data['password']) < 6){
    $errors[] = 'Пароль слишком короткий!';
}
if (strlen($data['password']) > 30){
    $errors[] = 'Пароль слишком длинный!';
}
if(R::count('users', 'email = ?', array($data['email'])) > 0)
{
    $errors[] = "Почта занята!";
}
if( empty($errors))
{
$_SESSION["name"] = $_POST["name"];
$_SESSION["email"] = $_POST["email"];
$_SESSION["password"] = $_POST["password"];
} else
{
    
}
}


if(isset($_POST["sub_email"])){
    if(isset($_SESSION["name"]) AND isset($_SESSION["email"]) AND isset($_SESSION["password"])){
        if(isset($_SESSION["login"]) AND isset($_SESSION["phone"])){
            if(R::count('users', 'email = ?', array($_SESSION['email'])) < 1){
            $usr = R::dispense("users");
            $usr->name = $_SESSION["name"];
            $usr->login = $_SESSION["login"];
            $usr->email = $_SESSION["email"];
            $usr->sub_email = $_POST["sub_email"];
            $usr->password =  password_hash($_SESSION["password"], PASSWORD_DEFAULT);
            $usr->phone = $_SESSION["phone"];
            R::store($usr);
            unset($_SESSION["login"]);
            unset($_SESSION["email"]);
            unset($_SESSION["phone"]);
            unset($_SESSION["name"]);
            unset($_SESSION["password"]);
            header("Location: /scripts/login-reg.php?reg=true");
        }else{
            $errors[0] = "Пользователь с почтой ".$_SESSION["email"] ." уже зарегистрирован =(";
        }
    }
    }
}


$stage = 1;
if(isset($_SESSION["name"]) AND isset($_SESSION["email"]) AND isset($_SESSION["password"])){
    if(isset($_SESSION["login"]) AND isset($_SESSION["phone"])){
        $stage = 3;
    }else{
        $stage = 2;
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


<form class="box" action="/scripts/signup-log.php" method="post">
<?if($stage == 3){?>
    <h1>Регистрация завершена.<br>
Подпишитесь на наши новости.</h1>
<?}else{?>
<h1>Добро пожаловать в CRM.<br>
Войдите, чтобы начать работу</h1>
<?
}
if(!isset($errors)){
?>
<p id="ent">Enter your details to proceed further</p>
<?}else{
?>
<p id="ent"><?echo($errors[0])?></p>
<?
}?>

<?
//1 стадия
if($stage == 1){?>
<p class="for">Полное имя</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text" name="name" placeholder="Start typing…" value="<?php echo @$data['name']?>">
  <img src="/iconz/email.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
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
  <div><label for="remember"><input type="checkbox" name="policy" id="remember" style="margin-top:0px;" required checked><span class="remember"> Я согласен с <a href="/privacy-policy.html" style="text-decoration:none;color:#5E81F4;">правилами & соглашениями</a></label></div>
</div>
  <input type="submit"name="do_reg"value="Регистрация"  class="sub_br" style="margin-top:30px;">
  <input type="submit"name="redirect"value="Вход"  class="sub_nbr">

  <?

//Вторая стадия
}elseif($stage == 2){?>
    <p class="for">Имя аккаунта</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text" name="login" placeholder="Start typing…" value="<?php echo @$data['login']?>">
  <img src="/iconz/login.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
  <p class="for">Количество портфелей</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text"placeholder="Start typing…" ">
  <img src="/iconz/bags.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
  <p class="for">Ваш статус</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text"  placeholder="Start typing…">
  <img src="/iconz/down.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
<p class="for">Номер телефона</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text" name="phone" placeholder="Start typing…" value="<?php echo @$data['phone']?>">
  <img src="/iconz/phone.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
  <div style="display:flex; margin-top:30px;">
</div>
  <input type="submit"name="do_reg1"value="Далее"  class="sub_br" style="margin-top:30px;">
  <input type="submit"name="reset"value="Отмена"  class="sub_nbr">

<?}elseif($stage == 3){?>
    <p class="for">Email</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="text" name="sub_email" placeholder="Start typing…" value="<?php echo @$data['email']?>">
  <img src="/iconz/email.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>
  <input type="submit"name="do_reg2"value="Далее"  class="sub_br" style="margin-top:30px;">


    <?}?>
    </form>
</div>
</div>
<div>
    <?if($stage == 1){?>
    <img src="/iconz/signup.png" class="img">
    <?}elseif($stage == 2){?>
        <img src="/iconz/signup_2.png" style=" width:50% !important;"class="img">
    <?}elseif($stage == 3){?>
        <img src="/iconz/news.png" style=" width:50% !important;"class="img">
    <?}?>
</div>

</body>
</html>

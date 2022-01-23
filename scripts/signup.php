<?php
require "db.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" cotent="height=device-height">
    <title>َСайт</title>
    <link rel="stylesheet" href="/css/signup.css">
  </head>
<?php
$data = $_POST;
if (isset($data['do_signup']))
{
if (trim($data['email']) == '')
{
    $errors[] = 'Введите почту!';
}
if (trim($data['password']) == '')
{
    $errors[] = 'Введите пароль!';
}
if (trim($data['password_2']) != $data['password'])
{
    $errors[] = 'Пароли не совпадают!';
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
//регаем
$user = R::dispense('users');
$user->email = $data['email'];
$user->login = $data['login'];
$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
R::store($user);
echo '<div id="success" >'.'Вы успешно зарегистрированы'.'</div><hr>';
} else
{
    echo '<div id="errors">'.array_shift($errors).'</div><hr>';
}
}
?>

  <body>

<form class="box" action="/scripts/signup.php" method="POST">
<h1>Регистрация</h1>
   <input type="email" name="email" placeholder="Почта" value="<?php echo @$data['email']?>">
   <input type="password" name="password" placeholder="Пароль">
   <input type="password" name="password_2" placeholder="Подтвердите пароль">
   <input type="submit" name="do_signup" value="Зарегистрироваться">
   <p id="msg">Уже в системе?  <a href="login.php" id="link">Войти</a></p>
</form>
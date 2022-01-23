<?php
require "db.php";
$data = $_POST;
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
    echo '<div id="errors"">'.array_shift($errors).'</div><hr>';
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>َСайт</title>
    <link rel="stylesheet" href="/css/login.css">
    <script src="https://kit.fontawesome.com/d45622d32e.js" crossorigin="anonymous"></script>
  </head>
  <body>

<form class="box" action="/scripts/login.php" method="post">
  <h1>Авторизация</h1>
  <input type="email" name="email" placeholder="Почта" value="<?php echo @$data['email']?>">
  <input type="password" name="password" placeholder="Пароль">
  <div><label for="remember"><input type="checkbox" name="remember" id="remember" checked><span class="remember" style="color:white;"> Запомнить меня</label></div>
  <input type="submit" name="do_login" value="Войти">
  <p id="msg">Нет аккаунта?  <a href="signup.php" id="link">Зарегистрироваться</a></p>
</form>


  </body>
</html>

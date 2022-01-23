<!--СЕКЦИЯ функций, до вывода кода-->
<?
$pagename = "Главная";
$main = True;
require "scripts/db.php";
if(isset($user)){
require "sidebar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="css/main.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/include.js"></script>
<link rel="stylesheet" href="/css/metro-dark.css">
<!-- load jQuery and tablesorter scripts -->
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>

</head>
<body>
  

<!--СЕКЦИЯ кода, который будет выведен-->
<div class="body">
    <!--Верхняя секция кода, который будет выведен-->
    <div class="top_section">
        <!--График-->
        <div class="graphic">


        </div>
        <!--SEO-->
        <div class="seo">
          <div class="top_text">
            <p class="main_text">SEO портфель</p>
            <div class="border_r">
              <img src="iconz/pen.svg" class="icc">
            </div>
          </div>  
          <div>
            <table>
              <thead>
              <th>SEO</th>
              <th>Продажи</th>
              </thead>
              <tr id="row_1st"><td class="tab_1_row">Marketing</td><td class="tab_2_row">120</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">112</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">100</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">89</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">34</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">15</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">3</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">1</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">1</td></tr>
              <tr><td class="tab_1_row">Marketing</td><td class="tab_2_row">1</td></tr>

            </table>
          </div>
        </div>
        <!--SEO-->
        <div class="bal_sub_ach">
          <div class="bal">
            <div class="left_texxt">
              <p class="bal_top_text">Баланс</p>
              <p class="bal_bot_text">$1.870</p>
            </div>
            <div class="right_ico">
            <div class="cii_background" style="background: linear-gradient(0deg, rgba(150, 152, 214, 0.1), rgba(150, 152, 214, 0.1)), #FFFFFF;">
                <img src="iconz/wallet.svg" class="cii">
              </div>
            </div>
          </div>
          <div class="sub">
            <div class="left_texxt">
              <p class="bal_top_text">Подписка статус</p>
              <p class="bal_bot_text">осталось 20 дней</p>
            </div>
            <div class="right_ico">
              <div class="cii_background" style="background: linear-gradient(0deg, rgba(244, 190, 94, 0.1), rgba(244, 190, 94, 0.1)), #FFFFFF;">
                <img src="iconz/sub.svg" class="cii">
              </div>
            </div>
          </div>
          <div class="ach">
            <div class="left_texxt">
              <p class="bal_top_text">Ачивки</p>
              <div class="achievement_background">
              <img src="iconz/diamond.svg" class="achievement">
              </div>
            </div>
          </div>

        </div>

    </div>
    <!--Нижняя секция кода, который будет выведен-->
    <div class="bottom_section">
        <!--Поиск ниш-->
        <div class="research">
          <div class="top_text">
            <p class="main_text">Поиск ниш (free version)</p>
            <div class="border_r">
              <img src="iconz/explore.svg" class="icc">
            </div>
          </div>
          <?require("scripts/table.php");?>

        </div>
        <!--Проверка на очепятки-->
        <div class="mistakes">
        <div class="top_text">
            <p class="main_text">Проверка на грамматику</p>
            <div class="border_r">
              <img src="iconz/pen.svg" class="icc">
            </div>
        </div>  
          <div style="padding-left:26px;padding-right:26px;">
            <hr class="her" style="margin-bottom:15px;">
            <form method="post" action="" id="chat-form" onsubmit="return getContent()">
              <textarea id="my-textarea"name="story" style="display:none"></textarea>
              <div id="my-content"  style="width:100%; height:180px; overflow-y:scroll;" contenteditable="true">
              </div>
              <hr class="her" id="hr_bottom">
              <input type="submit" id="button_sub" value="Искать">
            </form>
        </div>

    </div>
</div>







</body>
</html>
</section>
<!--СЕКЦИЯ JS кода-->
<script>
    let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");


closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
});
    function getContent(){
        document.getElementById("my-textarea").value = document.getElementById("my-content").innerHTML;
    }




    var interval = null; //Переменная с интервалом подгрузки сообщений
var sendForm = document.getElementById('chat-form'); //Форма отправки
var messageInput = document.getElementById('my-content'); //Инпут для текста сообщения
function send_request(act, login = null, password = null) {//Основная функция
  var messages__container = document.getElementById('my-content'); 
	//Переменные, которые будут отправляться
	var var1 = null;
	var var2 = null;

if(act == 'auth') {
		//Если нужно авторизоваться, получаем логин и пароль, которые были переданы в функцию
		var1 = login;
		var2 = password;
	} else if(act == 'send') {
//Если нужно отправить сообщение, то получаем текст из поля ввода
		var1 = messageInput.value;
	}//Отправляем перемнніе в chat.php через post
  $.post('scripts/words.php',{
	var1: messages__container.innerHTML
}).done(function (data) {
	messages__container.innerHTML = data;

});
}
function update() {
	send_request('load');
}

sendForm.onsubmit = function () {
  if(messageInput.value != ""){
	send_request('send');
  }

	return false; //Возвращаем ложь, чтобы остановить классическую отправку формы

};



</script> 


</body>
</html>
<?}else{?>
<?header("Location: /scripts/login-reg.php");?>
<?}?>




<??>
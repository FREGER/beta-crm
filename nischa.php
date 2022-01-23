<link rel="stylesheet" href="/fonts/lato/lato.css">
<? require "scripts/db.php";

function strposa($haystack, $needles=array(), $offset=0) {
    $chr = array();
    foreach($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false){ $chr[$needle] = $res;}
            else{
                return false;
            }
    }
    if(empty($chr)) return false;
    return min($chr);
}

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
if($_GET["type"]=="vector"){
    $_SESSION["type"] = "vector";
    header("Location: ?");

}
if($_GET["type"]=="photo"){
    $_SESSION["type"] = "photo";
    header("Location: ?");
}

function isInArray($haystack, $needle){
    $hey = 0;
foreach ($haystack as $onn){
    if(startsWith($onn["searchterm"], $needle)){

        if($onn["searchterm"] != $needle){
            $hey=12;
            return true;
        }
    }
}


if($hey == 12){
    return true;
}
else{
    return false;
}
}
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
$data = $_POST;
function removeqsvar($url, $varname)
{
    return preg_replace('/([?&])' . $varname . '=[^&]+(&|$)/', '$1', $url);
}
if (isset($_GET["toggle"]) )
{
    
    $two = R::findAll("shutterstock_photo");

    $one = R::findAll("shutterstock_vector_sale");

    if($_SESSION["type"] == "vector" AND isInArray($one, $_GET["toggle"]) OR $_SESSION["type"] != "vector" AND isInArray($two, $_GET["toggle"])){
    if (!isset($_SESSION["arr"]))
    {
        $_SESSION["arr"] = [];
    }
    $check = 0;
    $o = 0;

    foreach ($_SESSION["arr"] as $key => $arr1)
    {
        if ($arr1 == $_GET["toggle"])
        {
            $check = 1;
            unset($_SESSION["arr"][$key]);
            $o++;

        }
    }
    if ($check == 0)
    {
        array_push($_SESSION["arr"], $_GET["toggle"]);
    }
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    header("Location: " . removeqsvar($actual_link, "toggle"));
}
else{
    ?><script>window.alert("Coming soon!");
    window.location.replace("/nischa.php");</script>
    <?
}
}
if($_GET["coming"] == "soon"){
    ?><script>window.alert("Coming soon!");
                window.location.replace("?coming=late");
    </script><?
}
if (isset($data["hidden"]))
{
    $val = R::findOne("shuttersale", "search_iterm = ? AND user_id = ?", [$data["hidden"], $user["id"]]);

    $val->bought = TRUE;
    R::store($val);
}
$pagename = "Исследования / <span style='font-weight:400;'>Поиск Ниш</span>";
$nischa = True;
if (isset($user))
{
    require "sidebar.php";
    $data = $_POST;
    if (isset($data["dates_submit"]))
    {
        setcookie("first_date", $data["first_date"], time() + 3600);
        setcookie("last_date", $data["last_date"], time() + 3600);
        header("Location: #");
    }
    if (isset($_GET["time"]))
    {
        $now = strtotime("now");
        if ($_GET["time"] == "6_m")
        {
            $then = strtotime("6 months ago");

            setcookie("first_date", date("Y-m-d", $then) , time() + 3600);
            setcookie("last_date", date("Y-m-d") , time() + 3600);
        }
        elseif ($_GET["time"] == "1_y")
        {
            $then = strtotime("1 year ago");
            setcookie("first_date", date("Y-m-d", $then) , time() + 3600);
            setcookie("last_date", date("Y-m-d") , time() + 3600);
        }
        elseif ($_GET["time"] == "2_y")
        {
            $then = strtotime("2 years ago");
            setcookie("first_date", date("Y-m-d", $then) , time() + 3600);
            setcookie("last_date", date("Y-m-d") , time() + 3600);
        }
        elseif ($_GET["time"] == "3_y")
        {
            $then = strtotime("3 years ago");
            setcookie("first_date", date("Y-m-d", $then) , time() + 3600);
            setcookie("last_date", date("Y-m-d") , time() + 3600);
        }
        header("Location: /");
    }
    if (!function_exists('str_contains'))
    {
        function str_contains($haystack, $needle)
        {
            return $needle !== '' && mb_strpos($haystack, $needle) !== false;
        }
    }
    if (isset($data["search"]))
    {
        $words_array = explode(",", $data["search"]);

        foreach ($words_array as $words_one)
        {

            $words_one = trim($words_one);
            $b = explode(' ', $words_one);
            
            $w_count = 0;
            foreach ($b as $wwword){
                $xx=R::findOne("All_words_without_mistake", "word = ?", array($wwword) );
                if($xx["id"] >  0){

                }else{
                    ?><a style="postition:absolute;"><?echo($xx["id"]);?></a><?
                    $w_count = 1 ;
                    $h = $xx;

                }
            }
            if ($w_count == 0)
            {
                if($_SESSION["type"] == "vector"){
                    $tabble = "shutterstock_vector_sale";
                }
                else{
                    $tabble = "shutterstock_photo";
                }
                if (R::count("shuttersale", "search_iterm = ? AND user_id = ?", array(
                    $words_one,
                    $user["id"]
                )) == 0)
                {
                    $disp = R::dispense('shuttersale');
                    $disp["userId"] = $user["id"];
                    $disp["bought"] = false;
                    $disp["searchIterm"] = $words_one;
                    if (R::findOne($tabble, "searchterm LIKE ?", array(
                        $words_one . '%'
                    )) != "")
                    {
                        R::store($disp);
                    }
                    else
                    {
                        echo ("Пока что нет данных по слову <strong>" . $words_one . "</strong> <br>");
                    }
                }
            }
            else
            {
                if($words_one != ""){
                echo ("Вы, скорее всего, написали слово <strong>" . $words_one . "</strong> с ошибкой<br>");
                }
            }

        }
    }

    $i = 0;

?>

<!-- choose a theme file -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="js/include.js"></script>
<link rel="stylesheet" href="/css/metro-dark.css">
<!-- load jQuery and tablesorter scripts -->
<!-- tablesorter widgets (optional) -->
<script type="text/javascript" src="js/jquery.tablesorter.widgets.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/css/search.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вкладка 0</title>
</head>
<body>
</body>
</html>


<!--<div style="text-align:center; margin-top:20px;"><strong>Что искали другие пользователи(а точнее,что есть в базе данных):</strong><p>Фото: sport, nature, mountain, christmas, dark, silhouette, star <br> Вектор: money, game, fruit, home boy</p></div>-->
<div class="total">
<div class="table_search">

    <div class="table_head">


    <div class="search">
    <form method="POST" action="#" class="box">
<input type="text" name="search" placeholder="Ваше слово"></td>
<img src="/iconz/search.svg" class="iconcc">
     <input type="submit" name="do_search" value="Поиск" style="width:100px; margin-left:6px;">
</form>

    </div>


    <div id="photo_vector">
    <a href="?type=vector"><div id="vector_ic"class="icoonc <?if($_SESSION["type"] != "vector"){echo("imgnothere");}else{echo("imghere");}?>">Вектор</div></a>
    <a href="?type=photo"><div id="photo_ic" class="icoonc <?if($_SESSION["type"] != "vector"){echo("imghere");}else{echo("imgnothere");}?>">Фото</div></a>

    </div>
    </div>
    <table id="table" class="tablesorter table table-striped table-bordered table-sm">
         <thead> <tr>    
           <th class="name">Слово</th> 
            <th>Доход в $ с 2012</th>         
            <th class="tablesorter-headerDesc tablesorter-headerAsc">Доход в $ за 2019</th>
             <th>Доход в $ за 2020</th>
          <th>Доход в $ за 2021</th>
           <th>Количество файлов</th> 
           <th>Коэффициент</th> 
           </tr> </thead>
           <tbody>


<?




/**Цикл таблицы */



$count_table = 0;

    $all_searches = R::find("shuttersale", "user_id = :userid
    ORDER BY :search_iterm
     ", array(
        ":search_iterm"=>":search_iterm",
        ":userid"=>$user["id"]
    ));
    foreach ($all_searches as $all_s)
    {
        
        if($_SESSION["type"] == "vector"){
            $tabble = "shutterstock_vector_sale";
        }
        else{
            $tabble = "shutterstock_photo";
        }
        if(R::findOne($tabble,"searchterm = ?", array($all_s["search_iterm"]))){
        $words_table = R::findOne($tabble, "searchterm = ?", [$all_s["search_iterm"]]);
        $count_table++;
        ?>
        

              
<div class="modal" id="modal-<?echo(str_replace(' ', '_',$words_table->searchterm));?>">
  <div class="modal-sandbox"></div>
  <div class="modal-box">

    <div class="modal-body">

<div style="display:flex;">
    <div style="width:20px;height:20px;background: #F0F0F3;
border-radius: 100px;"></div>
    <p class="p4">Уведомление</p>

</div>
      <div style="padding:0px 28px;">

      <p class="p3">Уважаемый пользователь!</p>
      <p class="p2">В разделе Поиск ниш, вы можете разблокировать интересующие вас запросы и получить по ним дополнительную информацию:</p>
<br>
      <p class="p1">
- сумму доходов в запросах файлов, созданных за последние 3 года,<br>
- топ50 SEO по запросу с указанием точной суммы доходов за последние 3 года, по каждому из запросов следующего уровня<br>
- референсы внутри каждого из запросов, основанные на топ продаж внутри ниши.<br>
<br>
Стоимость разблокировки одного запроса составляет 10$ <br>
<br>
Данная сумма будет списана с баланса аккаунта.
</p>
      <br />
      </div>
      <div style="display:flex;">
      <button class="close-modal"><p>Закрыть</p></button>
      <form method="post" action="#" >
        <input type="hidden" name="hidden" value="<? echo ($words_table->searchterm) ?>">
        <input type="submit" class="unlock" value="Разблокировать" style="margin-left:100px;"> </form>
    </div></div>
  </div>
</div>

        
        
        <tr id="content">    
          <td class="name"><?
        if ($all_s["bought"] == true)
        {
            ?><a style="text-decoration:none;color: #8181A5;" href="?toggle=<? echo ($words_table->searchterm) ?>"><? echo ($words_table->searchterm);?></a><?
?> <i style="float:right;margin-right:10px;">
            <a href="?ref=<?echo($words_table->searchterm);?>"><img src="/iconz/level.svg" class="icocc"></i></a>  <?
        }
        else
        {
?>
        <a style="text-decoration:none;color: #8181A5;"><? echo ($words_table->searchterm);?></a>
        <a href="?buy=<?echo($words_table->searchterm);?>" class="modal-trigger" data-modal="modal-<?echo(str_replace(' ', '_',$words_table->searchterm));?>"> <img src="iconz/plus.svg" class="ico" width="25px" height="22px"></a> 

             <?

        } ?></td>  
        <?
        $fg = false;
        foreach(R::find("shuttersale", "bought = ? AND user_id = ?", array(1, $user["id"])) as $bhgt){
            if(startsWith( trim($words_table->searchterm), $bhgt["search_iterm"])){
                $fg = true;
            }
        }
        ?>
        <td>$<? echo ($words_table->summ_all); ?></td>   
        <td><?if ($all_s["bought"] == true OR $fg)
        { echo ("$".$words_table->summ_19); }else{
            echo ("Появится когда будет оплачено");
        }
        ?></td> 
                <td><?if ($all_s["bought"] == true OR $fg)
        { echo ("$".$words_table->summ_20); }else{
            echo ("Появится когда будет оплачено");
        }
        ?></td> 
                <td><?if ($all_s["bought"] == true OR $fg)
        { echo ("$".$words_table->summ_21); }else{
            echo ("Появится когда будет оплачено");
        }
        ?></td> 
        <td><? echo ($words_table->count_photo + $words_table->count_video); ?></td>  
        <td style="width:150px; display:flex;">0.05 <div class="wait">Ждать</div> </td>  </tr>
        <div style="background:saddlebrown;">
<?

        $hhh = 0;
        if (isset(($_SESSION["arr"])))
        {
            foreach ($_SESSION["arr"] as $arr)
            {
                if ($arr == $words_table->searchterm)
                {

                    $bean = $all_s;
                    if($_SESSION["type"] == "vector"){
                        $tabble = "shutterstock_vector_sale";
                    }
                    else{
                        $tabble = "shutterstock_photo";
                    }
                    $boomer = R::findAll($tabble);
                    foreach ($boomer as $boom)
                    {
                        if ($boom === false OR $hhh >= 100) break;
                        if (startsWith($boom["searchterm"], $bean["search_iterm"]) and $bean["search_iterm"] != $boom["searchterm"])
                        {
                            $hhh++;
              $count_table++;?>
              <tr class="layer">
                <td class="name" style="<? if ($hhh == 1) echo ("box-shadow: inset 0px 4px 4px #EFF3FE;"); ?>"><? echo ($boom["searchterm"]); ?><i style="float:right;margin-right:10px;"><a href="?ref=<?echo($boom["searchterm"]);?>"><img src="/iconz/level.svg" class="icocc"></a></i></td>
                <td>$<? echo ($boom["summ_all"]); ?></td>
                <td>$<? echo ($boom["summ_19"]); ?></td>
                <td>$<? echo ($boom["summ_20"]); ?></td>
                <td>$<? echo ($boom["summ_21"]); ?></td>
                <td><? echo ($boom["count_video"]); ?></td>
                <td style="display:flex;">0.05 <div class="wait">Ждать</div></td>
              </tr>
              <?
                        }
                    } ?>
        
<?
                }
            }
        }
?></div><?
    }} ?>

          </tbody>
</table>
<?if($count_table > 15){?>
<div class="pager" style="display:flex; position: absolute;
    bottom: 30px; width:100%;">
          <nav class="left">
<div class="b10">
        <label class="select " for="slct">Items per page:
          <select id="slct" class="pagesize" required="required">
          <option value="15" selected>15</option>
          <option value="30">30</option>
    </select>
    
    <svg>
        <use xlink:href="#select-arrow-down"></use>
    </svg></label><!-- SVG Sprites--><svg class="sprites">
    <symbol id="select-arrow-down" viewbox="0 0 10 6">
        <polyline points="1 1 5 5 9 1"></polyline>
    </symbol>
</svg>
</div>
          </nav>
          <nav class="right" style="margin-left:auto; margin-right:15px;">
            <span class="prev nextprev">
              <img src="iconz/prev.svg" />&nbsp;
            </span>
            <span class="pagecount">

            </span>
            &nbsp;<span class="next nextprev">
              <img src="iconz/next.svg" />
            </span>
          </nav>
        </div>
        
  <?}?>

<meta name="viewport" content="width=device-width, initial-scale=1">
</div>
<div class="mini_menu">
  <div id="menu_top">
<h4>Список слов</h4><i style="background: #F5F5FB;
border-radius: 6px;
padding-top:8px;
height:40px;
width:40px;
margin-left:20px;
"><img src="iconz/explore.svg" class="icc"></i>

</div>
<hr style="margin-top:10px;">
<div class="bottom_menu">
    <div>
  <?
  foreach( array_sort(R::findAll("shuttersale", "user_id = ?", array($user["id"])),"id" , SORT_DESC) as $word){
    ?><p style="font-family: Lato;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 21px;
    /* or 150% */
    
    
    /* Bg / #1C1D21 */
    
    color: #1C1D21;
    "><a class="no_dec"href="?toggle=<?echo $word["search_iterm"] ;?>"><?
echo($word["search_iterm"]."<br>");
  }
  ?></a></p><?
  ?>
  </div>
</div>
</div>
</div>
<?if(isset($_GET["ref"])){
    
    $a = explode(' ', $_GET["ref"]);
    ?>
<div class="gray"></div>

<div class="shadow">

    <div>
<a href="nischa.php"><img src="iconz/delete.png" width="30px" height="30px" style="margin-left:20px;margin-top:20px;margin-bottom:0px;filter: invert(51%) sepia(6%) saturate(1479%) hue-rotate(201deg) brightness(99%) contrast(96%);"></a>
    </div>
    <div class="yessir">
<?

        $h = 0;
        $lim = R::find("shutterstock_photo_word_search_result", "searchterm LIKE ? LIMIT 8000", array(urldecode($_GET["ref"])."%"));
        foreach($lim as $limm){
            $limm["number"] = strlen($limm["keys"]);
        }
        $number = array_column($lim, 'number');

        array_multisort($number, SORT_DESC, $lim);

        foreach ($lim as $binn)
        {

            if ($h < 10000)
            {
?><img src="<? echo ($binn["preview_ima"]); ?>"class="animal logo" height="100px"><?
                $h++;
            }

        }
        if($h==0){
            ?><script>window.location.replace("?coming=soon");


            </script><?
            
        }
        
?>
</div>
</div>
  <?  }?>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}


$(function(){

// initialize custom pager script BEFORE initializing tablesorter/tablesorter pager
// custom pager looks like this:
// 1 | 2 … 5 | 6 | 7 … 99 | 100
//   _       _   _        _     adjacentSpacer
//       _           _          distanceSpacer
// _____               ________ ends (2 default)
//         _________            aroundCurrent (1 default)

var $table = $('#table'),
  $pager = $('.pager');

$.tablesorter.customPagerControls({
  table          : $table,                   // point at correct table (string or jQuery object)
  pager          : $pager,                   // pager wrapper (string or jQuery object)
  pageSize       : '.left a',                // container for page sizes
  currentPage    : '.right a',               // container for page selectors
  ends           : 2,                        // number of pages to show of either end
  aroundCurrent  : 1,                        // number of pages surrounding the current page
  link           : '<a href="#">{page}</a>', // page element; use {page} to include the page number
  currentClass   : 'current',                // current page class name
  adjacentSpacer : '<span> | </span>',       // spacer for page numbers next to each other
  distanceSpacer : '<span> &#133; <span>',   // spacer for page numbers away from each other (ellipsis = &#133;)
  addKeyboard    : true,                     // use left,right,up,down,pageUp,pageDown,home, or end to change current page
  pageKeyStep    : 10                        // page step to use for pageUp and pageDown
});

// initialize tablesorter & pager
$table
  .tablesorter({
    theme: 'metro-dark',
    widgets: []
  })
  .tablesorterPager({
    // target the pager markup - see the HTML block below
    container: $pager,
    size: 10,
    output: 'showing: {startRow} to {endRow} ({filteredRows})'
  });

});
$('span:contains("|")').hide();

/*
===============================================================

Hi! Welcome to my little playground!

My name is Tobias Bogliolo. 'Open source' by default and always 'responsive',
I'm a publicist, visual designer and frontend developer based in Barcelona. 

Here you will find some of my personal experiments. Sometimes usefull,
sometimes simply for fun. You are free to use them for whatever you want 
but I would appreciate an attribution from my work. I hope you enjoy it.

===============================================================
*/




$(".modal-trigger").click(function(e){
  e.preventDefault();
  dataModal = $(this).attr("data-modal");
  $("#" + dataModal).css({"display":"block"});
  // $("body").css({"overflow-y": "hidden"}); //Prevent double scrollbar.
});

$(".close-modal, .modal-sandbox").click(function(){
  $(".modal").css({"display":"none"});
  // $("body").css({"overflow-y": "auto"}); //Prevent double scrollbar.
});

</script>
</section>



</body>
</html>
<script>
  $('span:contains("|")').hide();
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");


closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
});

$('.gray').click(function(){
   window.location.href='nischa.php';
})
</script>
<?
}
else
{
?>

<a href="scripts/login.php">Логин</a>
<a href="scripts/signup.php">Регистрация</a>
<?
}
?>




<??>
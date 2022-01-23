
<link rel="stylesheet" href="css/search.css">
<?
function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
$data = $_POST;
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
                $tabble = "shutterstock_photo";
            if (R::count("shutterfree", "search_iterm = ? AND user_id = ?", array(
                $words_one,
                $user["id"]
            )) == 0)
            {
                if(R::count("shutterfree", "user_id = ?", array(
                    $user["id"]
                )) < 4){
                $disp = R::dispense('shutterfree');
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
                    echo ("<span class='padd'>Пока что нет данных по слову <strong>" . $words_one . "</strong></span> <br>");
                }
            }else{
                echo ("<span class='padd'>Вы достигли максимального количества бесплатных слов</span><br>");
            }}
        }
        else
        {
            if($words_one != ""){
            echo ("<span class='padd'>Вы, скорее всего, написали слово <strong>" . $words_one . "</strong> с ошибкой</span><br>");
            }
        }

    }
}
?>


<div class="search">


    </div>
<table id="table" class="tablesorter table table-striped table-bordered table-sm">
         <thead> 
            <tr>    
           <th class="name">Слово</th> 
            <th>Доход в $ с 2012</th>         
           <th>Количество файлов</th> 
           <th>Коэффициент</th> 
           </tr> </thead>
           <tfoot> 
            <tr>    
           <td style="padding-left:26px;">
           <form method="POST" action="#" class="box">
            <input type="text" name="search" placeholder="Ваше слово"></td>
            
        
        
            </td> 
            <td>$</td>         
           <td>0</td> 
           <td>0.00 <input type="submit" name="do_search" value="Поиск" style="width:100px; margin-left:6px;"></form></td> 
           </tr> </tfoot>
           <tbody>


<?
/**Цикл таблицы */



$count_table = 0;

    $all_searches = R::find("shutterfree", "user_id = :userid
    ORDER BY :search_iterm LIMIT 6
     ", array(
        ":search_iterm"=>":search_iterm",
        ":userid"=>$user["id"]
    ));
    foreach ($all_searches as $all_s)
    {
        if(R::findOne("shutterstock_photo","searchterm = ?", array($all_s["search_iterm"]))){
        $words_table = R::findOne("shutterstock_photo", "searchterm = ?", [$all_s["search_iterm"]]);
        $count_table++;
        ?>
        <tr id="content">    
          <td class="name">
        <? echo ($words_table->searchterm);?>

             <?

         ?></td>  
        <?
        $fg = false;
        foreach(R::find("shutterfree", "bought = ? AND user_id = ?", array(1, $user["id"])) as $bhgt){
            if(startsWith( trim($words_table->searchterm), $bhgt["search_iterm"])){
                $fg = true;
            }
        }
        ?>
        <td>$<? echo ($words_table->summ_all); ?></td>   

        <td><? echo ($words_table->count_photo + $words_table->count_video); ?></td>  
        <td style="width:150px; display:flex;">0.05 <div class="wait">Ждать</div> </td>  </tr>
        <div style="background:saddlebrown;">
        </div><?
    }} ?>

          </tbody>
</table>
<script>


$(function(){


var $table = $('#table'),
  $pager = $('.pager');

// initialize tablesorter & pager
$table
  .tablesorter({
    theme: 'metro-dark',
    widgets: []
  })
});

</script>
<style>
thead th{
    font-size: 12px;
}
#name{
    padding-left: 26px !important;
    min-width:120px;
    max-width:180px;
}
.name{
    min-width:120px !important;
    max-width:180px;
}
tbody td{
    font-family: Lato;
font-style: normal;
font-weight: bold;
font-size: 14px;
line-height: 21px;
/* or 150% */


/* Bg / #1C1D21 */

color: #1C1D21;

}
.padd{
    padding-left:26px;
}
</style>
<?
require("db.php");
$text = $_POST['var1'];
$final = $text;
$final = str_replace("&nbsp;","", $final);
$final = str_replace("<div>","<br>", $final);
$final = str_replace("div>","", $final);
$final = str_replace('<span style="color:red;">',"", $final);
$final = str_replace("</span>","", $final);

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    return $length > 0 ? substr($haystack, -$length) === $needle : true;
}

$text = str_word_count($text, 1);
foreach($text as $piece){
    if(R::findOne("All_words_without_mistake", "word = ?", array(strtolower($piece)))["word"] == strtolower($piece)){
    }
    else{
        $final = preg_replace('/\b'.$piece.'\b/u',"<span style='color:red;'>".$piece."</span>", $final);
    }
}
if(endsWith($final, '</')){
    $final = substr($final, 0, -2);
}
echo($final);
?>
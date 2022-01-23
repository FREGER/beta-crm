<?php
require "rb.php";

date_default_timezone_set('Europe/Athens');

R::setup( 'mysql:host=localhost;dbname=freger_shutter',
        'freger_freger', 'freger77' );
session_start();
if(empty($_SESSION['logged_user'])){
    if ( !empty($_COOKIE['email']) and !empty($_COOKIE['key']) ) {
        $login = $_COOKIE['email']; 
        $key = $_COOKIE['key']; 
        $user2 = R::findOne('users','email = ?', array($login));
        if (trim($user2['password']) == $key){
            session_start();
            $_SESSION['logged_user'] = $user2;
        }
    }if(!empty($_SESSION["pass_gen"]) AND !empty($_SESSION["email"])){
        $login = $_SESSION["email"]; 
        $key = $_SESSION["pass_gen"]; 
        $user2 = R::findOne('users','email = ?', array($login));
        if (trim($user2['password']) == $key){
            session_start();
            $_SESSION['logged_user'] = $user2;
        }
    }
}
if($_SESSION['logged_user']->id != 0){
$user = $_SESSION['logged_user'];
}else{
    unset($_SESSION['logged_user']);
}
if ($user != ''){
    $userdb = R::load( 'users', $user->id );
}
if ($user != ''){
    if ($user != $userdb){
        $_SESSION['logged_user'] = $userdb;
        $user = $userdb;
    }
}
?>
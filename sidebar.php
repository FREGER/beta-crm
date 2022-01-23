<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i><img src="Logo.svg"class='bx bxl-c-plus-plus icon' class="logo"id="btn"><img src="betaCRM.svg"class='bx bxl-c-plus-plus logo_name'></i>
        <div class="logo_name"></div>
    </div>
    <ul class="nav-list">
      
      
      <li <?if($main){?>class="here"<?}?> >
        <div style="display:flex">

        <div style="width:97%;padding-right:12px;"style="">
        <a href="/index.php" >
          <i><img src="iconz/main.svg" class="icoc"></i>
          <span class="links_name">Главная</span>
        </a>
         <span class="tooltip">Главная</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>

      <li>
        <div style="display:flex">

        <div style="width:97%;padding-right:12px;"style="">
          <a href="#">
            <i><img src="iconz/bag.svg" class="icoc"></i>
             <span class="links_name">Потрфель</span>
           </a>
           <span class="tooltip">Потрфель</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>

      <li>
        <div style="display:flex"<?if($nischa){?>class="here"<?}?>>

        <div style="width:97%;padding-right:12px;"style="">
          <a href="/nischa.php">
            <i><img src="iconz/explore.svg" class="icoc"></i>
             <span class="links_name">Исследования</span>
           </a>
           <span class="tooltip">Исследования</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>

      <li >
        <div style="display:flex">

        <div style="width:97%;padding-right:12px;"style="">
          <a href="#">
            <i><img src="iconz/seo.svg" class="icoc"></i>
             <span class="links_name">Ключевание и SEO</span>
           </a>
           <span class="tooltip">Ключевание и SEO</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>

      <li>
        <div style="display:flex">

        <div style="width:97%;padding-right:12px;"style="">
          <a href="#">
            <i><img src="iconz/settings.svg" class="icoc"></i>
             <span class="links_name">Настройка</span>
           </a>
           <span class="tooltip">Настройка</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>

      <li>
        <div style="display:flex">

        <div style="width:97%;padding-right:12px;"style="">
          <a href="#">
            <i><img src="iconz/messages.svg" class="icoc"></i>
             <span class="links_name">Сообщения</span>
           </a>
           <span class="tooltip">Сообщения</span>
        </div>
        <div style="width:2px; height:50px; background-color: #5E81F4;  border-radius:10px;" class="line">

        </div>
      </div>
      </li>





     <li class="profile">
         <div class="profile-details">
           <img src="profile.jpg" alt="profileImg" class="img">
           <div class="name_job">
             <div class="name" style="width:120px;overflow:hidden"><?echo($user->email);?></div>
             <div class="job">Premium user</div>
           </div>
         </div>
         <a href="scripts/logout.php" style="width:0px;height:0px;"><i class='bx bx-log-out' id="log_out" ></i></a>
     </li>
    </ul>
</div>


  <section class="home-section" style="padding:0px 30px;">
  
    <div style="display:flex; padding-top:10px;">
    <div style="width:50%; display:flex;">
    
      <P style="font-style: normal;
font-weight: bold;
font-size: 20px;
line-height: 32px;
margin-top:12px;
margin-left:30px;"><?echo($pagename);?></P>

</div>
<div style="display:flex; justify-content: flex-end;
width:50%;">
<div class="change">Сменить план</div>
<i style="background: #F0F0F3;
padding:11px;
margin-top:10px;
border-radius: 6px;
padding-top:8px;
height:40px;
width:40px;
margin-left:20px;
"><img src="iconz/search.svg" class="top_imgs"></i>
<i style="background: #F0F0F3;
padding:11px;
margin-top:10px;
border-radius: 6px;
padding-top:8px;
height:40px;
width:40px;
margin-left:20px;
"><img src="iconz/plus.svg" class="top_imgs"></i>
</div>
      </div>
      







      <??>
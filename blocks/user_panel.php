<?php
//    echo "<pre>";
//    var_dump($Mess);
//    echo "</pre>";

//    if ($Mess == "Нет сообщений"){
//        $AnotherMess = "";
//    }
//    else{
//        $AnotherMess = "+1";
//    }


?>
<div class="stuff_menu">
    <div class="menu_ava">
            <img src="http://impovar.tt90.ru/img/avatars/<?php echo $_SESSION['ava']; ?>" class="ava_img_fullusart"><br>
    </div>
<!--<ul class="user_panel">-->
<!--    <li class="user_panel_li">-->
    <div class="menu_ava">
        <a href="http://impovar.tt90.ru/profile/<?php echo $_SESSION['user_id'];?>" class="user_panel_a">
            <?php echo ($_SESSION['user_name']);?>
        </a>
    </div>
<!--    </li>-->
<!--    <li class="user_panel_li">-->
    <div class="menu_ava">
        <a href="http://impovar.tt90.ru/logout" class="user_panel_exit">Выйти</a>
<!--    </li>-->
<!--</ul>-->
    </div>
</div>

<div class="wrapp_all_stuff">
    <div class="all_stuff">
        <a class="stuff_menu" id="stuff_menu_add" href="http://impovar.tt90.ru/addarticle/<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">разместить рецепт</span></div>
        </a>
        <a class="stuff_menu" id="stuff_menu_search" href="#">
            <div class="left_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">поиск по сайту</span></div>
        </a>
        <a class="stuff_menu_search_field" href="#" style="display: none;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="http://impovar.tt90.ru/search" class="navbar-form navbar-left" role="search">
                    <input type="text" name="search" placeholder="Поиск" id="form_search">
                    <button type="submit" id="search_button" name="search_submit" style="float: right;">Go!</button>
            </div>
            </form>
        </a>

        <a class="stuff_menu" href="http://impovar.tt90.ru/myanswers/<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-comment-o" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">мои ответы</span>
            </div>
        </a>
        <a class="stuff_menu" href="http://impovar.tt90.ru/messages/<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-user" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">сообщения</span></div>
        </a>
        <a class="stuff_menu" href="http://impovar.tt90.ru/settings/<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-cog" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">настройки</span></div>
        </a>
        <a class="stuff_menu" href="http://impovar.tt90.ru/allusers" style="margin-bottom: 20px;">
            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">пользователи</span></div>
        </a>
        <a class="stuff_menu" href="http://impovar.tt90.ru/forum" style="margin-bottom: 20px;">
            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">ФОРУМ</span></div>
        </a>
    </div>
</div>


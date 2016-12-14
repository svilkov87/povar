<?php
//    echo "<pre>";
//    var_dump($_SESSION);
//    echo "</pre>";

?>
<div class="stuff_menu">
<ul class="user_panel">
    <li class="user_panel_li">
        <a href="../profile.php?id=<?php echo $_SESSION['user_id'];?>" class="user_panel_a"><?php echo ($_SESSION['user_name']);?></a>
    </li>
    <li class="user_panel_li">
        <a href="blocks/logout.php" class="user_panel_a">Выйти</a>
    </li>
</ul>
</div>

<div class="wrapp_all_stuff">
    <div class="all_stuff">
        <a class="stuff_menu" id="stuff_menu_add" href="add_article.php?id=<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">разместить рецепт</span></div>
        </a>
        <a class="stuff_menu" id="stuff_menu_search" href="#">
            <div class="left_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">поиск по сайту</span></div>
        </a>
        <a class="stuff_menu_search_field" href="#" style="display: none;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form action="search.php" class="navbar-form navbar-left" role="search">
                    <input type="text" name="search" placeholder="Поиск" id="form_search">
                    <button type="submit" id="search_button" name="search_submit" style="float: right;">Go!</button>
            </div>
            </form>
        </a>

        <a class="stuff_menu" href="myanswers.php?id=<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-comment-o" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">мои ответы</span></div>
        </a>
        <a class="stuff_menu" href="../profile.php?id=<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-user" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">мой профиль</span></div>
        </a>
        <a class="stuff_menu" href="../settings.php?id=<?php echo $_SESSION['user_id'];?>">
            <div class="left_icon"><i class="fa fa-cog" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">настройки</span></div>
        </a>
        <a class="stuff_menu" href="../all_users.php" style="margin-bottom: 20px;">
            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">пользователи</span></div>
        </a>
        <a class="stuff_menu" href="../forum.php" style="margin-bottom: 20px;">
            <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
            <div class="right_info"><span class="span_left">ФОРУМ</span></div>
        </a>
    </div>
</div>


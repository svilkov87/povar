<?php
    //session_start();
    include("include/connection.php");
    //обработка ошибок
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);


    //проверка авторизации
    if (isset($_POST['enter'])) {
        $e_email = $_POST['e_email'];
        $e_password = md5($_POST['e_password']);
        $str = $pdo->prepare('SELECT * FROM `users` WHERE email=:email AND password=:password');
        $str->bindParam(":email", $e_email, PDO::PARAM_INT);
        $str->bindParam(":password", $e_password, PDO::PARAM_INT);
        $str->execute();
        $user_data = $str->fetch(PDO::FETCH_ASSOC);

    //    обращаемся к элементу массива id, которое получили при выборке из таблицы юзеров
        $user_id = $user_data["id"];
        $user_name = $user_data["username"];
        $user_ava = $user_data["ava"];

        if ($user_data['password'] == $e_password) {
            $_SESSION['email'] = $e_email;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['ava'] = $user_ava;
    //        если у юзера пока нет фото, стави дефолтное
            if ($user_ava == "") {
                $_SESSION['ava'] = "no_ava.png";
            }
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit;
        } else {
            $WorngAuthData = "Неверные данные";
        }
    }
    //    ##ответы к моим комментариям
    //    $stm = $pdo->prepare('SELECT isnew FROM `comments` WHERE user_id_art =:user_id_art AND isnew =1');
    //    $stm->bindParam(':user_id_art', $id, PDO::PARAM_INT);
    //    $stm->execute();
    //    $CommValueOne = $stm->fetchAll();

    $Message = array();

    $One = 1;
    $st = $pdo->prepare
    ('
    SELECT 
    COUNT(*) 
    FROM 
    `comments` 
    WHERE 
    isnew=:isnew 
    AND 
    user_id_art =:user_id_art
    ');
    $st->bindParam(':isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $ResultOfCount = $st->fetchAll();
    if ($ResultOfCount[0]['COUNT(*)'] > 0) {
        $Message[] = '<i class="fa fa-envelope-o" aria-hidden="true"></i>';
        $NumberMess = $ResultOfCount[0]['COUNT(*)'];
    } else {
        $Message[] = "Нет сообщений";
        $NumberMess = "0";
    }

    if ($_SERVER['REQUEST_URI'] == '/myanswers.php?id=' . $_SESSION['user_id'] . '' AND $ResultOfCount[0]['COUNT(*)'] > 0) {
        $NullValue = 0;
        $st = $pdo->prepare('UPDATE `comments` SET isnew=:isnew WHERE isnew=1 AND user_id_art =:user_id_art');
        $st->bindParam(':isnew', $NullValue, PDO::PARAM_INT);
        $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
        $st->execute();
    //        $Message[] = "No messages";
    }

    $Mess = array_shift($Message);
    //отладка
    //echo "<pre>";
    //var_dump($_SERVER['REQUEST_URI']);
    //echo "</pre>";

//    echo "<pre>";
//    var_dump($_SESSION['user_id']);
//    echo "</pre>";
//
//    echo "<pre>";
//    var_dump($id);
//    echo "</pre>";
    //
    //echo "<pre>";
    //var_dump($ResultOfCount);
    //echo "</pre>";

?>
<div class="nav">
    <div class="container">
        <div id="brand">
            <a href="http://impovar.tt90.ru/home" class="logo_link">GRANDPOVAR</a>
            <a href="http://impovar.tt90.ru/registration" class="registration_link">Регистрация</a>
        </div>
        <div id="fa-align">
            <?php
            if (isset($_SESSION['email'])):?>
                <span style="color: #fff;"><?php echo $Mess; ?></span>
                <i class="fa fa-circle" aria-hidden="true"></i>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            <?php else:
                ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            <?php endif; ?>
        </div>
        <div class="menu_open" style="display: none;">
            <div class="block_auth">
                <?php
                if (isset($_SESSION['email'])):
                    include("blocks/user_panel.php"); ?>
                <?php else: ?>
                    <div class="col-md-12" id="blocks_input">
                        <form method="POST" action="">
                            <input type="text" name="e_email" placeholder="Введите email" id="form_email">
                    </div>
                    <div class="col-md-12" id="blocks_input">
                        <input type="password" name="e_password" placeholder="Введите пароль" id="form_password">
                    </div>
                    <div class="col-md-12" id="blocks_input">
                        <div class="btn_forget">
                            <a href="http://impovar.tt90.ru/remindpass" class="button_forget_pass">Забыли пароль?</a>
                            <button type="submit" name="enter" id="button_enter">Войти</button>
                        </div>
                        </form>
                    </div>

                    <div class="wrapp_all_stuff">
                        <div class="all_stuff">
                            <a class="stuff_menu" id="stuff_menu_search" href="#">
                                <div class="left_icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                                <div class="right_info"><span class="span_left">поиск по сайту</span></div>
                            </a>
                            <a class="stuff_menu_search_field" href="#" style="display: none;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form action="search.php" class="navbar-form navbar-left" role="search">
                                        <input type="text" name="search" placeholder="Поиск" id="form_search">
                                        <button type="submit" id="search_button" name="search_submit"
                                                style="float: right;">Go!
                                        </button>
                                </div>
                                </form>
                            </a>

                            <a class="stuff_menu" href="http://impovar.tt90.ru/allusers" style="margin-bottom: 20px;">
                                <div class="left_icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                                <div class="right_info"><span class="span_left">пользователи</span></div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>




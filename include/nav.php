<?php
    include("include/connection.php");

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);



    $One = 1;
    //    считаем isnew
    $st = $pdo->prepare('SELECT COUNT(*) FROM `comments` WHERE count_isnew=:count_isnew AND user_id_art =:user_id_art');
    $st->bindParam(':count_isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $isNew = $st->fetchAll();
    if ($isNew[0]['COUNT(*)'] > 0 ) {

        $_SESSION['letter'] = ''.$isNew[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
        $_SESSION['count_message'] = $isNew[0]['COUNT(*)'];
}


    $st = $pdo->prepare('SELECT COUNT(*)FROM `comments` WHERE isnew=:isnew AND user_id_art =:user_id_art');
    $st->bindParam(':isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $ResultOfCount = $st->fetchAll();
if ($ResultOfCount[0]['COUNT(*)'] > 0 ) {

    $_SESSION['letter'] = ''.$ResultOfCount[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
    $_SESSION['count_message'] = $ResultOfCount[0]['COUNT(*)'];
    $NumberMess = $ResultOfCount[0]['COUNT(*)'];

//        уведомление на почту
//        $user_id_mail = $_SESSION['user_id'];
//        require_once("./phpmailer/phpmailer/mailfunc.php");
//        $m_to = $_SESSION['email']; // кому - ящик (из формы)
//        $m_nameto = ""; // Кому
//        $m_namefrom = "GRANDPOVAR"; // Поле От в письме
//        $subj = "Новый комментарий";
//        $tmsg = 'У Вас есть непрочитанные ответы. Проверьте ваш аккаунт.';
////        $tmsg = "У Вас есть непрочитанные ответы." .<a href="http://impovar.tt90.ru/myanswers/'.$user_id_mail.'">Прочитать</a>;
//        $m_from = 'svilkov00@yandex.ru'; // от ког
//        $m_reply = 'svilkov00@yandex.ru'; // адрес для обратного ответа
//        $mail1 = phpmailer($subj, $tmsg, $m_to, $m_nameto, $m_namefrom, $m_from, $m_reply, $m_hostmail, $m_port, $m_password, $m_secure);


    $NullValue = 0;
    $st = $pdo->prepare('UPDATE `comments` SET isnew=:isnew WHERE isnew=1 AND user_id_art =:user_id_art');
    $st->bindParam(':isnew', $NullValue, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();

//        $ResultOfCount[0]['COUNT(*)'] < 1
}


elseif($_SERVER['REQUEST_URI'] == '/myanswers/'. $_SESSION['user_id'] .'') {

    $NullValue = 0;
    $st = $pdo->prepare('UPDATE `comments` SET count_isnew=:count_isnew WHERE count_isnew=1 AND user_id_art =:user_id_art');
    $st->bindParam(':count_isnew', $NullValue, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();

    unset($_SESSION['count_message']);
    $_SESSION["letter"] = "Нет уведомлений";
    $NumberMess = "0";
}


##отправка личного сообщения

$OneNewMess =1;
$_SESSION['id_of_talk'] = substr(time(), 0, 6);
if (isset($_POST['enter_message'])) {
    $to_us = $_POST['id_to_user'];
    $text_mess = $_POST['text_to_user'];
    $insert = $pdo->prepare("
            INSERT INTO 
            `messages` 
            SET 
            isnew=:isnew,
            count_isnew=:count_isnew,
            text=:text, 
            from_us=:from_us, 
            from_us_name=:from_us_name, 
            id_of_talk=:id_of_talk, 
            to_us=:to_us
            ");
    $insert->bindParam(':isnew', $OneNewMess);
    $insert->bindParam(':count_isnew', $OneNewMess);
    $insert->bindParam(':from_us', $_SESSION['user_id']);
    $insert->bindParam(':to_us', $to_us);
    $insert->bindParam(':text', $text_mess);
    $insert->bindParam(':from_us_name', $_SESSION['user_name']);
    $insert->bindParam(':id_of_talk', $_SESSION['id_of_talk']);
    $insert->execute();
    unset($_SESSION['id_of_talk']);
//    header("Location: http://impovar.tt90.ru/profile/".$_SESSION["user_id"]);
//    exit();
}

    $One = 1;
    //    считаем count_isnew
    $st = $pdo->prepare('SELECT COUNT(*) FROM `messages` WHERE count_isnew=:count_isnew AND to_us =:to_us');
    $st->bindParam(':count_isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $MCisNew = $st->fetchAll();
    if ($MCisNew[0]['COUNT(*)'] > 0 ) {

        $_SESSION['message'] = ''.$MCisNew[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
        $_SESSION['count_mess'] = $MCisNew[0]['COUNT(*)'];
        //        $SummaryMess = $Message[0]['COUNT(*)'];
    }

//    Считаем coобщения
        $st = $pdo->prepare('SELECT COUNT(*) FROM `messages` WHERE isnew=:isnew AND to_us =:to_us');
        $st->bindParam(':isnew', $One, PDO::PARAM_INT);
        $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
        $st->execute();
        $Message = $st->fetchAll();
    if ($Message[0]['COUNT(*)'] > 0 ) {

    $_SESSION['message'] = ''.$Message[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
    $_SESSION['count_mess'] = $Message[0]['COUNT(*)'];
    $SummaryMess = $Message[0]['COUNT(*)'];

//        уведомление на почту
//    $user_id_mail = $_SESSION['user_id'];
//    require_once("./phpmailer/phpmailer/mailfunc.php");
//    $m_to = $_SESSION['email']; // кому - ящик (из формы)
//    $m_nameto = ""; // Кому
//    $m_namefrom = "GRANDPOVAR"; // Поле От в письме
//    $subj = "Новый комментарий";
//    $tmsg = 'У Вас есть непрочитанные ответы. Проверьте ваш аккаунт.';
//    $m_from = 'svilkov00@yandex.ru'; // от ког
//    $m_reply = 'svilkov00@yandex.ru'; // адрес для обратного ответа
//    $mail1 = phpmailer($subj, $tmsg, $m_to, $m_nameto, $m_namefrom, $m_from, $m_reply, $m_hostmail, $m_port, $m_password, $m_secure);

    $NullValue = 0;
    $st = $pdo->prepare('UPDATE `messages` SET isnew=:isnew WHERE isnew=1 AND to_us =:to_us');
    $st->bindParam(':isnew', $NullValue, PDO::PARAM_INT);
    $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    }

    elseif($_SERVER['REQUEST_URI'] == '/messages/'. $_SESSION['user_id'] .'') {

        $NullValue = 0;
        $st = $pdo->prepare('UPDATE `messages` SET count_isnew=:count_isnew WHERE count_isnew=1 AND to_us =:to_us');
        $st->bindParam(':count_isnew', $NullValue, PDO::PARAM_INT);
        $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
        $st->execute();

        unset($_SESSION['count_mess']);
        $_SESSION["message"] = "Нет сообщений";
        $SummaryMess = "0";
    }

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
//            $_SESSION['letter'] = "нет сообщений";

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

//отладка
//    echo "<pre>";
//    var_dump($ResultOfCount);
//    echo "</pre>";

    echo "<pre>";
    var_dump($_SESSION['id_of_talk']);
    echo "</pre>";
//
//    echo "<pre>";
//    var_dump($_SESSION['user_id']);
//    echo "</pre>";

//    echo "<pre>";
//    var_dump($Message);
//    echo "</pre>";

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

                <span style="color: #fff;"><?php echo $_SESSION['message']; ?>
                <span style="color: #fff;"><?php echo $_SESSION['letter']; ?></span>
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
                                    <form action="http://impovar.tt90.ru/search" class="navbar-form navbar-left" role="search">
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




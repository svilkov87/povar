<?php
    include("include/connection.php");

//    error_reporting(E_ALL | E_STRICT);
//    ini_set('display_errors', TRUE);
//    ini_set('display_startup_errors', TRUE);

    $One = 1;
    //    считаем isnew
    $st = $pdo->prepare('SELECT COUNT(*) FROM `comments` WHERE 
    count_isnew=:count_isnew 
    AND 
    user_id_art =:user_id_art
    ');
    $st->bindParam(':count_isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $isNew = $st->fetchAll();
    if ($isNew[0]['COUNT(*)'] == 0 ) {

//        $_SESSION['letter'] = ''.$isNew[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
//        $_SESSION['count_message'] = $isNew[0]['COUNT(*)'];
}


    $st = $pdo->prepare('SELECT COUNT(*)FROM `comments` WHERE isnew=:isnew AND user_id_art =:user_id_art');
    $st->bindParam(':isnew', $One, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
    $ResultOfCount = $st->fetchAll();
if ($ResultOfCount[0]['COUNT(*)'] > 0 ) {

    $_SESSION['letter'] = ''.$ResultOfCount[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
    $_SESSION['count_message'] = $ResultOfCount[0]['COUNT(*)'];
//    $NumberMess = $ResultOfCount[0]['COUNT(*)'];

//        уведомление на почту
//        $user_id_mail = $_SESSION['user_id'];
//        require_once("./phpmailer/phpmailer/mailfunc.php");
//        $m_to = $_SESSION['email']; // кому - ящик (из формы)
//        $m_nameto = ""; // Кому
//        $m_namefrom = "GRANDPOVAR"; // Поле От в письме
//        $subj = "Новый комментарий";
//        $tmsg = 'У Вас есть непрочитанные ответы. Проверьте ваш аккаунт.';
//        $m_from = 'svilkov00@yandex.ru'; // от ког
//        $m_reply = 'svilkov00@yandex.ru'; // адрес для обратного ответа
//        $mail1 = phpmailer($subj, $tmsg, $m_to, $m_nameto, $m_namefrom, $m_from, $m_reply, $m_hostmail, $m_port, $m_password, $m_secure);


    $NullValue = 0;
    $st = $pdo->prepare('UPDATE `comments` SET isnew=:isnew WHERE isnew=1 AND user_id_art =:user_id_art');
    $st->bindParam(':isnew', $NullValue, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();
}


elseif($_SERVER['REQUEST_URI'] == '/myanswers/'. $_SESSION['user_id'] .'') {

    $NullValue = 0;
    $st = $pdo->prepare('UPDATE `comments` SET count_isnew=:count_isnew WHERE count_isnew=1 AND user_id_art =:user_id_art');
    $st->bindParam(':count_isnew', $NullValue, PDO::PARAM_INT);
    $st->bindParam(':user_id_art', $_SESSION['user_id'], PDO::PARAM_INT);
    $st->execute();

    unset($_SESSION['count_message']);
    $_SESSION['letter'] = '0&nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
//    $_SESSION["letter"] = "Нет уведомлений";
//    $NumberMess = "0";
}


##отправка личного сообщения

//$OneNewMess =1;
//if (isset($_POST['enter_message'])) {
//    $to_us = $_POST['id_to_user'];
//    $text_mess = $_POST['text_to_user'];
//    $Dialog_id = $to_us * $_SESSION['user_id'];
//
//    //проверяем, есть ли уже диалог или его нужно создать впервые
////    $st = $pdo->prepare('SELECT from_us, to_us FROM `dialogs` WHERE from_us=:from_us, to_us=:to_us');
////    $st->bindParam(':from_us', $id, PDO::PARAM_INT);
////    $st->bindParam(':to_us', $id, PDO::PARAM_INT);
////    $st->execute();
////    $ExistEnty = $st->fetchAll();
//
//    $ExistEnty = $pdo->query('SELECT from_us, to_us FROM `dialogs` WHERE  from_us ='.$id.' OR to_us = '.$id.' ')->fetchAll();
//    ## Превращение одномерного массива в строку
//    $StringEntry = implode(',', $ExistEnty);
//
//    if ($ExistEnty == false){
//        //echo "нет такого диалога";
//
//
//    }
//
//
////    $insert = $pdo->prepare("
////            INSERT INTO
////            `messages`
////            SET
////            dialog_id=:dialog_id,
////            isnew=:isnew,
////            count_isnew=:count_isnew,
////            user_image=:user_image,
////            text=:text,
////            from_us=:from_us,
////            from_us_name=:from_us_name,
////            to_us=:to_us
////            ");
////    $insert->bindParam(':dialog_id', $Dialog_id);
////    $insert->bindParam(':isnew', $OneNewMess);
////    $insert->bindParam(':count_isnew', $OneNewMess);
////    $insert->bindParam(':user_image', $_SESSION['ava']);
////    $insert->bindParam(':from_us', $_SESSION['user_id']);
////    $insert->bindParam(':to_us', $to_us);
////    $insert->bindParam(':text', $text_mess);
////    $insert->bindParam(':from_us_name', $_SESSION['user_name']);
////    $insert->execute();
////    header("Location: http://impovar.tt90.ru/profile/".$_SESSION["user_id"]);
////    exit();
//
//    echo $ExistEnty;
//}

##уведомлене по новом сообщении
//    $One = 1;
//    //    считаем count_isnew
//    $st = $pdo->prepare('SELECT COUNT(*) FROM `messages` WHERE count_isnew=:count_isnew AND to_us =:to_us');
//    $st->bindParam(':count_isnew', $One, PDO::PARAM_INT);
//    $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
//    $st->execute();
//    $MCisNew = $st->fetchAll();
//    if ($MCisNew[0]['COUNT(*)'] == 0 ) {
//
//        $_SESSION['message'] = ''.$MCisNew[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
//        $_SESSION['count_mess'] = $MCisNew[0]['COUNT(*)'];
//        //        $SummaryMess = $Message[0]['COUNT(*)'];
//    }
//
////    Считаем coобщения
//        $st = $pdo->prepare('SELECT COUNT(*) FROM `messages` WHERE isnew=:isnew AND to_us =:to_us');
//        $st->bindParam(':isnew', $One, PDO::PARAM_INT);
//        $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
//        $st->execute();
//        $Message = $st->fetchAll();
//    if ($Message[0]['COUNT(*)'] > 0 ) {
//
//    $_SESSION['message'] = ''.$Message[0]['COUNT(*)'].' &nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
//    $_SESSION['count_mess'] = $Message[0]['COUNT(*)'];
//    $SummaryMess = $Message[0]['COUNT(*)'];
//
////        уведомление на почту
////    $user_id_mail = $_SESSION['user_id'];
////    require_once("./phpmailer/phpmailer/mailfunc.php");
////    $m_to = $_SESSION['email']; // кому - ящик (из формы)
////    $m_nameto = ""; // Кому
////    $m_namefrom = "GRANDPOVAR"; // Поле От в письме
////    $subj = "Новый комментарий";
////    $tmsg = 'У Вас есть непрочитанные ответы. Проверьте ваш аккаунт.';
////    $m_from = 'svilkov00@yandex.ru'; // от ког
////    $m_reply = 'svilkov00@yandex.ru'; // адрес для обратного ответа
////    $mail1 = phpmailer($subj, $tmsg, $m_to, $m_nameto, $m_namefrom, $m_from, $m_reply, $m_hostmail, $m_port, $m_password, $m_secure);
//
//    $NullValue = 0;
//    $st = $pdo->prepare('UPDATE `messages` SET isnew=:isnew WHERE isnew=1 AND to_us =:to_us');
//    $st->bindParam(':isnew', $NullValue, PDO::PARAM_INT);
//    $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
//    $st->execute();
//    }
//
//    elseif($_SERVER['REQUEST_URI'] == '/messages/'. $_SESSION['user_id'] .'') {
//
//        $NullValue = 0;
//        $st = $pdo->prepare('UPDATE `messages` SET count_isnew=:count_isnew WHERE count_isnew=1 AND to_us =:to_us');
//        $st->bindParam(':count_isnew', $NullValue, PDO::PARAM_INT);
//        $st->bindParam(':to_us', $_SESSION['user_id'], PDO::PARAM_INT);
//        $st->execute();
//
//        unset($_SESSION['count_mess']);
////        $_SESSION["message"] = "Нет сообщений";
//        $SummaryMess = "0";
//    }

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
        $_SESSION['letter'] = $isNew[0]['COUNT(*)'].'&nbsp;<i class="fa fa-envelope-o" aria-hidden="true"></i>';
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


    //Выбираем последние 2 статьи для отображения в фиксированном блоке
    $st = $pdo->query('SELECT * FROM `article` ORDER BY id DESC LIMIT 0, 2');
    $LastArtLimitTwo = $st->fetchAll();

    //Выбираем последние 4 коммента для отображения в фиксированном блоке
    $st = $pdo->query('SELECT * FROM `forum_questions` ORDER BY id DESC LIMIT 0, 4');
    $LastForumLimitTwo = $st->fetchAll();
//отладка

//    echo "<pre>";
//    var_dump($isNew);
//    echo "</pre>";
//    echo "<pre>";
//    var_dump($ResultOfCount);
//    echo "</pre>";
//
//    echo "<pre>";
//    var_dump($_SERVER['HTTP_REFERER']);
//    echo "</pre>";

?>
<div class="nav">
    <div class="container">
        <div id="brand">
            <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/home" class="logo_link">GRANDPOVAR</a>
        </div>

        <?php
        if (isset($_SESSION['email'])):?>
            <div class="fa-align">
                <span class="menu_ava">
                    <?php echo $_SESSION['letter']; ?>
                    <i class="fa fa-align-justify" id="justify_nav" aria-hidden="true"></i>
                    <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/profile/<?php echo $_SESSION['user_id']; ?>"
                       class="user_panel_a"><?php echo $_SESSION['user_name']; ?>
                        <span>
                        <img src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/img/avatars/<?php echo $_SESSION['ava']; ?>"
                             class="ava_img_nav">
                    </span>
                    </a>
                    <span>
                        <i class="fa fa-circle" aria-hidden="true"></i>
                    </span>
                </span>
            </div>
        <?php else: ?>
            <div class="fa-align">
                <a href="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/registration"
                   class="registration_link">Регистрация</a>
            </div>
        <?php endif; ?>
    </div>
</div>




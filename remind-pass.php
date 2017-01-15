<?php
include("functions/functions.php");
include("include/connection.php");

$email = $_POST['input_email'];

if (isset($_POST['input_email'])) {

    $errors = array();

    $newPassword = substr(md5(time()), 0, 6);
    $newPassMd5 = md5($newPassword);


    $st = $pdo->prepare('SELECT COUNT(email) FROM `users` WHERE email=:email');
    $st->bindParam(':email', $email, PDO::PARAM_INT);
    $st->execute();
    $email_data = $st->fetchAll();

    if ($email_data[0]["COUNT(email)"] == 0) {
        $errors[] = "Данного Email не существует";
    } else {
        $update = $pdo->prepare("UPDATE `users` SET password=:password WHERE email=:email");
        $update->bindParam(':password', $newPassMd5);
        $update->bindParam(':email', $email);
        $update->execute();

        // Уведомление по почте о регистрации
        include_once("phpmailer/phpmailer/mailfunc.php");
        $m_to = $email; // кому - ящик (из формы)
        $m_nameto = ""; // Кому
        $m_namefrom = "Impovar.ru"; // Поле От в письме
        $subj = "Восстановление пароля";
        $tmsg = "Ваш новый пароль $newPassword";
        $m_from = 'svilkov00@yandex.ru'; // от кого
        $m_reply = 'svilkov00@yandex.ru'; // адрес для обратного ответа
        $mail1 = phpmailer($subj, $tmsg, $m_to, $m_nameto, $m_namefrom, $m_from, $m_reply, $m_hostmail, $m_port, $m_password, $m_secure);

        $errors[] = "На ваш почтовый ящик был выслан новый пароль";
    }
//    echo "<pre>";
//    var_dump($newPassword);
//    echo "</pre>";
//
//    echo "<pre>";
//    var_dump($newPassMd5);
//    echo "</pre>";
}


//
//echo "<pre>";
//var_dump($email_data);
//echo "</pre>";


?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]>
<html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]>
<html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Восстановление пароля</title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/remodal/remodal.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/fonts.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/main.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/media.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/bootstrap.min.css"/>
</head>
<body>
<html>
<?php include("include/nav.php"); ?>
<div class="container">
    <div class="row">
        <div class="settings_wrapper">
            <div class="settings_block_header">
                <span class="sett_header">Восстановление пароля</span>
            </div>
            <form method="post" action="">
                <div class="block_forgetpass_item">
                    <p class="remind_p">Пожалуйста, укажите <b>E-mail</b>, который Вы использовали для входа на
                        сайт.</p>
                    <input type="text" name="input_email" class="name_sett_input">
                </div>
                <div class="block_margin">
                    <button type="submit" name="button_newsettings" class="btn_sett">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("include/footer.php"); ?>
<!--[if lt IE 9]-->
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/respond/respond.min.js"></script>
<!--[endif]-->
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/jquery/jquery-1.11.1.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/waypoints/waypoints-1.6.2.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/scrollto/jquery.scrollTo.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/owl-carousel/owl.carousel.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.plugin.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown-ru.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/landing-nav/navigation.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/common.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/main.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/bootstrap.min.js"></script>
</html>
</body>

<?php
    include("functions/functions.php");
    include("include/connection.php");

    ## проверка ошибок
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

//    echo "<pre>";
//    var_dump($_SESSION);
//    echo "</pre>";

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
    <title>Регистрация</title>
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
            <div class="succ_block_header">
                <span class="sett_header">Регистрация прошла успешно</span>
            </div>
            <div class="reg_wrapper">
                <p class="necessarily">Выберите действие:</p>
                <div class="reg_forms_succ">
                    Посмотреть <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/profile/<?php echo $_SESSION['user_id'];?>">
                        <span class="choose">
                            Свой Профиль
                        </span></a>
                </div>
                <div class="reg_forms_succ">
                    Посмотреть <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/forum">
                        <span class="choose">
                            Форум
                        </span>
                    </a>
                </div>
                <div class="reg_forms_succ">
                     <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/settings/<?php echo $_SESSION['user_id'];?>">
                         <span class="choose">
                             Редактировать профиль
                         </span>
                     </a>
                </div>
            </div>
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

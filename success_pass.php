<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    // если зло вручную поставит другой id пользвателя, то он не попадет на чужую страницу с ответами
    if ($id === 0 OR $id != $_SESSION['user_id']) {
//        die('Ошибка сжатия чёрной дыры');
        header("Location: http://impovar.tt90.ru/home");
        exit;
    }
    
}


if (!isset($_SESSION['email'])) {
//    header("Location: http://impovar.tt90.ru/home");
    header("Location: http://".$_SERVER['HTTP_HOST']."/home");
    exit;
}
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
    <title>IMPOVAR</title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="http://impovar.tt90.ru/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/remodal/remodal.css">
    <link rel="stylesheet" href="http://impovar.tt90.ru/remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/fonts.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/main.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/media.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/bootstrap.min.css"/>
</head>
<body>
<html>
<?php include("include/nav.php"); ?>
<div class="container-fluid center_wrapp">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="row">
                <div class="settings_wrap">
                    <form method="post" action="">
                        <div class="block_settings_pass_title">
                            <span class="sett_chapters">ваш пароль успешно изменен!</span><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include("include/menu_open.php"); ?>
    </div>
</div>
<?php include("include/footer.php"); ?>
<!--[if lt IE 9]-->
<script src="http://impovar.tt90.ru/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/respond/respond.min.js"></script>
<!--[endif]-->
<script src="http://impovar.tt90.ru/libs/jquery/jquery-1.11.1.min.js"></script>
<script src="http://impovar.tt90.ru/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="http://impovar.tt90.ru/libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="http://impovar.tt90.ru/libs/waypoints/waypoints-1.6.2.min.js"></script>
<script src="http://impovar.tt90.ru/libs/scrollto/jquery.scrollTo.min.js"></script>
<script src="http://impovar.tt90.ru/libs/owl-carousel/owl.carousel.min.js"></script>
<script src="http://impovar.tt90.ru/libs/countdown/jquery.plugin.js"></script>
<script src="http://impovar.tt90.ru/libs/countdown/jquery.countdown.min.js"></script>
<script src="http://impovar.tt90.ru/libs/countdown/jquery.countdown-ru.js"></script>
<script src="http://impovar.tt90.ru/libs/landing-nav/navigation.js"></script>
<script src="http://impovar.tt90.ru/js/common.js"></script>
<script src="http://impovar.tt90.ru/js/main.js"></script>
<script src="http://impovar.tt90.ru/js/bootstrap.min.js"></script>
<script src="http://impovar.tt90.ru/remodal/remodal.min.js"></script>
<script src="http://impovar.tt90.ru///code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

</html>
</body>
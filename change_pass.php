<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    // если зло вручную поставит другой id пользвателя, то он не попадет на чужую страницу с ответами
    if ($id === 0 OR $id != $_SESSION['user_id']) {
//        die('Ошибка сжатия чёрной дыры');
        header("Location: http://impovar.tt90.ru/home");
        exit;
    }

    //замена пароля
    $data = $_POST;
    if (isset($_POST['change_pass'])) {
        $errors = array();

        //проверка на соответствие текущего пароля

        $st = $pdo->prepare('SELECT `password` FROM `users` WHERE id=:id');
        $st->bindParam(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $profile_now_pass = $st->fetchAll();
        $NowPass = $profile_now_pass[0]['password'];

        //если не заполнены поля паролей
        if (trim($data['now_pass'] == "" OR trim(md5($data['now_pass'])) != $NowPass)) {
            $errors[] = "Введите верный текущий пароль";
        }
        if (trim($data['new_pass'] == "")) {
            $errors[] = "Введите новый пароль";
        }
        if (trim($data['e_new_pass'] == "")) {
            $errors[] = "Повторите новый пароль";
        }
        //если пароли не совпадают
        if (trim($data['new_pass']) != trim($data['e_new_pass'])) {
            $errors[] = "Пароли не совпадают";
        }
        //если все заполнено и соответвует, то регистрируем
        if (empty($errors)) {
        $insert = $pdo->prepare("
                UPDATE
                `users`
                SET
                password=:password
                WHERE
                id=:id
                ");
        $insert->bindParam(':password', md5($data['new_pass']));
        $insert->bindParam(':id', $_SESSION['user_id']);
        $insert->execute();

//        header("Location: success_pass.php?id=".$_SESSION['$user_id'].");
        header("Location: http://".$_SERVER['HTTP_HOST']."/succsespass/".$_SESSION['user_id']);
        exit;
        }

//        echo "<pre>";
//        var_dump($error);
//        echo "</pre>";

//        echo "<pre>";
//        var_dump($profile_now_pass);
//        echo "</pre>";
//
//        echo "<pre>";
//        var_dump($NowPass);
//        echo "</pre>";
    }
    $error = array_shift($errors);

}


if (!isset($_SESSION['email'])) {
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
    <title>Изменение пароля</title>
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
<div class="container-fluid center_wrapp">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="row">
                <div class="settings_wrap">
                    <form method="post" action="">
                        <div class="block_settings_pass_title">
                            <span class="sett_chapters">Изменить пароль</span><br>
                        </div>
                        <div class="block_settings_pass">
                            <p class="errors_reg"><?php echo $error; ?></p>
                            <div class="wrapp_sett_pass">
                                <span class="sett_pass_span">Текущий пароль</span><br>
                                <input type="password" name="now_pass" class="name_sett_input"
                                       value="<?php echo @$data['now_pass']; ?>">
                            </div>
                            <div class="wrapp_sett_pass">
                                <span class="sett_pass_span">Новый пароль</span><br>
                                <input type="password" name="new_pass" class="name_sett_input"
                                       value="<?php echo @$data['new_pass']; ?>">
                            </div>
                            <div class="wrapp_sett_pass">
                                <span class="sett_pass_span">Повтор нового пароля</span><br>
                                <input type="password" name="e_new_pass" class="name_sett_input"
                                       value="<?php echo @$data['e_new_pass']; ?>">
                            </div>
                        </div>

                        <div class="block_margin">
                            <button type="submit" name="change_pass" class="btn_sett">Изменить</button>
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
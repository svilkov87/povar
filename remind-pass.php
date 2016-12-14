<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$email = $_POST['input_email'];

if (isset($_POST['input_email'])){

    $errors = array();

//    echo time();
    $newPassword = md5(substr(md5(time()), 0, 6));

    $st = $pdo->prepare('SELECT COUNT(email) FROM `users` WHERE email=:email');
    $st->bindParam(':email', $email, PDO::PARAM_INT);
    $st->execute();
    $email_data = $st->fetchAll();

    if ($email_data[0]["COUNT(email)"] == 0){
        $errors[] = "Данного Email не существует";
    }

        else {
            $update = $pdo->prepare("UPDATE `users` SET password=:password WHERE email=:email");
            $update->bindParam(':password', $newPassword);
            $update->bindParam(':email', $email);
            $update->execute();

            $errors[] = "На ваш почтовый ящик был выслан новый пароль";
        }

}

//echo "<pre>";
//var_dump($newPassword);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($email_data);
//echo "</pre>";


?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>Восстановление пароля</title>
    <meta name="description" content="IMPOVAR" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/favicon/favicon.ico" />
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="remodal/remodal.css">
    <link rel="stylesheet" href="remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/media.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<html>
<?php include("include/nav.php");?>
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
                    <button type="submit" name="button_newsettings"  class="btn_sett">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("include/footer.php");?>
<!--[if lt IE 9]-->
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<!--[endif]-->
<script src="libs/jquery/jquery-1.11.1.min.js"></script>
<script src="libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="libs/waypoints/waypoints-1.6.2.min.js"></script>
<script src="libs/scrollto/jquery.scrollTo.min.js"></script>
<script src="libs/owl-carousel/owl.carousel.min.js"></script>
<script src="libs/countdown/jquery.plugin.js"></script>
<script src="libs/countdown/jquery.countdown.min.js"></script>
<script src="libs/countdown/jquery.countdown-ru.js"></script>
<script src="libs/landing-nav/navigation.js"></script>
<script src="js/common.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="remodal/remodal.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</html>
</body>

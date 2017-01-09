<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//if(!empty($_GET)) {
//
//    $id = intval($_GET['id']);
//    if ($id === 0) {
//        die('Ошибка сжатия чёрной дыры');
//    }
##отправка топика
$user_name = $_SESSION['user_name'];
$user_id = $_SESSION['user_id'];
$user_ava = $_SESSION['ava'];
if (isset($_POST['enter_comment'])) {
    $title = $_POST['title'];
    $text = $_POST['text'];;
    $insert = $pdo->prepare("
        INSERT INTO `forum_questions`
        SET 
        title=:title,
        text=:text,
        user_name=:user_name,
        user_ava=:user_ava,
        user_id=:user_id
        ");
    $insert->bindParam(':title', $title);
    $insert->bindParam(':text', $text);
    $insert->bindParam(':user_ava', $user_ava);
    $insert->bindParam(':user_name', $user_name);
    $insert->bindParam(':user_id', $user_id);
    $insert->execute();
    header("Location: http://impovar.tt90.ru/forum");
    exit;
}
//}
//        echo "<pre>";
//        var_dump($user_ava);
//        echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Форум</title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/media.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>
<?php
?>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container-fluid">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="wrapp_add_art">
                <div class="add_topic_panel_heading">
                    <span class="add_topic_span">Добавить топик</span>
                </div>
                <div class="add_topic_body">
                    <form method="post" action="">
                        <label for="m" class="label_add">Тема</label><br>
                        <input type="text" name="title" id="m"/>
                        <br/>
                        <label for="f" class="label_add">Текст сообщения</label><br>
                        <textarea name="text" id="f" cols="30" rows="10"></textarea><br>
                        <button class="btn_default" type="submit" name="enter_comment">вперед</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include("include/menu_open.php"); ?>
    </div>
</div>
<?php include("include/footer.php"); ?>
<!--[if lt IE 9]>
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<![endif]-->
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
<script src="remodal/remodal.min.js"></script>

<!-- Yandex.Metrika counter --><!-- Yandex.Metrika counter -->
<script type="text/javascript">(function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter25346996 = new Ya.Metrika({
                    id: 25346996,
                    webvisor: true,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");</script>
<noscript>
    <div><img src="//mc.yandex.ru/watch/25346996" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript><!-- /Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
<!-- Google Analytics counter --><!-- /Google Analytics counter -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->


</body>
</html>
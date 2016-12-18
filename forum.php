<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//if(!empty($_GET)) {

//    $id = intval($_GET['id']);
//    if ($id === 0) {
//        die('Ошибка сжатия чёрной дыры');
//    }

//вывод категорий
$st = $pdo->query('SELECT * FROM `forum_questions` ORDER BY id DESC');
$tags = $st->fetchAll();

//}


//echo "<pre>";
//var_dump($ava);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($tags);
//echo "</pre>";

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
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="add_topic.php" class="add_topic">
                <span class="add_text_topic">Добавить тему</span>
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>

<div class="container forum_wrapp">
    <div class="row">
        <table class="table table-bordered table-hover table-responsive">
            <thead>
            <tr class="success">
                <th width="150px">Автор темы</th>
                <th>Название</th>
                <th>Дата</th>
                <th>Просмотры</th>
                <th>Комментарии</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tags as $item): ?>
                <tr>
                    <th>
                        <div class="user_name_of_topic">
                            <a href="profile.php?id=<?php echo $item['user_id']; ?>">
                                <img src="img/avatars/<?php echo $item['user_ava']; ?>" class="ava_imgonforum">
                                <span class="user_name_link"><?php echo $item['user_name']; ?></span>
                            </a>
                        </div>
                    </th>
                    <th>
                        <div class="text_of_topic">
                            <a href="full_topic_theme.php?id=<?php echo $item['id']; ?>" class="topic_theme_link">
                                <h1 class="theme_topic_text_prev"><?php echo $item['title']; ?></h1>
                            </a>
                        </div>
                    </th>
                    <th style="font-weight: normal">
                        <?php echo $item['date']; ?>
                    </th>
                    <th width="40px" style="text-align: center;">
                        <?php echo $item['watches']; ?>
                    </th>
                    <th width="40px" style="text-align: center;">
                        <?php echo $item['number_of_comments']; ?>
                    </th>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

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
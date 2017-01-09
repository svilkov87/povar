<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//вывод категорий
$st = $pdo->query('SELECT * FROM `forum_questions` ORDER BY id DESC');
$tags = $st->fetchAll();


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
    <link rel="shortcut icon" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/css/fonts.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/css/main.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/css/media.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER["HTTP_HOST"];?>/css/bootstrap.min.css"/>
</head>
<body>
<?php
?>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6  home_wrapp">
            <div class="answers_wrapp">
                <div class="chapters_of_topic">
                <span class="span_forum_number">
                    <a href="http://<?php echo $_SERVER["HTTP_HOST"];?>/addtopic" class="add_topic">
                        <span class="add_text_topic">Добавить тему</span>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </span>
                    <span class="span_answer">Темы Форума</span>
                </div>
                <?php foreach ($tags as $item): ?>
                <a href="http://<?php echo $_SERVER["HTTP_HOST"];?>/topictheme/<?php echo $item['id']; ?>">
                    <div class="wrapp_topic">
                        <div class="title_topic">
                            <h1 class="theme_topic_text_prev"><?php echo $item['title']; ?></h1>
                        </div>
                        <div class="desc_topic">
                            <span class="theme_topic_desc"><?php echo $item['number_of_comments'];?></span>
                            <span class="theme_topic_desc">ответов</span>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
        <?php include("include/menu_open.php"); ?>

<!--        <table class="table table-bordered table-hover table-responsive">-->
<!--            <thead>-->
<!--            <tr class="success">-->
<!--                <th width="150px">Автор темы</th>-->
<!--                <th>Название</th>-->
<!--                <th>Дата</th>-->
<!--                <th>Просмотры</th>-->
<!--                <th>Комментарии</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            --><?php //foreach ($tags as $item): ?>
<!--                <tr>-->
<!--                    <th>-->
<!--                        <div class="user_name_of_topic">-->
<!--                            <a href="profile.php?id=--><?php //echo $item['user_id']; ?><!--">-->
<!--                                <img src="img/avatars/--><?php //echo $item['user_ava']; ?><!--" class="ava_imgonforum">-->
<!--                                <span class="user_name_link">--><?php //echo $item['user_name']; ?><!--</span>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </th>-->
<!--                    <th>-->
<!--                        <div class="text_of_topic">-->
<!--                            <a href="full_topic_theme.php?id=--><?php //echo $item['id']; ?><!--" class="topic_theme_link">-->
<!--                                <h1 class="theme_topic_text_prev">--><?php //echo $item['title']; ?><!--</h1>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </th>-->
<!--                    <th style="font-weight: normal">-->
<!--                        --><?php //echo $item['date']; ?>
<!--                    </th>-->
<!--                    <th width="40px" style="text-align: center;">-->
<!--                        --><?php //echo $item['watches']; ?>
<!--                    </th>-->
<!--                    <th width="40px" style="text-align: center;">-->
<!--                        --><?php //echo $item['number_of_comments']; ?>
<!--                    </th>-->
<!--                </tr>-->
<!--            --><?php //endforeach; ?>
<!--            </tbody>-->
<!--        </table>-->

    </div>
</div>
<?php include("include/footer.php"); ?>
<!--[if lt IE 9]>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/respond/respond.min.js"></script>
<![endif]-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/jquery/jquery-1.11.1.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/waypoints/waypoints-1.6.2.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/scrollto/jquery.scrollTo.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/owl-carousel/owl.carousel.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/countdown/jquery.plugin.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/countdown/jquery.countdown.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/countdown/jquery.countdown-ru.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/landing-nav/navigation.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/common.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/main.js"></script>

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
</body>
</html>
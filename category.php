<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {
    $id = intval($_GET['id']);

    //Выбираем дочерние категории, относящиеся к двум главным(контент)
    $st = $pdo->prepare('SELECT * FROM `category` WHERE main_child_id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $art = $st->fetchAll();

    //Выбираем главные категории, для навигационной цепочки(навигационая цепочка)
    $stm = $pdo->prepare('SELECT * FROM `main_category` WHERE id =:id');
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $tagTitle = $stm->fetchAll();

//    echo "<pre>";
//    var_dump($art);
//    echo "</pre>";
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <?php foreach ($tagTitle as $item): ?>
        <title><?php echo $item['title']; ?></title>
    <?php endforeach; ?>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="http://impovar.tt90.ru/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/fonts.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/main.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/media.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/bootstrap.min.css"/>
</head>
<body>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>

<?php include "include/nav.php"; ?>
<div class="container">
    <div class="row">
        <!--лого-->
        <div class="col-md-12 logo_block">
            <img src="http://impovar.tt90.ru/img/category_images/logo.svg" alt="logo" class="img_logo">
            <h1 class="logo_header">GRANDPOVAR</h1>
            <p class="logo_par">Энциклопедия рецептов</p>
            <hr class="hr_line">
        </div>
        <!--/лого-->
        <!--breadcrumb-->
        <div class="col-md-6 col-md-offset-3">
            <ol class="bread_crumb">
                <?php foreach ($tagTitle as $item): ?>
                    <li>
                        <a href="http://impovar.tt90.ru/home">Главная</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </li>
                    <li><?php echo $item['title']; ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <!--breadcrumb-->
    </div>
    <hr class="hr_line">
    <div class="main_block_category">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                    <div class="category_block_link">
                        <?php foreach ($art as $item): ?>
<!--                            <a href="link.php?id=--><?php //echo $item['article_id']; ?><!--&page=1">-->
                            <a href="http://impovar.tt90.ru/preview/<?php echo $item['article_id']; ?>">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="row">
                                        <figure class="figure">
                                            <img src="/img/category_images/<?php echo $item['image']; ?>" alt=""
                                                 class="img-responsive">
                                            <figcaption>
                                                <h1 class="name_of_category"><?php echo $item['title']; ?></h1>
                                                <p class="descr_category"><?php echo $item['description']; ?></p>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div><!--row-->
            </div><!--container-fluid-->
        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>
<!--присваиваем всем классам cuckoo-text красный цвет-->
<script>
    var classColor = document.getElementsByClassName('cuckoo-text');
    for (var i = 0; i < classColor.length; i++) {
        classColor[i].style.color = 'red';
        classColor[i].style.fontSize = 18 + 'px';
        ;
    }
</script>

<!--[if lt IE 9]>
<script src="http://impovar.tt90.ru/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/respond/respond.min.js"></script>
<![endif]-->
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
</body>
</html>
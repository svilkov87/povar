<?php
include("functions/functions.php");
include("include/connection.php");
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//вывод категорий
$st = $pdo->query('SELECT * FROM `main_category`');
$tags = $st->fetchAll();

//echo "<pre>";
//var_dump($_SERVER["HTTP_HOST"]);
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
    <title>IMPOVAR</title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="remodal/remodal.css">
    <link rel="stylesheet" href="remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/media.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include("include/nav.php"); ?>
<div class="container-fluid center_wrapp_home">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="row">
                <section id="block_home">
                    <div class="col-md-12 logo_wrapp">
                        <i class="fa fa-cutlery fa_cutlery" aria-hidden="true"></i>
                        <h1 class="logo_header">GRANDPOVAR</h1>
                        <p class="logo_par">Энциклопедия рецептов</p>
                        <hr class="hr_line">
                    </div>
    <span id="link_go_to_1055">
        <p class="logo_par">Далее</p>
        <i class="fa fa-angle-down go_to_1055" aria-hidden="true"></i>
    </span>
                </section>
                <section id="block_cuckoo_1055">
                    <!--    <div class="container">-->
                    <!--        <div class="row">-->
                    <div class="go_to_1055_header">
                        <h1 class="h1_go_1055">Cuckoo 1055</h1>
                    </div>
                    <div class="go_to_1055_wrapp">
                        <div class="cuckoo_pot">
                            <img src="img/category_images/pot.png" alt="" id="img_circle">
                            <a href="http://impovar.tt90.ru/category/1/">
                                <!--                        <div class="bottom">-->
                                <!--                            <p>Cuckoo 1055</p>-->
                                <!--                        </div>-->
                            </a>
                        </div>
                        <div class="cuckoo_text">
                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.
                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей
                                изысканностю.
                            </p>
                            <a href="http://impovar.tt90.ru/category/1/" class="link_to_cuckoo">
                                смотреть
                            </a>
                        </div>
                    </div>
                    <!--        </div>-->
                    <!--    </div>-->
                    <div class="clearfix"></div>
        <span id="link_go_to_not">
<!--        <p class="logo_par_net">Мультиварка и не только</p>-->
        <i class="fa fa-angle-down go_to_inetolko" aria-hidden="true"></i>
    </span>
                </section>
                <section id="block_cuckoo_not">
                    <!--    <div class="container">-->
                    <!--        <div class="row">-->
                    <div class="go_to_1055_header">
                        <h1 class="h1_go_not">Мультиварка и не только</h1>
                    </div>
                    <div class="go_to_1055_wrapp">
                        <div class="cuckoo_pot">
                            <img src="img/category_images/inet.png" alt="" id="img_circle">
                        </div>
                        <div class="cuckoo_text">
                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.
                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей
                                изысканностю.
                            </p>
                            <a href="http://impovar.tt90.ru/category/2/" class="link_to_not">
                                смотреть
                            </a>
                        </div>
                    </div>
                    <!--        </div>-->
                    <!--    </div>-->
    <span id="link_go_to_forum">
        <i class="fa fa-angle-down go_to_forum" aria-hidden="true"></i>
    </span>
                </section>
                <section id="block_forum">
                    <!--    <div class="container">-->
                    <!--        <div class="row">-->
                    <div class="go_to_1055_header">
                        <h1 class="h1_go_forum">Форум</h1>
                    </div>
                    <div class="go_to_1055_wrapp">
                        <div class="cuckoo_pot">
                            <img src="img/category_images/chat.png" alt="" id="img_circle">
                            <!--                    <a href="http://impovar.tt90.ru/forum">-->
                            <!--                        <div class="bottom">-->
                            <!--                            <p>Cuckoo 1055</p>-->
                            <!--                        </div>-->
                            <!--                    </a>-->
                        </div>
                        <div class="cuckoo_text">
                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.
                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей
                                изысканностю.
                            </p>
                            <a href="http://impovar.tt90.ru/forum" class="link_to_forum">
                                Перейти к форуму
                            </a>
                        </div>
                    </div>
                    <!--        </div>-->
                    <!--    </div>-->
                </section>
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
<script src="js/bootstrap.min.js"></script>
<script src="remodal/remodal.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<!--инициализация слайдера-->
<script>
    $(document).ready(function () {
        $("#slider").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            singleItem: true,
            //Pagination
            pagination: false,
            paginationNumbers: false,
            // Navigation
            navigation: false,
            // Responsive
            responsive: true
        });

    });
</script>
<!--/инициализация слайдера-->
<!-- инициализация модал -->
<script>
    $(window).scroll(function () {
        $('.mov').each(function () {
            var imagePos = $(this).offset().top;
            var topOfWindow = $(window).scrollTop();
            if (imagePos < topOfWindow + 400) {
                $(this).addClass('fadeInDown');
            }
        });
    });
</script>
<!-- /инициализация модал -->
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

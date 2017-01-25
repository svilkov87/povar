<?php
include("functions/functions.php");
include("include/connection.php");

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
    <title>Grandpovar</title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/remodal/remodal.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/fonts.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/main.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/media.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/css/bootstrap.min.css"/>
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
                    <div class="logo_wrapp">
                        <i class="fa fa-cutlery fa_cutlery" aria-hidden="true"></i>
                        <h1 class="logo_header">GRANDPOVAR</h1>
                        <p class="logo_par">Энциклопедия рецептов</p>
                        <hr class="hr_line">
                    </div>

                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/category/1/"
                       class="link_to_cuckoo">
                    <div class="section_1055">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="cuckoo_img"></div>
                                <div class="cuckoo_img_hidd">
                                    <h1 class="name_of_category">Cuckoo 1055</h1>
                                    <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке
                                        CUCKOO
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="cuckoo_descript">
                                <h1 class="cuckoo_header">Cuckoo 1055</h1>
                                <div class="cuckoo_pot">
<!--                                    <img src="http://--><?php //echo $_SERVER['HTTP_HOST']; ?><!--/img/category_images/pot.png"-->
<!--                                         alt="" id="img_circle">-->
                                    <p class="p_desrtp">
                                        Блюда приготовленные профессионалами, в мультиварке Cuckoo 1055...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/category/2/"
                       class="link_to_not">
                    <div class="section_1055">
                        <div class="col-md-4">
                            <div class="cuckoo_descript">
                                <h1 class="cuckoo_header">Мультиварка и не только</h1>
                                <div class="cuckoo_pot">
<!--                                    <img src="http://--><?php //echo $_SERVER['HTTP_HOST']; ?><!--/img/category_images/inet.png"-->
<!--                                         alt="" id="img_circle">-->
                                    <p class="p_desrtp">
                                        Здесь вы найдете не только массу интересных рецептов блюд, но и выберете свой люимое...
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="inet_img"></div>
                                <div class="cuckoo_inet_hidd">
                                    <h1 class="name_of_category">Мультиварка и не только</h1>
                                    <p class="inet_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке
                                        CUCKOO
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>

<!--                    <div class="logo_wrapp">-->
<!--                        <i class="fa fa-cutlery fa_cutlery" aria-hidden="true"></i>-->
<!--                        <h1 class="logo_header">GRANDPOVAR</h1>-->
<!--                        <p class="logo_par">Энциклопедия рецептов</p>-->
<!--                        <hr class="hr_line">-->
<!--                    </div>-->
<!--                    <div class="go_to_1055_header">-->
<!--                        <h1 class="h1_go_1055">Cuckoo 1055</h1>-->
<!--                    </div>-->
<!--                    <div class="go_to_1055_wrapp">-->
<!--                        <div class="cuckoo_pot">-->
<!--                            <img src="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/img/category_images/pot.png" alt="" id="img_circle">-->
<!--                        </div>-->
<!--                        <div class="cuckoo_text">-->
<!--                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.-->
<!--                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей-->
<!--                                изысканностю.-->
<!--                            </p>-->
<!--                            <a href="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/category/1/" class="link_to_cuckoo">-->
<!--                                смотреть-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="clearfix"></div>-->
<!--                    <div class="go_to_1055_header">-->
<!--                        <h1 class="h1_go_not">Мультиварка и не только</h1>-->
<!--                    </div>-->
<!--                    <div class="go_to_1055_wrapp">-->
<!--                        <div class="cuckoo_pot">-->
<!--                            <img src="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/img/category_images/inet.png" alt="" id="img_circle">-->
<!--                        </div>-->
<!--                        <div class="cuckoo_text">-->
<!--                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.-->
<!--                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей-->
<!--                                изысканностю.-->
<!--                            </p>-->
<!--                            <a href="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/category/2/" class="link_to_not">-->
<!--                                смотреть-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="go_to_1055_header">-->
<!--                        <h1 class="h1_go_forum">Форум</h1>-->
<!--                    </div>-->
<!--                    <div class="go_to_1055_wrapp">-->
<!--                        <div class="cuckoo_pot">-->
<!--                            <img src="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/img/category_images/chat.png" alt="" id="img_circle">-->
<!--                        </div>-->
<!--                        <div class="cuckoo_text">-->
<!--                            <p class="cuckoo_desc">Лучшие рецепты, приготовленные профессионалами в мультиварке CUCKOO.-->
<!--                                В данном разделе Вы найдете не только полюбившиеся блюда, но другие, удивляющие своей-->
<!--                                изысканностю.-->
<!--                            </p>-->
<!--                            <a href="http://--><?php //echo $_SERVER['HTTP_HOST'];?><!--/forum" class="link_to_forum">-->
<!--                                Перейти к форуму-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
                </section>
            </div>
        </div>

        <?php include("include/menu_open.php"); ?>
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
<script src="http://<?php echo $_SERVER['HTTP_HOST'];?>/js/bootstrap.min.js"></script>
</body>
</html>

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
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container-fluid center_wrapp">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="row">
                <div class="link_bread">
                <ol class="bread_crumb">
                    <?php foreach ($tagTitle as $item): ?>
                        <li>
                            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/home">Главная</a>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </li>
                        <li><?php echo $item['title']; ?></li>
                    <?php endforeach; ?>
                </ol>
                    </div>
            </div>
            <div class="main_block_category">
                <div class="row">
                    <div class="category_block_link">
                        <?php foreach ($art as $item): ?>
                            <!--                            <a href="link.php?id=--><?php //echo $item['article_id']; ?><!--&page=1">-->
                            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/preview/<?php echo $item['article_id']; ?>">
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
                </div>
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
</body>
</html>
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
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container-fluid center_wrapp">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="answers_wrapp">
                <div class="chapters_of_topic">
                    <?php if (isset($_SESSION['email'])): ?>
                <span class="span_forum_number">
                    <a href="http://<?php echo $_SERVER["HTTP_HOST"];?>/addtopic" class="add_topic">
                        <span class="add_text_topic">Добавить тему</span>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </span>
                    <?php endif;?>
                    <span class="span_answer">Темы Форума</span>
                </div>
                <?php foreach ($tags as $item): ?>
                <a href="http://<?php echo $_SERVER["HTTP_HOST"];?>/topictheme/<?php echo $item['id']; ?>">
                    <div class="wrapp_topic">
                        <div class="img_auth_topic">
                            <img src="http://<?php echo $_SERVER["HTTP_HOST"]; ?>/img/avatars/<?php echo $item['user_ava']; ?>"
                                 class="ava_img_auth_topic" title="<?php echo $item['user_name']; ?>">
                        </div>
                        <div class="right_part_topic">
                            <div class="title_topic">
                                <h1 class="theme_topic_text_prev"><?php echo $item['title']; ?></h1>
                            </div>
                            <div class="desc_topic">
                                <span class="theme_topic_desc"><?php echo $item['number_of_comments'];?></span>
                                <span class="theme_topic_desc">ответов</span>
                                <span class="theme_topic_desc"><?php echo $item['watches'];?></span>
                                <span class="theme_topic_desc">просмотров</span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
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
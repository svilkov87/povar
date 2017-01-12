<?php
include("functions/functions.php");
include ("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(!empty($_GET)){
    $id = intval($_GET['id']);
    if ($id === 0){die('Ошибка сжатия чёрной дыры');}
    
    //пагинация
//    $page = intval($_GET['page']);
//    //сколько хотим видеть статей на странице
//    $max_posts = 4;
//
//    //узнаем сколько всего лежит статей в бд
//    $num_posts = $pdo->query('SELECT COUNT(*) FROM `article`')->fetchColumn();
//    //указываем сколько хотим видеть страниц
//    $num_pages = intval(($num_posts - 1) / $max_posts) + 1 ;
//
//    if(empty($page)or $page < 0) $page = 1;
//    if($page > $num_pages) $page = $num_pages;
//
//    //определяем c какого номера выводить
//    $start = $page * $max_posts - $max_posts;

    //Выбираем статьи относящиеся к вторстепенным тегам
//    $st = $pdo->prepare("SELECT * FROM `article` WHERE cat_id=:id ORDER BY id DESC LIMIT $start, $max_posts ");
//    $st->bindParam(':id', $id, PDO::PARAM_INT);
//    $st->execute();
//    $art = $st->fetchAll();

    $st = $pdo->prepare("SELECT * FROM `article` WHERE cat_id=:id ORDER BY id DESC");
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $art = $st->fetchAll();


    //Выбираем дочерние категории, относящиеся к двум главным
    $stm = $pdo->prepare('SELECT * FROM `category` WHERE `article_id`=:id');
    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();
    $tagTitle= $stm->fetchAll();

    $a = $tagTitle[0]["main_child_id"];

    $stmt = $pdo->prepare('SELECT * FROM `main_category` WHERE `main_id` = :main_id');
    $stmt->bindParam(':main_id', $a, PDO::PARAM_INT);
    $stmt->execute();
    $tagTitle1= $stmt->fetchAll();
}


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
    <?php foreach($tagTitle as $item):?>
    <title><?php echo $item['title'];?></title>
    <?php endforeach;?>
    <meta name="description" content="IMPOVAR" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="http://impovar.tt90.ru/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/fonts.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/main.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/media.css" />
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/bootstrap.min.css" />
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
                    <li>
                        <a href="http://impovar.tt90.ru/home">Главная</a>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </li>
                    <?php foreach ($tagTitle1 as $item): ?>
                        <li>
                            <a href="http://impovar.tt90.ru/category/<?php echo $item['main_id']; ?>"><?php echo $item['title']; ?></a>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </li>
                    <?php endforeach; ?>
                    <?php foreach ($tagTitle as $item): ?>
                        <li><?php echo $item['title']; ?></li>
                    <?php endforeach; ?>
                </ol>
                </div>
                <div class="link_wrapp">
                    <?php foreach ($art as $item): ?>
                        <div class="col-md-6">
                            <div class="row">
                            <a href="http://impovar.tt90.ru/article/<?php echo $item['id']; ?>" class="link_by_link">
                            <div class="link_panel">
                                <div class="link_body">
                                    <div class="img_block_link">
                                        <img src="http://impovar.tt90.ru/admin/images/<?php echo $item['intro_image']; ?>"
                                             alt="..." class="img_link">
                                    </div>
                                </div>
                                <div class="panel_head_link">
                                    <h1 class="link_head_h"><?php echo $item['title']; ?></h1>
                                </div>
                            </div>
                            </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php include("include/menu_open.php"); ?>
    </div>
</div>
<!--    <ul class="pagination">-->
<!--    --><?//
//    // Проверяем нужны ли стрелки назад
//
//    if ($page != 1) $pervpage = '<a href=link.php?id='.$_GET['id'].'&page=1>Первая</a> | <a href=link.php?id='.$_GET['id'].'&page='. ($page - 1) .'>Предыдущая</a> | ';
//    // Проверяем нужны ли стрелки вперед
//    if ($page != $num_pages) $nextpage = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 1) .'>Следующая</a> | <a href=link.php?id='.$_GET['id'].'&page=' .$num_pages. '>Последняя</a>';
//
//    // Находим две ближайшие станицы с обоих краев, если они есть
//    if($page - 5 > 0) $page5left = ' <a href=link.php?id='.$_GET['id'].'&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
//    if($page - 4 > 0) $page4left = ' <a href=link.php?id='.$_GET['id'].'&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
//    if($page - 3 > 0) $page3left = ' <a href=link.php?id='.$_GET['id'].'&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
//    if($page - 2 > 0) $page2left = ' <a href=link.php?id='.$_GET['id'].'&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
//    if($page - 1 > 0) $page1left = ' <a href=link.php?id='.$_GET['id'].'&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
//
//    if($page + 5 <= $num_pages) $page5right = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
//    if($page + 4 <= $num_pages) $page4right = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
//    if($page + 3 <= $num_pages) $page3right = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
//    if($page + 2 <= $num_pages) $page2right = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
//    if($page + 1 <= $num_pages) $page1right = ' | <a href=link.php?id='.$_GET['id'].'&page='. ($page + 1) .'>'. ($page + 1) .'</a>';
//
//    // Вывод меню если страниц больше одной
//
//    if ($num_pages > 1)
//    {
//        Error_Reporting(E_ALL & ~E_NOTICE);
//        echo "<div class=\"pstrnav\">";
//        echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
//        echo "</div>";
//    }
//    ?>
<!--    </ul>-->

<?php include("include/footer.php");?>
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
<script src="http://impovar.tt90.ru/remodal/remodal.min.js"></script>
<!-- инициализация модал -->
</body>
</html>
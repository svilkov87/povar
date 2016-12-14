<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if(!empty($_GET)) {

    $id = intval($_GET['id']);

    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $intro_image = $profile_data[0]['ava'];
    if ($intro_image == ""){
        $intro_image = "no_ava.png";
    }


//    считаем количество рецептов
    $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id AND main_id != 2');
    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
    $st->execute();
    $art_column = $st->fetchColumn();


    $forAdminId = $profile_data[0]["id"];
    //Выбираем статьи относящиеся к этим тегам
    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ');
    $st->bindParam(':user_id', $forAdminId, PDO::PARAM_INT);
    $st->execute();
    $art = $st->fetchAll();
//    $us_id = $art[0]['user_id'];

    $cat = $art[0]["cat_id"];
    //Выбираем дочерние категории, относящиеся к двум главным
    $stm = $pdo->prepare('SELECT * FROM `category` WHERE `article_id`=:article_id');
    $stm->bindParam(':article_id', $cat, PDO::PARAM_INT);
    $stm->execute();
    $tagTitle= $stm->fetchAll();


    $main_cat = $tagTitle[0]["main_child_id"];
    //Выбираем выбираем главные категории
    $stm = $pdo->prepare('SELECT * FROM `main_category` WHERE `main_id`=:main_id');
    $stm->bindParam(':main_id', $main_cat, PDO::PARAM_INT);
    $stm->execute();
    $tagMain= $stm->fetchAll();

    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id AND main_id != 2 ORDER BY id DESC');
    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
    $st->execute();
    $art_of_user = $st->fetchAll();


//    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ORDER BY id DESC');
//    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
//    $st->execute();
//    $art_of_user = $st->fetchAll();


}
//echo "<pre>";
//var_dump($art);
//echo "</pre>";

//echo "<pre>";
//var_dump($forAdminId);
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
    <title>IMPOVAR</title>
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
        <div class="col-md-4 ava_block">
            <a href="#">
                <img src="img/avatars/<?php echo $intro_image; ?>" class="ava_img">
            </a>
        </div>
        <div class="col-md-8">
            <div class="profile_panel">

                <div class="panel_heading">
                    <?php foreach($profile_data as $item):?>
                    <span class="name_of_user_profile"><?php echo $item['username']; ?></span>
                    <br>
                    <div class="about_me">
                        <span class="span_about">О cебе:</span><br>
                        <span class="span_about_text"><?php echo $item['about']; ?></span>
                    </div>
                    <?php endforeach;?>
                </div>

                <div class="panel-body">
                    <div class="col-md-2 panel_items">
                        <span class="panel_items_number"><?php echo $art_column; ?></span>
                        <span class="panel_items_text">рецепт(ов)</span>
                    </div>
                    <div class="col-md-2 panel_items">
                        <span class="panel_items_number">0%</span>
                        <span class="panel_items_text">рейтинг</span>
                    </div>
                    <div class="col-md-2 panel_items">3</div>
                    <div class="col-md-2 panel_items">4</div>
                </div>
            </div>
<!--        </div>-->
<!--        <div class="col-md-8">-->
                    <?php
                    if($art_column  == 0):?>
                        <div class="list_of_recipes">
<!--                            <div class="panel-heading">-->
                                <span class="span_answer">Нет ни одного рецепта</span>
<!--                            </div> -->
                        </div>
                    <?php endif; ?>
                    <?php if($id == 14){
                    foreach($art_of_user as $item):?>
                        <div class="list_of_recipes">
                            <div class="block_left_profile">
                                <img src="admin/images/<?php echo $item['intro_image'];?>" alt="" class="images_profile_link">
                            </div>
                            <div class="block_middle_profile_admin">
                                    <a href="full.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a>
                                <br>
                                <span class="date_full_art"><?php echo $item['date'];?></span>
                            </div>
                            <div class="block_right_prifile">
                                <span class="wathes_full_art">просмотров</span>
                                <span>&nbsp;<?php echo $item['watches'];?></span>
                            </div>
                        </div>
                    <?php endforeach;}
                    if($_SESSION['user_id'] == $id AND $id != 14){
                        foreach($art_of_user as $item):?>
                            <div class="list_of_recipes">
                                <div class="block_left_profile">
                                    <img src="admin/images/<?php echo $item['intro_image'];?>" alt="" class="images_profile_link">
                                </div>
                                <div class="block_middle_profile">
                                    <a href="full_users_article.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a>
                                    <br>
                                    <span class="date_full_art"><?php echo $item['date'];?></span>
                                </div>
                                <div class="block_edit_twoblocks">
                                    <div class="block_edit_prifile">
                                         <a href="edit_article.php?id=<?php echo $item['id'];?>&user=<?php echo $item['user_id']; ?>">
                                             <i class="fa fa-pencil" aria-hidden="true" style="color: #71b1f7;"></i>
                                         </a>
                                         <a href="delete_article.php?id=<?php echo $item['id'];?>">
                                             <i class="fa fa-trash-o" aria-hidden="true" style="color: #f76666;"></i>
                                         </a>
                                    </div>
                                    <div class="block_right_profile_edit">
                                        <span class="wathes_full_art">просмотров</span>
                                        <span>&nbsp;<?php echo $item['watches'];?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;}?>
                        <?php
                        if($id !== 14 && $_SESSION['user_id'] != $id){
                            foreach($art_of_user as $item):?>
                                <div class="list_of_recipes">
                                    <div class="block_left_profile">
                                        <img src="admin/images/<?php echo $item['intro_image'];?>" alt="" class="images_profile_link">
                                    </div>
                                    <div class="block_middle_profile">
                                        <a href="full.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a>
                                        <br>
                                        <span class="date_full_art"><?php echo $item['date'];?></span>
                                    </div>
                                    <div class="block_right_prifile">
                                        <span class="wathes_full_art">просмотров</span>
                                        <span>&nbsp;<?php echo $item['watches'];?></span>
                                    </div>
                                </div>
                            <?php endforeach;}?>
<!--        </div>-->
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
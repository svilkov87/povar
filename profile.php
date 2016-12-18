<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);

    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $user_image = $profile_data[0]['ava'];
    $user_id = $profile_data[0]['id'];
    if ($user_image == "") {
        $user_image = "no_ava.png";
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

    //Выбираем последние 20 статей для отображения в профиле юзера, у которого нет ни одной статьи
    $st = $pdo->query('SELECT * FROM `article` ORDER BY id DESC LIMIT 0, 20');
    $LastArt = $st->fetchAll();
//    $us_id = $art[0]['user_id'];

    $cat = $art[0]["cat_id"];
    //Выбираем дочерние категории, относящиеся к двум главным
    $stm = $pdo->prepare('SELECT * FROM `category` WHERE `article_id`=:article_id');
    $stm->bindParam(':article_id', $cat, PDO::PARAM_INT);
    $stm->execute();
    $tagTitle = $stm->fetchAll();


    $main_cat = $tagTitle[0]["main_child_id"];
    //Выбираем выбираем главные категории
    $stm = $pdo->prepare('SELECT * FROM `main_category` WHERE `main_id`=:main_id');
    $stm->bindParam(':main_id', $main_cat, PDO::PARAM_INT);
    $stm->execute();
    $tagMain = $stm->fetchAll();

    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id AND main_id != 2 ORDER BY id DESC');
    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
    $st->execute();
    $art_of_user = $st->fetchAll();

    //сколько топиков оставлял юзер
    $st = $pdo->prepare('SELECT COUNT(id)FROM `forum_questions` WHERE user_id=:user_id');
    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
    $st->execute();
    $Number = $st->fetchAll();

    $StringArray = array();
    for ($i = 0; $i < count($Number); $i++) {
        $StringArray[] = $Number[$i]["COUNT(id)"];
    }
    ## Превращение одномерного массива в строку
    $NumberOfTopic = implode(',', $StringArray);


//    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ORDER BY id DESC');
//    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
//    $st->execute();
//    $art_of_user = $st->fetchAll();


}
//echo "<pre>";
//var_dump($id);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($NumberOfTopic);
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
    <link rel="shortcut icon" href="http://impovar.tt90.ru/http://impovar.tt90.ru/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/remodal/remodal.css">
    <link rel="stylesheet" href="http://impovar.tt90.ru/remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/fonts.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/main.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/media.css"/>
    <link rel="stylesheet" href="http://impovar.tt90.ru/css/bootstrap.min.css"/>
</head>
<body>
<html>
<!--call confirm modal-->
<!--<div id="modalWindow">-->
<!--    <div class="window">-->
<!--        <a href="#fa_close_window" class="fa_close_window">x</a><br>-->
<!--        <div class="mindow_items">-->
<!--            <p class="remind_p">Хотите удалить  статью безвозвратно?</p>-->
<!--            <div class="confirm_block">-->
<!--                <a href="" class="last_confirn_del">Удалить</a>-->
<!--                <a href="#fa_close_window" class="last_confirn_del_no">Нет</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--/call confirm modal-->
<?php include("include/nav.php"); ?>
<div class="container">
    <div class="row">
        <div class="profile_panel">
            <div class="panel_heading">
                <?php foreach ($profile_data as $item): ?>
                    <div class="col-md4 ava_block">
                        <a href="http://impovar.tt90.ru/profile/<?php echo $user_id; ?>" class="dfg">
                            <img src="http://impovar.tt90.ru/img/avatars/<?php echo $user_image; ?>" class="ava_img">
                        </a>
                    </div>
                    <div class="col-md8">
                        <span class="name_of_user_profile"><?php echo $item['username']; ?></span>
                        <br>
                        <div class="about_me">
                            <span class="span_about">О cебе:</span>
                            <div class="span_about_text">
                                <?php echo $item['about']; ?>
                            </div>
                        </div>
                        <div class="about_me">
                            <span class="span_about">Любимое блюдо:</span>
                            <span class="span_about_text"><?php echo $item['fav_food']; ?></span>
                        </div>
                        <div class="about_me">
                            <span class="span_about">Профессия:</span>
                            <span class="span_about_text"><?php echo $item['profession']; ?></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php endforeach; ?>
            </div>

            <div class="panel-skills">
                <span class="panel_items_number"><?php echo $art_column; ?></span>
                <span class="panel_items_text">рецепт(ов)</span>
                <span class="panel_items_number">0%</span>
                <span class="panel_items_text">рейтинг</span>
                <span class="panel_items_number"><?php echo $NumberOfTopic; ?></span>
                <span class="panel_items_text">вопросы/форум</span>
            </div>
        </div>
        <?php
        if ($art_column == 0):?>
            <div class="list_of_recipes">
                <span class="span_answer">Нет ни одного рецепта</span>
            </div>
            <div class="last_of_body">
                <span class="span_last_rec">Последние рецепты пользователей:</span>
            </div>
            <div class="list_of_recipes">
                <?php foreach ($LastArt as $item): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="last_art_body">
                            <div class="last_art_header">
                                    <span class="span_last">
                                        <a href="http://impovar.tt90.ru/article/<?php echo $item['id']; ?>" class="last_to_full_link">
                                            <?php echo $item['title']; ?>
                                        </a>
                                    </span>
                            </div>
                            <div class="wrapp_last">
                                <img src="http://impovar.tt90.ru/admin/images/<?php echo $item['intro_image']; ?>" alt=""
                                     class="last_intro_image">
                                <div class="bottom_prof">
                                    <span class="wathes_full_art">просмотров:</span>
                                    <span class="wathes_full_art"><?php echo $item['watches']; ?></span>
                                    <br>
                                    <span class="wathes_full_art">комменты:</span>
                                    <span class="wathes_full_art"><?php echo $item['watches']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="last_of_body">
                <span class="span_last_rec">Рецепты Автора:</span>
            </div>
        <?php endif; ?>
        <?php if ($id == $_SESSION['user_id']): ?>
            <div class="list_of_recipes">
                <?php foreach ($art_of_user as $item): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="last_art_body">
                            <div class="last_art_header">
                                            <span class="span_last">
                                            <a href="http://impovar.tt90.ru/article/<?php echo $item['id']; ?>" class="last_to_full_link">
                                                <?php echo $item['title']; ?>
                                            </a>
                                                </span>
                            </div>
                            <div class="wrapp_last">
                                <img src="http://impovar.tt90.ru/admin/images/<?php echo $item['intro_image']; ?>" alt=""
                                     class="last_intro_image">
                                <div class="bottom_prof">
                                    <a href="delete_article.php?id=<?php echo $item['id']; ?>"
                                       onclick="return confirm('Удалить статью?')" class="fa-trash-del">
                                        <i class="fa fa-trash fa-trash-del" aria-hidden="true"></i>
                                    </a>
                                    <a href="http://impovar.tt90.ru/editart/<?php echo $item['id']; ?>/<?php echo $item['user_id']; ?>"
                                       class="fa-trash-del">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($id != $_SESSION['user_id']): ?>
            <div class="list_of_recipes">
                <?php foreach ($art_of_user as $item): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="last_art_body">
                            <div class="last_art_header">
                                    <span class="span_last">
                                        <a href="http://impovar.tt90.ru/article/<?php echo $item['id']; ?>" class="last_to_full_link">
                                            <?php echo $item['title']; ?>
                                        </a>
                                    </span>
                            </div>
                            <div class="wrapp_last">
                                <img src="http://impovar.tt90.ru/admin/images/<?php echo $item['intro_image']; ?>" alt=""
                                     class="last_intro_image">
                                <div class="bottom_prof">
                                    <span class="wathes_full_art">просмотров:</span>
                                    <span class="wathes_full_art"><?php echo $item['watches']; ?></span>
                                    <br>
                                    <span class="wathes_full_art">комменты:</span>
                                    <span class="wathes_full_art"><?php echo $item['watches']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include("include/footer.php"); ?>
<!--[if lt IE 9]-->
<script src="http://impovar.tt90.ru/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://impovar.tt90.ru/libs/respond/respond.min.js"></script>
<!--[endif]-->
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
<script src="http://impovar.tt90.ru/js/bootstrap.min.js"></script>
<script src="http://impovar.tt90.ru/remodal/remodal.min.js"></script>
<script src="http://impovar.tt90.ru///code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</html>
</body>
<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//    error_reporting(E_ALL | E_STRICT);
//    ini_set('display_errors', TRUE);
//    ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    if ($id === 0) {
        die('Ошибка сжатия чёрной дыры');
    }
//    var_dump($id);

    //Выбираем статьи относящиеся к этим тегам 
    $st = $pdo->prepare('SELECT * FROM `article` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $art = $st->fetchAll();
    $us_id = $art[0]['user_id'];
    $artMainid = $art[0]['main_id'];
    $image_var = $art[0]['intro_image'];

    //    просмотры
    $st = $pdo->prepare('SELECT `watches` FROM `article` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $watches = $st->fetchAll();
    $count_of_watches = $watches[0]['watches'];
    $count_of_watches++;

    $st = $pdo->prepare('UPDATE `article` SET watches=:watches WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->bindParam(':watches', $count_of_watches, PDO::PARAM_INT);
    $st->execute();
//        $number_watches = $st->fetchAll();

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


    //Выбираем выбираем всех юзеров
    $user_id = $_SESSION['user_id'];
    $stm = $pdo->prepare('SELECT * FROM `users` WHERE `id`=:id');
    $stm->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stm->execute();
    $users = $stm->fetchAll();


    //Выбираем автора статьи
    $stm = $pdo->prepare('SELECT * FROM `users` WHERE `id`=:id');
    $stm->bindParam(':id', $us_id, PDO::PARAM_INT);
    $stm->execute();
    $auth = $stm->fetchAll();

    ##отправка комментариев
    $ValueOne = 1;
    if (isset($_POST['enter_comment'])) {
        $text = $_POST['text'];
        $input_text = $_POST['input_text'];
        $input_user_id = $_POST['input_user_id'];
        $input_user = $_POST['input_user'];
        $input_image = $_POST['article_intro_image'];
        $answer_for_comment = $_POST['answer_for_comment'];
        $insert = $pdo->prepare("
            INSERT INTO 
            `comments` 
            SET 
            text=:text, 
            isnew=:isnew, 
            ava=:ava, 
            article_id=:article_id, 
            article_intro_image=:article_intro_image, 
            to_comment=:to_comment, 
            user_id=:user_id, 
            user_id_art=:user_id_art, 
            user_name=:user_name, 
            to_user=:to_user, 
            answer_for_comment=:answer_for_comment
            ");
        $insert->bindParam(':isnew', $ValueOne);
        $insert->bindParam(':text', $text);
        $insert->bindParam(':to_comment', $input_text);
        $insert->bindParam(':to_user', $input_user_id);
        $insert->bindParam(':user_id_art', $input_user);
        $insert->bindParam(':article_intro_image', $input_image);
        $insert->bindParam(':user_name', $_SESSION['user_name']);
        $insert->bindParam(':ava', $_SESSION['ava']);
        $insert->bindParam(':article_id', $id);
        $insert->bindParam(':user_id', $users[0]['id']);
        $insert->bindParam(':answer_for_comment', $answer_for_comment);
        $insert->execute();
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
//        вывод всех комментариев, которые соответствуют статье
    $st = $pdo->prepare('SELECT * FROM `comments` WHERE `article_id` =:article_id ORDER BY id DESC');
    $st->bindParam(':article_id', $id, PDO::PARAM_INT);
    $st->execute();
    $commentary = $st->fetchAll();
    $comment_id_user = array_column($commentary, 'user_id');
    $comment_us_result = implode(",", $comment_id_user);

    $number_of_comments = count($commentary);
//       $comment_us_result = intval($comment_us_result);
//      если в $comment_us_result ничего нет, то определяем, что там int 0 (иначе возникнет ошибка в тех статьях, где нет комментов)
    if ($comment_us_result == "") {
        $comment_us_result = 0;
    }


//        Выбираем выбираем всех юзеров, оставивших коомент для соотв статьи
    $stm = $pdo->prepare('SELECT * FROM `users` WHERE `id` IN (' . $comment_us_result . ')');
    $stm->execute();
    $users_comm = $stm->fetchAll();
    $users_comm_array = array_column($users_comm, 'id');
    $users_comm_string = implode(",", $users_comm_array);

}
//
//        echo "<pre>";
//        var_dump($us_id);
//        echo "</pre>";
//
//        echo "<pre>";
//        var_dump($artMainid );
//        echo "</pre>";

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <?php foreach ($art as $item): ?>
        <title><?php echo $item['title']; ?></title>
    <?php endforeach; ?>
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
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<?php

if ($art[0]['id'] == ""):?>
    <div class="container">
        <div class="row">
            <div class="panel panel-default panel_full">
                <div class="panel-heading">
                    автор удалил данную статью...
                </div>
            </div>
        </div>
    </div>

    <?php
else:
//    foreach($art as $item):
    ?>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <ol class="bread_crumb">
                        <li>
                            <a href="index.php">Главная</a>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </li>
                        <?php foreach ($tagMain as $item): ?>
                            <li>
                                <a href="category.php?id=<?php echo $item['main_id']; ?>"><?php echo $item['title']; ?></a>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>
                        <?php endforeach; ?>
                        <?php foreach ($tagTitle as $item): ?>
                            <li>
                                <a href="link.php?id=<?php echo $item['article_id']; ?>&page=1"><?php echo $item['title']; ?></a>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div><!--breadcrumb-->
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col_7_media">
                <?php foreach ($art as $item): ?>
                    <div class="full_art_panel">
                        <div class="full_art_heading">
                            <h3 class="panel-title"><?php echo $item['title']; ?></h3>
                        </div>
                        <div class="full_art_body">
                            <?php echo $item['text']; ?>
                        </div>
                        <div class="author_of_fullart">
                            <?php
                            if ($us_id != 14 AND $artMainid == 2):
                                foreach ($auth as $item): ?>
                                    <span class="name_auth">Автор статьи:</span>
                                    <a href="profile.php?id=<?php echo $item['id']; ?>"
                                       class="name_auth"><?php echo $item['username']; ?></a>
                                <?php endforeach;
                            elseif ($us_id == 14 AND $artMainid == 1 OR $us_id != 14):
                                foreach ($auth as $item): ?>
                                    <span class="name_auth">Автор статьи:</span>
                                    <a href="profile.php?id=<?php echo $item['id']; ?>"
                                       class="name_auth"><?php echo $item['username']; ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <span class="count_watches">Просмотров:&nbsp;<b><?php echo $count_of_watches; ?></b></span>
                        </div>
                    </div>

                    <div class="comment_body">
                        <span class="span_answer">Комментариев&nbsp;<?php echo $number_of_comments; ?></span>
                    </div>
                <?php endforeach; ?>
                <?php
                if (isset($_SESSION['email'])):?>
                    <div class="full_art_forms">
                        <div class="user_init_full">
                            <div class="user_photo">
                                <?php foreach ($users as $key): ?>
                                    <a href="profile.php?id=<?php echo $key['id']; ?>">
                                        <img src="img/avatars/<?php echo $_SESSION['ava']; ?>" class="ava_img_fullart">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <form method="post" action="">
                            <input readonly hidden type="text" name="input_text" id="answer_input">
                            <input readonly hidden type="text" name="input_user" id="answer_input"
                                   value="<?php echo $us_id; ?>">
                            <input readonly hidden type="text" name="input_user_id" id="answer_input_to_user">
                            <input readonly hidden type="text" name="article_intro_image" id="answer_input_image"
                                   value="<?php echo $image_var; ?>">
                            <textarea readonly hidden class="form-control" rows="3" name="answer_for_comment"
                                      id="answer_to_comment"></textarea>
                            <textarea class="form-control" rows="3" name="text" id="answer"
                                      placeholder="Введите сообшение..." onfocus="placeholder='';"
                                      onblur="placeholder='Введите сообшение...';"></textarea>
                            <div class="button_n_delete">
                                <button class="btn_default" type="submit" name="enter_comment">Ответить</button>
                                <ul class="answer_stuffs">
                                    <li class="span_delete_username">

                                    </li>
                                    <li class="span_delete_items">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <!--                                    </div>-->
                    </div>
                    <!--                            </div>-->

                <?php else: ?>
                    <div class="no_comment_body">
                        <p class="no_comment_p">Комментарии могут оставлять только зарегистрированные или авторизованные
                            пользователи</p>
                    </div>
                <?php endif; ?>

                <div class="answers_panel">
                    <?php foreach ($commentary as $item): ?>
                        <div class="profile_link" role="answer_item_id" id="answer_item_id<?php echo $item['id']; ?>">
                            <div class="left_block_comment">
                                <div class="ava">
                                    <div class="photo">
                                        <img src="img/avatars/<?php echo $item['ava']; ?>" class="ava_img_fullusart">
                                    </div>
                                    <a href="profile.php?id=<?php echo $item['user_id']; ?>" class="user_name_ava">
                                        <?php echo $item['user_name']; ?>
                                    </a>
                                </div>
                            </div>
                            <?php foreach ($art as $key): ?>
                                <a href="#" id="hidden_image_to_comment"><?php echo $key['intro_image']; ?></a>
                            <?php endforeach; ?>
                            <div class="middle_content_comm">
                                <span class="answer_comment"><?php echo $item['text']; ?></span><br>

                                <a href="profile.php?id=<?php echo $item['user_id']; ?>" class="p"
                                   id="answer_item_id<?php echo $item['id']; ?>">
                                    <?php echo $item['user_name']; ?>
                                </a>
                                <a href="#" id="hidden_id"><?php echo $item['id']; ?></a>
                                <a href="#" id="hidden_id_to_user"><?php echo $item['user_id']; ?></a>
                                <a href="#" id="hidden_text_to_comment"><?php echo $item['text']; ?></a>
                                <a href="#" class="send_name">ответить</a><br>
                                <span class="text-date"><?php echo $item['date']; ?></span>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--    --><?php //endforeach;
    ?>
<?php endif; ?>
<?php include("include/footer.php"); ?>
<!--присваиваем всем тегам img class="img-responsive"-->
<script>
    (function () {
        var img = document.getElementsByTagName('img');
        for (var i = img.length; i--;) {
            img[i].className += 'img-responsive';
        }
    })();
    <!--устанавливаем свойство 'auto' для высоты картинки из CKeditor -->
    var classHeight = document.getElementsByClassName('img-responsive');
    for (var i = 0; i < classHeight.length; i++) {
        classHeight[i].style.height = 'auto';
        classHeight[i].style.width = 100 + '%';
    }
    var classp = document.getElementsByTagName('p');
    for (var i = 0; i < classp.length; i++) {
        classp[i].style.textAlign = 'justify';
    }
</script>
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
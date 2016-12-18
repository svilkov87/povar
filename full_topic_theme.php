<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    if ($id === 0) {
        die('Ошибка сжатия чёрной дыры');
    }

    //Выбираем статьи относящиеся к этим тегам
    $st = $pdo->prepare('SELECT * FROM `forum_questions` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $topic = $st->fetchAll();
    $us_id = $topic[0]['user_id'];
    $topic_theme = $topic[0]['title'];
    $topic_date = $topic[0]['date'];

    //    просмотры
    $st = $pdo->prepare('SELECT `watches` FROM `forum_questions` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $watches = $st->fetchAll();
    $count_of_watches = $watches[0]['watches'];
    $count_of_watches++;

    $st = $pdo->prepare('UPDATE `forum_questions` SET watches=:watches WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->bindParam(':watches', $count_of_watches, PDO::PARAM_INT);
    $st->execute();

    //Выбираем автора статьи
    $stm = $pdo->prepare('SELECT * FROM `users` WHERE `id`=:id');
    $stm->bindParam(':id', $us_id, PDO::PARAM_INT);
    $stm->execute();
    $auth = $stm->fetchAll();


    //Выбираем комментарии
    $st = $pdo->prepare('SELECT * FROM `comments` WHERE topic_id=:topic_id ORDER BY id DESC ');
    $st->bindParam(':topic_id', $id, PDO::PARAM_INT);
    $st->execute();
    $comments = $st->fetchAll();
    $number_of_comments = count($comments);

    ##отправка комментариев r топику
    if (isset($_POST['enter_comment'])) {
        $text = $_POST['text'];
        $input_text = $_POST['input_text'];
        $input_theme = $_POST['input_theme'];
        $input_user_id = $_POST['input_user_id'];
        $input_user = $_POST['input_user'];
        $answer_for_comment = $_POST['answer_for_comment'];
        $insert = $pdo->prepare("
        INSERT INTO `comments`
        SET 
        text=:text,
        ava=:ava,
        topic_id=:topic_id,
        topic_theme=:topic_theme,
        to_comment=:to_comment,
        user_id=:user_id,
        user_id_art=:user_id_art,
        user_name=:user_name, 
        to_user=:to_user, 
        answer_for_comment=:answer_for_comment
        ");
        $insert->bindParam(':text', $text);
        $insert->bindParam(':topic_theme', $input_theme);
        $insert->bindParam(':to_comment', $input_text);
        $insert->bindParam(':to_user', $input_user_id);
        $insert->bindParam(':user_id_art', $input_user);
        $insert->bindParam(':user_name', $_SESSION['user_name']);
        $insert->bindParam(':ava', $_SESSION['ava']);
        $insert->bindParam(':topic_id', $id);
        $insert->bindParam(':user_id', $_SESSION['user_id']);
        $insert->bindParam(':answer_for_comment', $answer_for_comment);
        $insert->execute();
        header("Location: full_topic_theme.php?id=$id");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Форум</title>
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
<?php
?>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="add_topic.php" class="add_topic">
                <span class="add_text_topic">Добавить тему</span>
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
            <a href="forum.php" class="back_to_forum">
                <span class="add_text_topic">назад</span>
                <i class="fa fa-undo" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<div class="container forum_wrapp">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php foreach ($topic as $item): ?>
                <div class="theme_topic">
                    <div class="user_name_of_topic">
                        <a href="profile.php?id=<?php echo $item['user_id']; ?>">
                            <img src="img/avatars/<?php echo $item['user_ava']; ?>" class="img_user_forum">
                            <span class="user_name_link"><?php echo $item['user_name']; ?></span>
                        </a>
                    </div>
                    <div class="text_of_topic">
                        <h1 class="theme_topic_text"><?php echo $item['title']; ?></h1>
                    </div>

                    <div class="content_topic">
                        <div class="content_topic_middle">
                            <span class="desc_text_content"><?php echo $item['text']; ?></span>
                        </div>
                    </div>
                    <?php
                    if ($us_id == $_SESSION['user_id']):?>
                        <div class="content_topic">
                            <a href="edit_topic.php?id=<?php echo $item['id']; ?>"
                               class="edit_topic_link">Редактировать</a>
                        </div>
                    <?php endif; ?>
                    <div class="author_of_fullart">
                        <?php foreach ($auth as $item): ?>
                            <span class="name_auth">Автор:</span>
                            <a href="profile.php?id=<?php echo $item['id']; ?>"
                               class="name_auth"><?php echo $item['username']; ?></a>
                        <?php endforeach; ?>
                        <br>
                        <span class="date_auth"><?php echo $topic_date; ?></span>
                        <span class="count_watches">Просмотров:&nbsp;<b><?php echo $count_of_watches; ?></b></span>
                    </div>
                </div>

                <div class="comment_body">
                    <span class="span_answer">Комментариев&nbsp;<?php echo $number_of_comments; ?></span>
                </div>

            <?php endforeach; ?>

            <?php if (isset($_SESSION['email'])): ?>
                <div class="full_art_forms">
                    <div class="user_init_full">
                        <div class="user_photo">
                            <?php foreach ($auth as $key): ?>
                                <a href="profile.php?id=<?php echo $key['id']; ?>">
                                    <img src="img/avatars/<?php echo $_SESSION['ava']; ?>" class="ava_img_fullart">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <form method="post" action="">
                        <input readonly hidden type="text" name="input_text" id="answer_input">
                        <input readonly hidden type="text" name="input_theme" id="answer_input"
                               value="<?php echo $topic_theme; ?>">
                        <input readonly hidden type="text" name="input_user" id="answer_input"
                               value="<?php echo $us_id; ?>">
                        <input readonly hidden type="text" name="input_user_id" id="answer_input_to_user">
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
                </div>
            <?php else: ?>
                <div class="no_comment_body">
                    <p class="no_comment_p">Комментарии могут оставлять только зарегистрированные или авторизованные
                        пользователи</p>
                </div>
            <?php endif; ?>

            <div class="answers_panel">
                <?php foreach ($comments as $item): ?>
                    <div class="profile_link" role="answer_item_id" id="answer_item_id<?php echo $item['id']; ?>">
                        <div class="left_block_comment">
                            <div class="ava">
                                <div class="photo">
                                    <img src="img/avatars/<?php echo $item['ava']; ?>" class="ava_img_fullusart">
                                </div>
                            </div>
                        </div>
                        <div class="middle_content_comm">
                            <a href="profile.php?id=<?php echo $item['user_id']; ?>" class="user_name_ava">
                                <?php echo $item['user_name']; ?>
                            </a><br>
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
            <!--            <div class="author_of_fullart">-->
            <!--                --><?php //foreach($auth as $item): ?>
            <!--                    <span class="name_auth">Автор статьи:</span>-->
            <!--                    <a href="profile.php?id=--><?php //echo $item['id'];?><!--" class="name_auth">-->
            <?php //echo $item['username'];?><!--</a>-->
            <!--                --><?php //endforeach; ?>
            <!--            </div>-->
            <!--            </div>-->
            <!--            <div class="answer_topic">-->
            <!--                <div class="col-md-12">-->
            <!--                    <div class="row">-->
            <!--                        <form method="post" action="">-->
            <!--                            <input type="text" name="input_text" id="answer_input">-->
            <!--                            <input type="text" name="input_theme" id="answer_input" value="-->
            <?php //echo $topic_theme?><!--">-->
            <!--                            <input type="text" name="input_user" id="answer_input" value="-->
            <?php //echo $us_id;?><!--">-->
            <!--                            <input type="text" name="input_user_id" id="answer_input_to_user">-->
            <!--                            <textarea class="form-control" rows="3" name="answer_for_comment" id="answer_to_comment"></textarea>-->
            <!--                            <textarea class="form-control" rows="9" name="text" id="answer"></textarea>-->
            <!--                            <button class="btn_default" type="submit" name="enter_comment">Оставить комментарий</button>-->
            <!--                        </form>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="panel panel-info">-->
            <!--                --><?php //foreach ($comments as $item): ?>
            <!--                <div class="panel-heading" role="answer_item_id" id="answer_item_id-->
            <?php //echo $item['id'];?><!--">-->
            <!--                    <a href="#" id="hidden_id">--><?php //echo $item['id'];?><!--</a>-->
            <!--                    <a href="#" id="hidden_id_to_user">--><?php //echo $item['user_id'];?><!--</a>-->
            <!--                    <a href="#" id="hidden_text_to_comment">--><?php //echo $item['text'];?><!--</a>-->
            <!--                    <a href="profile.php?id=-->
            <?php //echo $item['user_id'];?><!--" class="p" id="answer_item_id--><?php //echo $item['id'];?><!--">-->
            <!--                        --><?php //echo $item['user_name'];?>
            <!--                    </a>-->
            <!--                    --><?php //echo $item['text'];?>
            <!--                    <a href="#" class="send_name">ответить</a>-->
            <!--                </div>-->
            <!--                --><?php //endforeach;?>
            <!--            </div>-->
        </div>
    </div>
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
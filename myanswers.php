<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);

    // если зло вручную поставит другой id пользвателя, то он не попадет на чужую страницу с ответами
        if ($id === 0 OR $id != $_SESSION['user_id']) {
//        die('Ошибка сжатия чёрной дыры');
            header("Location: http://impovar.tt90.ru/home");
            exit;
    }

//    echo "<pre>";
//    var_dump($_SESSION['user_id']);
//    echo "</pre>";
//
//    echo "<pre>";
//    var_dump($id);
//    echo "</pre>";

    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $user_image = $profile_data[0]['ava'];
    if ($user_image == "") {
        $user_image = "no_ava.png";
    }


    ##ответы к моим комментариям
    $stm = $pdo->prepare('SELECT * FROM `comments` WHERE user_id_art =:user_id_art AND user_id_art != user_id OR to_user=:to_user ORDER BY `id` DESC ');
    $stm->bindParam(':user_id_art', $id, PDO::PARAM_INT);
    $stm->bindParam(':to_user', $id, PDO::PARAM_INT);
    $stm->execute();
    $user_from = $stm->fetchAll();


    $number_of_answer = count($user_from);

//    ##ответы к моим комментариям
    $art_array = array_column($user_from, 'article_id');
    $art_string = implode(",", $art_array);
    $user_id_art = $user_from[0]['user_id_art'];
//    $user_id = $user_from[0]['user_id'];

}
//
//echo "<pre>";
//var_dump($result_one);
//echo "</pre>";
////
//echo "<pre>";
//var_dump($_SERVER['REQUEST_URI']);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($NullValue);
//echo "</pre>";

//проверка, существует ли такая статья. удалял ли ее автор или не

if (!isset($_SESSION['email'])) {
    header("Location: http://impovar.tt90.ru/home");
    exit;
}

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
    <link rel="shortcut icon" href="http://impovar.tt90.ru/img/favicon/favicon.ico"/>
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
<?php include("include/nav.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
            <div class="chapters_of_answers">
                <span class="span_answer">Уведомления</span>
                <span class="span_answer_number">
                    <a href="http://impovar.tt90.ru/profile/<?php echo $user_id_art; ?>">Назад к профилю</a>
                </span>
            </div>
            <?php
            if ($user_id_art == ""):?>
                <div class="chapters_of_answers">
                    <span class="span_answer">У Вас пока нет уведомлений...</span>
                </div>
            <?php endif; ?>
            <?php foreach ($user_from as $item):
            //если есть новые сообщения, помечаем их цветом
                if ($item['count_isnew'] == 1):
                ?>
                <div class="wrapp_answer" style="background-color: rgba(140, 174, 199, 0.12);">

                    <?php else: ?>
                    <div class="wrapp_answer">

                    <?php endif;?>
<!--                    --><?php //echo $item['count_isnew']; ?>
                    <div class="block_left_answer">
                        <p class="myanswer_pext_p"><?php echo $item['text']; ?></p><br>
                        <span class="who_is_answer">Написал:</span>
                        <a href="http://impovar.tt90.ru/profile/<?php echo $item['user_id']; ?>">
                            <b><?php echo $item['user_name']; ?>:</b>
                        </a>
                        <br>
                        <?php
                        //если ответ был к статье
                        if ($item['to_comment'] == 0 AND $item['article_id'] != 0):?>
                            <span class="date_answer"><?php echo $item['date']; ?></span><br>

                            <?php
                        //если ответ был к комментарию
                        elseif ($item['to_comment'] != 0):?>
                            <span class="who_is_answer">Ответ на коммент</span>
                            <span class="answer_before">
                                <a href="http://impovar.tt90.ru/article/<?php echo $item['article_id']; ?>#answer_item_id<?php echo $item['id']; ?>">
                                    <?php echo $item['answer_for_comment']; ?>
                                </a>
                            </span>
                            <br>
                            <span class="date_answer"><?php echo $item['date']; ?></span><br>

                            <?php
                        //если ответ был к топику
                        elseif ($item['topic_id'] != 0):?>
                            <span class="who_is_answer">Ответ к топику</span>
                            <br>
                            <span class="date_answer"><?php echo $item['date']; ?></span><br>


                            <?php
                        //если ответ был к комменту в топике
                        elseif ($item['article_id'] == 0 && $item['to_comment'] != 0):?>
                            <span class="answer_before">ответ к комменту на топик</span>
                            <span><?php echo $item['topic_theme']; ?></span>
                            <br>
                            <span class="date_answer"><?php echo $item['date']; ?></span><br>
                        <?php endif; ?>


                    </div>
                    <?php
                    //вывод правой части уведомления
                    if ($item['topic_id'] != 0):?>
                        <div class="block_right_answer_topic">
                            <a href="http://impovar.tt90.ru/topictheme/<?php echo $item['topic_id']; ?>#answer_item_id<?php echo $item['id']; ?>">
                                <span class="who_is_answer"><?php echo $item['topic_theme']; ?></span>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="block_right_answer">
                            <a href="http://impovar.tt90.ru/article/<?php echo $item['article_id']; ?>#answer_item_id<?php echo $item['id']; ?>">
                                <span class="who_is_answer">Рецепт</span>
                                <img src="http://impovar.tt90.ru/admin/images/<?php echo $item['article_intro_image']; ?>" alt=""
                                     class="answer_intro_image">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
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
</html>
</body>
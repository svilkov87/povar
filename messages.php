<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);

    // если зло вручную поставит другой id пользвателя, то он не попадет на чужую страницу с ответами
    if ($id === 0 OR $id != $_SESSION['user_id']) {
//        die('Ошибка сжатия чёрной дыры');
        header("Location: http://impovar.tt90.ru/home");
        exit;
    }

    ##превью сообщений

    //получаем мы
    $stm = $pdo->prepare('SELECT MAX(id) FROM `messages` WHERE to_us =:to_us OR from_us =:from_us GROUP BY dialog_id ');
    $stm->bindParam(':to_us', $id, PDO::PARAM_INT);
    $stm->bindParam(':from_us', $id, PDO::PARAM_INT);
    $stm->execute();
    $MyMess = $stm->fetchAll();

    ## Многомерный массив превращаем в строку
    $StringArray = array();
    for ($i = 0; $i < count($MyMess); $i++) {
        $StringArray[] = $MyMess[$i]['MAX(id)'];
    }

    ## Превращение одномерного массива в строку
    $StringTag = implode(',', $StringArray);

    ## вывод результата
    $NameTags = $pdo->query('SELECT from_us, to_us, text FROM `messages` WHERE `id` IN ('.$StringTag.') AND from_us != to_us ORDER BY id ASC')->fetchAll();

//    $ImageMess = $pdo->query('SELECT dialog_id FROM `messages` WHERE  from_us = dialog_id /'.$id.' OR to_us = dialog_id /'.$id.' AND from_us != to_us  GROUP BY dialog_id')->fetchAll();
//
//    ## Многомерный массив превращаем в строку
//    $StringUserData = array();
//    for ($i = 0; $i < count($ImageMess); $i++) {
//        $StringUserData[] = $ImageMess[$i]["dialog_id"] / $id;
//    }
//
//    ## Превращение одномерного массива в строку
//    $UserData = implode(',', $StringUserData);
//
//    $ImageUser = $pdo->query('SELECT id, username FROM `users` WHERE  id IN ('.$UserData.')')->fetchAll();



}


//echo "<pre>";
//var_dump($ImageUser);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($NameTags);
//echo "</pre>";

//echo "<pre>";
//var_dump($result);
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
    <title>Личные Сообщения</title>
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
                <span class="span_answer_number">
                    <a href="http://impovar.tt90.ru/profile/<?php echo $_SESSION['user_id']; ?>">Назад к профилю</a>
                </span>
                <span class="span_answer">Личные сообщения</span>
            </div>
                <?php foreach ($NameTags as $item):?>
                    <a href="http://impovar.tt90.ru/fmess/<?php echo $item['dialog_id']; ?>/<?php echo $_SESSION['user_id']; ?>">
            <div class="wrapp_message">
                <img src="http://impovar.tt90.ru/img/avatars/<?php echo $item['user_image']; ?>" class="ava_img_litmess">
                <span class="span_answer"><?php echo $item['from_us_name'];?></span>
                    <p><?php echo $item['text'];?></p>
            </div>
                    </a>
                <?php endforeach;?>
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
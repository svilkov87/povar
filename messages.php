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
    $stm = $pdo->prepare('SELECT * FROM `messages` WHERE to_us =:to_us ORDER BY `id` DESC ');
    $stm->bindParam(':to_us', $id, PDO::PARAM_INT);
    $stm->execute();
    $MyMess = $stm->fetchAll();


//    $number_of_answer = count($user_from);
//
////    ##ответы к моим комментариям
//    $art_array = array_column($user_from, 'article_id');
//    $art_string = implode(",", $art_array);
//    $user_id_art = $user_from[0]['user_id_art'];

}
//
//echo "<pre>";
//var_dump($MyMess);
//echo "</pre>";
////
echo "<pre>";
var_dump($_SERVER['REQUEST_URI']);
echo "</pre>";
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
        <?php foreach ($MyMess as $item):?>
        <p><?php echo $item['text'];?></p>
            <span><?php echo $item['from_us_name'];?></span>
        <?php endforeach;?>

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
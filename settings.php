<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    if ($id === 0) {
        die('Ошибка сжатия чёрной дыры');
    }

    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $name_info = $profile_data[0]['username'];
    $sex_info = $profile_data[0]['sex'];
    $intro_image = $profile_data[0]['ava'];
    $about = $profile_data[0]['about'];
    $proff_info = $profile_data[0]['profession'];
    if ($proff_info == "") {
        $proff_info = "Не указано";
    }
    $food_info = $profile_data[0]['fav_food'];
    if ($food_info == "") {
        $food_info = "Не указано";
    }
    $hobby_info = $profile_data[0]['hobby'];
    if ($hobby_info == "") {
        $hobby_info = "Не указано";
    }

    if ($sex_info == 1) {
        $sex = "Мужской";
        $ava = "ava_men.png";
    } elseif ($sex_info == 2) {
        $sex = "Женский";
        $ava = "ava_woman.png";
    } else {
        $sex = "Не выбран";
    }


//    считаем количество рецептов
//    $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id');
//    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
//    $st->execute();
//    $art_column = $st->fetchColumn();

//    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ORDER BY id DESC');
//    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
//    $st->execute();
//    $art_of_user = $st->fetchAll();

//редактура настроек
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['button_newsettings'])) {
        $input_name = $_POST['input_name'];
        $sex = $_POST["sex"];
        $about = $_POST["about_me"];
        $fav_food = $_POST["food"];
        $proff = $_POST["proff"];
        $hobby = $_POST["hobby"];
        $insert = $pdo->prepare("
            UPDATE 
            `users` 
            SET 
            username=:username, 
            sex=:sex, 
            about=:about, 
            fav_food=:fav_food, 
            profession=:profession, 
            hobby=:hobby, 
            ava=:ava 
            WHERE 
            id=:id
            ");
        $insert->bindParam(':username', $input_name);
        $insert->bindParam(':id', $user_id);
        $insert->bindParam(':ava', $ava);
        $insert->bindParam(':sex', $_POST["sex"]);
        $insert->bindParam(':about', $about);
        $insert->bindParam(':fav_food', $fav_food);
        $insert->bindParam(':profession', $proff);
        $insert->bindParam(':hobby', $hobby);
        $insert->execute();
        header("Location: profile.php?id=$user_id");
        exit();
    }

}
//echo "<pre>";
//var_dump($intro_image);
//echo "</pre>";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
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
    <link rel="shortcut icon" href="img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="remodal/remodal.css">
    <link rel="stylesheet" href="remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/media.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>
<html>
<?php include("include/nav.php"); ?>
<div class="container">
    <div class="row">
        <div class="settings_wrapper">
            <div class="settings_block_header">
                <span class="sett_header">Управление профилем</span>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="block_settings_item">
                    <span class="sett_chapters">Ваше имя</span><br>
                    <input type="text" name="input_name" class="name_sett_input" value="<?php echo $name_info; ?>">
                </div>
                <div class="block_settings_item">
                    <span class="sett_chapters">Пол</span><br>
                    <?php foreach ($profile_data as $item): ?>
                        <select name="sex" class="sex_select">
                            <option value="1">Мужской</option>
                            <option value="2">Женский</option>
                        </select>
                    <?php endforeach; ?>
                </div>
                <div class="block_settings_item">
                    <span class="sett_chapters">Расскажите о себе, вкратце:</span><br>
                    <textarea name="about_me" class="about_me_textarea"></textarea>
                </div>
                <div class="block_settings_item">
                    <span class="sett_chapters">Ваше любимое блюдо</span><br>
                    <input type="text" name="food" class="name_sett_input" value="<?php echo $food_info; ?>">
                </div>
                <div class="block_settings_item">
                    <span class="sett_chapters">Ваша профессия</span><br>
                    <input type="text" name="proff" class="name_sett_input" value="<?php echo $proff_info; ?>">
                </div>
                <div class="block_settings_item">
                    <span class="sett_chapters">Ваше Хобби</span><br>
                    <input type="text" name="hobby" class="name_sett_input" value="<?php echo $hobby_info; ?>">
                </div>

                <div class="block_margin">
                    <button type="submit" name="button_newsettings" class="btn_sett">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("include/footer.php"); ?>
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
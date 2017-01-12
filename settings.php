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

//    if ($sex_info == 1) {
//        $sex = "Мужской";
////        $ava = "ava_men.png";
//    } elseif ($sex_info == 2) {
//        $sex = "Женский";
////        $ava = "ava_woman.png";
//    } else {
//        $sex = "Не выбран";
//    }

//редактура настроек
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['button_newsettings'])) {
        $input_name = $_POST['input_name'];
        $_SESSION['user_name'] = $input_name;
        $sex = $_POST["sex"];
        $about = $_POST["about_me"];
        $fav_food = $_POST["food"];
        $proff = $_POST["proff"];
        $hobby = $_POST["hobby"];
        if (isset ($_FILES['image'])) {
//            $test = "02929202";
//            $image_name = $test . $_FILES['image']['name'];
            $image_name = $_FILES['image']['name'];
            $_SESSION['ava'] = $image_name;
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload = "img/avatars/";
            move_uploaded_file($image_tmp, $upload . $image_name);
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
            $insert->bindParam(':ava', $image_name);
            $insert->bindParam(':sex', $_POST["sex"]);
            $insert->bindParam(':about', $about);
            $insert->bindParam(':fav_food', $fav_food);
            $insert->bindParam(':profession', $proff);
            $insert->bindParam(':hobby', $hobby);
            $insert->execute();


            //обновляем все ранее оставленные в комментах аватарки

            $update = $pdo->prepare("UPDATE `comments` SET ava=:ava, user_name=:user_name WHERE user_id=:user_id");
            $update->bindParam(':ava', $image_name);
            $update->bindParam(':user_name', $input_name);
            $update->bindParam(':user_id', $_SESSION['user_id']);
            $update->execute();

            //обновляем все ранее оставленные в заголовках топиков аватарки
            $updateOnForum = $pdo->prepare("UPDATE `forum_questions` SET user_ava=:user_ava, user_name=:user_name WHERE user_id=:user_id");
            $updateOnForum->bindParam(':user_ava', $image_name);
            $updateOnForum->bindParam(':user_name', $input_name);
            $updateOnForum->bindParam(':user_id', $_SESSION['user_id']);
            $updateOnForum->execute();


//            header("Location: http://impovar.tt90.ru/profile/$user_id");
            header("Location: http://".$_SERVER['HTTP_HOST']."/profile/".$user_id);
            exit();

//            echo "<pre>";
//            var_dump($image_name);
//            echo "</pre>";
        }
    }
}


if (!isset($_SESSION['email'])) {
//    header("Location: http://impovar.tt90.ru/home");
    header("Location: http://".$_SERVER['HTTP_HOST']."/home");
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
<div class="container-fluid center_wrapp"">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6">
            <div class="row">
                <!--                <div class="settings_wrapper">-->
                <div class="settings_wrap">
                    <div class="settings_block_header">
                        <span class="sett_header">Управление профилем</span>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="block_settings_item">
                            <span class="sett_chapters">Ваше имя</span><br>
                            <input type="text" name="input_name" class="name_sett_input"
                                   value="<?php echo $name_info; ?>">
                            <div class="block_settings_pass_title">
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/changepass/<?php echo $_SESSION['user_id']; ?>/">
                                    <span class="sett_chapters">Изменить пароль</span><br>
                                </a>
                            </div>
                        </div>
                        <!--                <div class="block_settings_item">-->
                        <!--                    <span class="sett_chapters">Пол</span><br>-->
                        <!--                    --><?php //foreach ($profile_data as $item): ?>
                        <!--                        <select name="sex" class="sex_select">-->
                        <!--                            <option value="1">Мужской</option>-->
                        <!--                            <option value="2">Женский</option>-->
                        <!--                        </select>-->
                        <!--                    --><?php //endforeach; ?>
                        <!--                </div>-->

                        <div class="block_settings_item">
                            <span class="sett_chapters">Загрузить фото</span><br>
                            <input type="file" name="image" class="preview_file" value="<?php echo $intro_image; ?>">
                        </div>

                        <div class="block_settings_item">
                            <span class="sett_chapters">Расскажите о себе, вкратце:</span><br>
                            <input type="text" name="about_me" class="about_me_textarea" value="<?php echo $about; ?>">
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
        <?php include("include/menu_open.php"); ?>
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
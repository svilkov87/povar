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
    $user_image = $profile_data[0]["ava"];
    if ($user_image == "") {
        $user_image = "no_ava.png";
    }


    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $intro_image = $profile_data[0]['ava'];
    if ($intro_image == "") {
        $intro_image = "no_ava.png";
    }
    $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ORDER BY id DESC');
    $st->bindParam(':user_id', $id, PDO::PARAM_INT);
    $st->execute();
    $art_of_user = $st->fetchAll();


//добавление статьи. если стаью добавляет админ, то записываем в таблицу article
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
//if(isset($_POST['button_newarticle']) AND $user_id != 14){
    if (isset($_POST['button_newarticle'])) {
        $title = $_POST['title'];
        $text = $_POST['text'];
        if (isset ($_FILES['image'])) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload = "admin/images/";
            move_uploaded_file($image_tmp, $upload . $image_name);
            if ($_FILES["image"]["name"] == "") {
                $image_name = "no_intro.png";
            }
            $insert = $pdo->prepare
            ("
        INSERT INTO 
        `article` 
        SET 
        title=:title,  
        user_id=:user_id, 
        user_name=:user_name, 
        intro_image=:intro_image, 
        text=:text
        ");
            $insert->bindParam(':title', $title);
            $insert->bindParam(':text', $text);
            $insert->bindParam(':user_id', $user_id);
            $insert->bindParam(':user_name', $user_name);
            $insert->bindParam(':intro_image', $image_name);
            $insert->execute();

            //    Считаем общее количество статей
            $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id');
            $st->bindParam(':user_id', $id, PDO::PARAM_INT);
            $st->execute();
            $art_column = $st->fetchColumn();

            //    обновляем статистику в таблице пользователей
            $update = $pdo->prepare("
        UPDATE 
        `users` 
        SET 
        count_of_articles =:count_of_articles
        WHERE 
        id=:id");
            $update->bindParam(':count_of_articles', $art_column);
            $update->bindParam(':id', $id);
            $update->execute();


            header("Location: http://impovar.tt90.ru/profile/$user_id");
            exit;

//    echo '<pre>';
//    var_dump($_FILES["image"]["name"]);
//    echo '</pre>';


        }
    }
}

//echo "<pre>";
//var_dump($profile_data);
//echo "</pre>";
//
//echo '<pre>';
//var_dump($user_image);
//echo '</pre>';

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
    <title>Добавить статью</title>
    <script src="http://impovar.tt90.ru/admin/ckeditor/ckeditor.js"></script>
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
<div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6" style="margin-bottom: 25px; background: #eeeff2;">
            <div class="chapters_of_answers">
                <span class="span_answer">Раздел добавления статьи</span>
            </div>
            <div class="wrapp_add_art">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="label_admin_user">Заголовок статьи</label>
                        <input type="text" class="form-control" name="title" id="field1"
                               placeholder="Введите название статьи">
                    </div>
                    <!--загрузка картинок-->
                    <div class="form-group">
                        <label class="label_admin_user">Превью-фото</label>
                        <input type="file" name="image" class="preview_file">
                    </div>
                    <!--/загрузка картинок-->

                    <div class="form-group">
                        <label class="label_admin_user">Содержание статьи</label>
                        <textarea rows="10" cols="20" class="form-control" name="text" id="text"
                                  placeholder="Пишите вашу стаью"></textarea>
                    </div>
                    <button type="submit" name="button_newarticle" class="btn_default">Разместить</button>
                </form>
            </div>
        </div>
        <?php include("include/menu_open.php"); ?>
    </div>
</div>
<?php include("include/footer.php"); ?>
<script>
    CKEDITOR.replace("text");
</script>
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
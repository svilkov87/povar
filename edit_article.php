<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if (!empty($_GET)) {

    $id = intval($_GET['id']);
    $user = intval($_GET['user']);
//Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $user, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $user_image = $profile_data[0]['ava'];
    if ($user_image == "") {
        $user_image = "no_ava.png";
    }

    //выборка для вставки в форму для редактирования
    $stmt = $pdo->prepare('SELECT * FROM `article` WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $title = $row['title'];
    $text = $row['text'];
    $intro_image = $row['intro_image'];


//редактирование статьи
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    if (isset($_POST['button_newarticle'])) {
        $title = strip_tags($_POST['title']);
        $text = $_POST['text'];
        $id = $_GET['id'];
        if (isset ($_FILES['image'])) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload = "admin/images/";
            move_uploaded_file($image_tmp, $upload . $image_name);
            if ($_FILES["image"]["name"] == "") {
                $image_name = "no_intro.png";
            }
            $update = $pdo->prepare
            ("
        UPDATE 
        `article` 
        SET 
        title=:title, 
        text=:text,
        user_name=:user_name, 
        intro_image=:intro_image 
        WHERE 
        id=:id");
            $update->bindParam(':title', $title);
            $update->bindParam(':text', $text);
            $update->bindParam(':user_name', $user_name);
            $update->bindParam(':intro_image', $image_name);
            $update->bindParam(':id', $id);
            $update->execute();
            header("Location: http://".$_SERVER['HTTP_HOST']."/profile/".$user_id);
            exit;
        }
    }
}

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
    <title>Редактировать статью</title>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/ckeditor/ckeditor.js"></script>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/remodal/remodal.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/fonts.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/main.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/media.css"/>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/css/bootstrap.min.css"/>
</head>
<body>
<html>
<?php include("include/nav.php"); ?>
<div class="container-fluid center_wrapp">
    <div class="row">
        <?php include("include/block_fix.php"); ?>
        <div class="col-md-6" style="margin-bottom: 25px; background: #eeeff2;">
            <div class="chapters_of_answers">
                <span class="span_answer">Раздел редактирования статьи</span>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="label_admin_user">Заголовок статьи</label>
                    <input type="text" class="form-control" name="title" id="field1"
                           placeholder="Введите название статьи" value="<?php echo $title; ?>">
                </div>

                <div class="form-group">
                    <label class="label_admin_user">Превью-фото</label>
                    <input type="file" name="image" class="preview_file">
                </div>

                <div class="form-group">
                    <label class="label_admin_user">Содержание статьи</label>
                    <textarea rows="10" cols="20" class="form-control" name="text" id="text"
                              placeholder="Пишите вашу стаью">
                        <?php echo $text; ?>
                    </textarea>
                </div>
                <button type="submit" name="button_newarticle" class="btn_default">Редактировать</button>
            </form>
        </div>
        <?php include("include/menu_open.php"); ?>
    </div>
</div>

<?php include("include/footer.php"); ?>
<script>
    CKEDITOR.replace("text");
</script>

<!--[if lt IE 9]-->
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/es5-shim.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/html5shiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/respond/respond.min.js"></script>
<!--[endif]-->
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/jquery/jquery-1.11.1.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/fancybox/jquery.fancybox.pack.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/waypoints/waypoints-1.6.2.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/scrollto/jquery.scrollTo.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/owl-carousel/owl.carousel.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.plugin.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown.min.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/countdown/jquery.countdown-ru.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/libs/landing-nav/navigation.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/common.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/main.js"></script>
<script src="http://http://<?php echo $_SERVER['HTTP_HOST']; ?>/js/bootstrap.min.js"></script>
</html>
</body>
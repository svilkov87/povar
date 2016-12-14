<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(!empty($_GET)) {

    $id = intval($_GET['id']);
    //Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $id, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $intro_image = $profile_data[0]['ava'];
    if ($intro_image == ""){
        $intro_image = "no_ava.png";
    }
        $st = $pdo->prepare('SELECT * FROM `article` WHERE user_id=:user_id ORDER BY id DESC');
        $st->bindParam(':user_id', $id, PDO::PARAM_INT);
        $st->execute();
        $art_of_user = $st->fetchAll();

//    Считаем общее количество статей
        $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id');
        $st->bindParam(':user_id', $id, PDO::PARAM_INT);
        $st->execute();
        $art_column = $st->fetchColumn();
}

//добавление статьи. если стаью добавляет админ, то записываем в таблицу article
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
//if(isset($_POST['button_newarticle']) AND $user_id != 14){
if(isset($_POST['button_newarticle'])){
    $title = $_POST['title'];
    $text = $_POST['text'];
    if(isset ($_FILES['image'])){
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload = "admin/images/";
        move_uploaded_file($image_tmp, $upload.$image_name);
//        $insert = $pdo->prepare("INSERT INTO `article_from_users` SET title=:title,  user_id=:user_id, intro_image=:intro_image, text=:text, name=:name");
        $insert = $pdo->prepare("INSERT INTO `article` SET title=:title,  user_id=:user_id, user_name=:user_name,intro_image=:intro_image, text=:text");
        $insert->bindParam(':title', $title);
        $insert->bindParam(':text', $text);
        $insert->bindParam(':user_id', $user_id );
        $insert->bindParam(':user_name', $user_name);
        $insert->bindParam(':intro_image', $image_name);
        $insert->execute();
//        header("Location: ".$_SERVER["HTTP_REFERER"]);
        header("Location: profile.php?id=$user_id");
        exit;

//    echo '<pre>';
//    var_dump($_FILES);
//    echo '</pre>';
    }

}

//echo "<pre>";
//var_dump($user_name);
//echo "</pre>";

?>

<!DOCTYPE html>
<!--[if lt IE 7]><html lang="ru" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="ru" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="ru" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ru">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>IMPOVAR</title>
    <script src="admin/ckeditor/ckeditor.js"></script>
    <meta name="description" content="IMPOVAR" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/favicon/favicon.ico" />
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="remodal/remodal.css">
    <link rel="stylesheet" href="remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/media.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<html>
<?php include("include/nav.php");?>
<div class="container">
    <div class="row">
        <div class="col-md-4 ava_block">
            <a href="#">
                <img src="img/avatars/<?php echo $intro_image; ?>" class="ava_img">
            </a>
        </div>
        <div class="col-md-8" style="margin-bottom: 25px;">
            <div class="profile_panel">
                <?php foreach($profile_data as $item):?>
                <div class="panel_heading">
                    <span class="name_of_user_profile"><?php echo $item['username']; ?></span>
                    <br>
                    <a href="#">изменить статус</a>
                </div>
                <?php endforeach;?>
                <div class="panel-body">
                    <div class="col-md-2 panel_items">
                        <span class="panel_items_number"><?php echo $art_column; ?></span>
                        <span class="panel_items_text">рецепт(ов)</span>
                    </div>
                    <div class="col-md-2 panel_items">2</div>
                    <div class="col-md-2 panel_items">3</div>
                    <div class="col-md-2 panel_items">4</div>
                </div>
            </div>

<!--        <div class="col-md-8">-->
            <div class="wrapp_add_art">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" id="field1" placeholder="Введите название статьи">
                    </div>
                    <!--загрузка картинок-->
                    <div class="form-group">
                        <input type="file" name="image" class="preview_file">
                    </div>
                    <!--/загрузка картинок-->

                    <div class="form-group">
                        <label class="label_admin">Текст статьи</label>
                        <textarea class="form-control" name="text" id="text" placeholder="Пишите вашу стаью"></textarea>
                    </div>
                    <button type="submit" name="button_newarticle"  class="btn_default" style="    margin-bottom: 125px;">Отправить</button>
                </form>
            </div>
        </div>
    </div>

<!---->
<!---->
<!--        </div>-->
<!---->
<!---->
<!---->
<!--    </div>-->
<!--</div>-->

<?php include("include/footer.php");?>
<script>
    CKEDITOR.replace("text");
</script>
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
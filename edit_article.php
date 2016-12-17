<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(!empty($_GET)) {

    $id = intval($_GET['id']);
    $user = intval($_GET['user']);
//Выбираем юзера, чей аккаунт
    $st = $pdo->prepare('SELECT * FROM `users` WHERE id=:id');
    $st->bindParam(':id', $user, PDO::PARAM_INT);
    $st->execute();
    $profile_data = $st->fetchAll();
    $user_image = $profile_data[0]['ava'];
    if ($user_image == ""){
        $user_image = "no_ava.png";
    }

    //    Считаем общее количество статей
        $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id');
        $st->bindParam(':user_id', $user, PDO::PARAM_INT);
        $st->execute();
        $art_column = $st->fetchColumn();

    //выборка для вставки в форму для редактирования
        $stmt = $pdo ->prepare('SELECT * FROM `article` WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $title = $row['title'];
        $text = $row['text'];
        $intro_image = $row['intro_image'];

}

//редактирование статьи
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
if(isset($_POST['button_newarticle'])){
    $title = strip_tags($_POST['title']);
    $text = $_POST['text'];
    $id = $_GET['id'];
    if(isset ($_FILES['image'])){
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload = "admin/images/";
        move_uploaded_file($image_tmp, $upload.$image_name);
        if($_FILES["image"]["name"] == ""){
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
        header("Location: profile.php?id=$user_id");
        exit();
    }
}

echo '<pre>';
var_dump($user_image);
echo '</pre>';


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
    <title>Редактировать статью</title>
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
            <a href="profile.php?id=<?php echo $_SESSION['user_id'];?>">
                <img src="img/avatars/<?php echo $user_image; ?>" class="ava_img">
            </a>
        </div>
        <div class="col-md-8" style="margin-bottom: 25px; background: #eeeff2;">
            <div class="profile_panel">
                <div class="panel_heading">
                    <?php foreach($profile_data as $item):?>
                        <span class="name_of_user_profile"><?php echo $item['username']; ?></span>
                        <br>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="chapters_of_answers">
                <span class="span_answer">Раздел добавления статьи</span>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="label_admin_user">Заголовок статьи</label>
                    <input type="text" class="form-control" name="title" id="field1" placeholder="Введите название статьи" value="<?php echo $title; ?>">
                </div>

                <div class="form-group">
                    <label class="label_admin_user">Превью-фото</label>
                    <input type="file" name="image" class="preview_file">
                </div>

                <div class="form-group">
                    <label class="label_admin_user">Текст статьи</label>
                    <textarea class="form-control" name="text" id="text" placeholder="Пишите вашу стаью">
                        <?php echo $text;?>
                    </textarea>
                </div>
                <button type="submit" name="button_newarticle"  class="btn btn-success" style="    margin-bottom: 125px;">Отправить</button>
            </form>
    </div>
</div>
</div>
</div>

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
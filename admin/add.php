<?php
include ("../include/connection.php");
session_start();
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//выбор всех статей
$st = $pdo->query('SELECT * FROM `article` ORDER BY id DESC ');
$article = $st->fetchAll();

//Считаем общее количество статей
$art = $pdo->query('SELECT COUNT(*) FROM `article`')->fetchColumn();

//Считаем общее количество статей пользователей
$count_of_users = $pdo->query('SELECT COUNT(*) FROM `article`')->fetchColumn();

//Считаем общее количество зарегистрированных пользователей
$users = $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();

//Считаем общее количество комментов
$comments = $pdo->query('SELECT COUNT(*) FROM `comments`')->fetchColumn();

//посмотреть последнюю статью
$auth = $pdo->prepare('SELECT max(id) FROM `article`');
$auth->execute();
$last = $auth->fetchAll();
$last_article = implode('', $last[0]);

//вывод категорий
$st = $pdo->query('SELECT * FROM `category`');
$tags = $st->fetchAll();

//if ($_POST['auth'] == 0){
//    $_POST['auth'] = "Рецепты от Георгия";
//    $auth_id = 0;
//}
//elseif ($_POST['auth'] == 1) {
//    $_POST['auth'] = "Криулев Юрий";
//    $auth_id = 1;
//}




//добавление статьи
$user_id = $_SESSION['user_id'];
//$user_name = $_SESSION['user_name'];
if(isset($_POST['button_newarticle'])){

//    здесь пи***дец от Админа

    $cat_id = $_POST['cat'];
//    автор куку админ
    if ($cat_id <= 3){
        $mainCatId = 1;
    }
    if ($cat_id >=7 AND $cat_id <= 12){
        $mainCatId = 1;
    }
//    автор не не админ
    if ($cat_id == 4){
        $mainCatId = 2;
    }
    if ($cat_id == 5 OR $cat_id == 6){
        $mainCatId = 2;
    }
    if ($cat_id >=13 AND $cat_id <= 47){
        $mainCatId = 2;
    }

//    $one = 2;
//    $insert = $pdo->prepare("UPDATE `article` SET main_id=:main_id WHERE cat_id >=13 AND cat_id <= 47");
//    $insert->bindParam(':main_id', $one);
//    $insert->execute();


    $title = $_POST['title'];
    $text = $_POST['text'];
    $intro_text = $_POST['intro_text'];
//    $auth = $_POST['auth'];
        if(isset ($_FILES['image'])){
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload = "images/";
            move_uploaded_file($image_tmp, $upload.$image_name);
    $insert = $pdo->prepare("
    INSERT INTO
    `article`
    SET
    title=:title,
    user_id=:user_id,
    intro_image=:intro_image,
    intro_text=:intro_text,
    text=:text,
    main_id=:main_id,
    cat_id=:cat_id
    ");
    $insert->bindParam(':title', $title);
    $insert->bindParam(':text', $text);
//    $insert->bindParam(':author', $auth);
//    $insert->bindParam(':author_id', $auth_id);
    $insert->bindParam(':intro_text', $intro_text);
    $insert->bindParam(':cat_id', $_POST["cat"] );
    $insert->bindParam(':main_id', $mainCatId );
    $insert->bindParam(':user_id', $user_id );
    $insert->bindParam(':intro_image', $image_name);
    $insert->execute();
    header('Location: admin.php');

//    echo '<pre>';
//    var_dump($_FILES);
//    echo '</pre>';
    }

}

//
//    echo '<pre>';
//    var_dump($test);
//    echo '</pre>';


//    echo '<pre>';
//    var_dump($cat_id);
//    echo '</pre>';
//
//    echo '<pre>';
//    var_dump($mainCatId);
//    echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Добавить статью</title>
    <script src="ckeditor/ckeditor.js"></script>
    <meta name="description" content="IMPOVAR" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="../libs/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../libs/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="../libs/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="../libs/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="../remodal/remodal.css">
    <link rel="stylesheet" href="../remodal/remodal-default-theme.css">
    <link rel="stylesheet" href="../css/bootstrap.min1.css" />
    <script type="text/javascript" src="../js/modernizr.custom.86080.js"></script>
</head>
<body>
<style>
    #textarea{
        height: 100px; /* Высота поля в пикселах */
        resize: none; /* Запрещаем изменять размер */
    }
</style>
<?php include ("include/admin_nav.php");?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="admin.php">
                                <button type="button" class="btn btn-default">
                                    Вернуться
                                </button>
                            </a>
                            <div class="alert alert-default">
                                <div class="row">
                                <strong>Раздел добавления статьи</strong>
                                </div>
                            </div>
            <form method="post" action="add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" id="field1" placeholder="Введите название статьи">
                </div>
                <div class="form-group">
                    <label class="label_admin">Категории</label>
                    <br>
                    <select name="cat">
                        <?php foreach($tags as $item): ?>
                            <option value="<?php echo $item['article_id'];?>"><?php echo $item['title'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
<!--                    <p><input type="submit" value="Выбрать"></p>-->
<!--                <div hidden class="form-group">-->
<!--                    <label class="label_admin">Автор</label>-->
<!--                    <br>-->
<!--                    <select name="auth">-->
<!--                            <option value="0">Криулев Юрий</option>-->
<!--                            <option value="1">Рецепты от Георгия</option>-->
<!--                    </select>-->
<!--                </div>-->
                <!--загрузка картинок-->
                <div class="form-group">
                    <input type="file" name="image" class="btn btn-warning">
                </div>
                <!--/загрузка картинок-->
                <!--вступительный текст-->
                <div class="form-group">
                    <textarea class="form-control" name="intro_text" id="textarea" placeholder="Вступительное слово"></textarea>
                </div>
                <!--/вступительный текст-->
<!---->
<!--                <input type="radio" name="myradio" value="1"/>1-->
<!--                <input type="radio" name="myradio" value="2"/>2-->
                        </div>
                    </div>
                <div class="form-group">
                    <label class="label_admin">Текст статьи</label>
                    <textarea class="form-control" name="text" id="text" placeholder="Пишите вашу стаью"></textarea>
                </div>
                <button type="submit" name="button_newarticle"  class="btn btn-success" style="    margin-bottom: 125px;">Отправить</button>
            </form>
            </div>
        </div><!--row-->
</div><!--container-->
        <?php include ("include/sidebar.php");?>
    </div>
</div>
<script>
    CKEDITOR.replace("text");
</script>
<!--[if lt IE 9]>
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<![endif]-->
<script src="libs/jquery/jquery-1.11.1.min.js"></script>
<script src="js/common.js"></script>
<script src="../js/main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min1.js"></script>
</body>
</html>

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

//вывод категорий для тегов select/option
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
//редактирование статьи
if(isset($_POST['button_newarticle'])){

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

    $title = strip_tags($_POST['title']);
    $text = $_POST['text'];
    $intro_text= $_POST['intro_text'];
    $cat = $_POST["cat"];
    $id = $_GET['id'];
//    $auth = $_POST['auth'];
        if(isset ($_FILES['image'])){
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload = "images/";
            move_uploaded_file($image_tmp, $upload.$image_name);
    $update = $pdo->prepare("
    UPDATE 
    `article` 
    SET 
    title=:title, 
    text=:text, 
    intro_image=:intro_image, 
    intro_text=:intro_text, 
    intro_text=:intro_text,
    cat_id=:cat_id,
    main_id=:main_id
    WHERE 
    id=:id
    ");
    $update->bindParam(':title', $title);
    $update->bindParam(':text', $text);
    $update->bindParam(':intro_image', $image_name);
//    $update->bindParam(':author', $auth);
//    $update->bindParam(':author_id', $auth_id);
    $update->bindParam(':intro_text', $intro_text);
    $update->bindParam(':cat_id', $_POST["cat"] );
    $update->bindParam(':main_id', $mainCatId );
    $update->bindParam(':id', $id);
    $update->execute();
    header('Location: admin.php');
        }
    }

/*echo '<pre>';
var_dump($_FILES);
echo '</pre>';*/

//выборка для вставки в форму для редактирования
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $pdo ->prepare('SELECT * FROM `article` WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $articleId = $row['cat_id'];
    $title = $row['title'];
    $text = $row['text'];
    $intro_text = $row['intro_text'];
    $intro_image = $row['intro_image'];
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Редактировать статью</title>
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
                                    <strong>Раздел редактирования статьи</strong>
                                </div>
                            </div>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" id="field1" placeholder="Введите название статьи" value="<?php echo $title; ?>">
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
                                <!--загрузка картинок-->
                                <div class="form-group">
                                        <img src="images/<?php echo $intro_image; ?>" style="height: 150px; width: 150px; padding: 10px;">
                                    <input type="file" name="image" class="btn btn-warning" value="<?php echo $intro_image; ?>">
                                </div>
                                <!--/загрузка картинок-->
                                <!--вступительный текст-->
                                <div class="form-group">
                                    <textarea class="form-control" name="intro_text" id="textarea" placeholder="Вступительное слово"><?php echo $intro_text; ?></textarea>
                                </div>
                                <!--/вступительный текст-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label_admin">Текст статьи</label>
                        <textarea class="form-control" name="text" id="text" placeholder="Пишите вашу стаью"><?php echo $text; ?></textarea>
                    </div>
                    <button type="submit" name="button_newarticle"  class="btn btn-success" style="    margin-bottom: 125px;">Отправить</button>
                    </form>
                </div>
            </div><!--row-->
        </div><!--container-->
        <!--sidebar-->
        <?php include ("include/sidebar.php");?>
        <!--sidebar-->
    </div>
</div>




<script>
    CKEDITOR.replace("text");
</script>
</body>
</html>

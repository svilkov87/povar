<?php
include ("../include/connection.php");
session_start();
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(!$_SESSION){
    header("Location: index.php");
    exit;
}

//выбор всех статей
$st = $pdo->query('SELECT * FROM `article` ORDER BY id DESC ');
$article = $st->fetchAll();

//Считаем общее количество статей
$art = $pdo->query('SELECT COUNT(*) FROM `article`')->fetchColumn();

//Считаем общее количество пользователей
$users = $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();

//Считаем общее количество комментов
$comments = $pdo->query('SELECT COUNT(*) FROM `comments`')->fetchColumn();

//посмотреть последнюю статью
$auth = $pdo->prepare('SELECT max(id) FROM `article`');
$auth->execute();
$last = $auth->fetchAll();
$last_article = implode('', $last[0]);

if(isset($_GET['search_submit'])){
    $poisk = $_GET['search'];
    $st = $pdo->query("SELECT * FROM `article` WHERE title LIKE '%$poisk%'");
    $st->execute(array($poisk));
    $data = $st->fetchAll();
}


/*echo "<pre>";
var_dump($poisk);
echo "</pre>";*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Админ-панель111</title>
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
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/media.css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <script type="text/javascript" src="../js/modernizr.custom.86080.js"></script>
</head>
<body>
<style>
    body{
        background: #5c4246;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr class="warning">
                        <th>фото-превью</th>
                        <th>название</th>
                        <th colspan="2">функция</th>
                    </tr>
                    </thead>
                    <?php foreach($data as $item): ?>
                        <tbody>
                        <tr>
                            <th><img src="images/<?php echo $item['intro_image'];?>" width="50px"></th>
                            <th><?php echo $item['title'];?></th>
                            <th><a href="edit.php?id=<?php echo $item['id']; ?>">редактировать</a></th>
                            <th><a href="delete.php?id=<?php echo $item['id'];?>" class="text-danger">удалить</a></th>
                        </tr>
                        </tbody>
                    <?php endforeach;?>
                </table>
            </div>
            <!--pagination-->
            <ul class="pagination">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
            <!--pagination-->

        </div><!--col-sm-9 page-content col-thin-right-->
        <!--sidebar-->
        <?php include ("include/sidebar.php");?>
        <!--sidebar-->
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>




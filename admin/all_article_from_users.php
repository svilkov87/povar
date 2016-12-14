<?php
include ("../include/connection.php");
session_start();
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


if($_SESSION['user_id'] != 14){
    header("Location: index.php");
    exit;
}

//выбор всех статей пользователей
$st = $pdo->query('SELECT * FROM `article` WHERE user_id != 14 ORDER BY id DESC ');
$article = $st->fetchAll();

//Считаем общее количество статей админа
$art = $pdo->query('SELECT COUNT(*) FROM `article` WHERE user_id = 14')->fetchColumn();

//Считаем общее количество статей пользователей
$count_of_users = $pdo->query('SELECT COUNT(*) FROM `article` WHERE user_id != 14')->fetchColumn();

//Считаем общее количество пользователей
$users = $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();

//Считаем общее количество комментов
$comments = $pdo->query('SELECT COUNT(*) FROM `comments`')->fetchColumn();

//посмотреть последнюю статью
$auth = $pdo->prepare('SELECT max(id) FROM `article`');
$auth->execute();
$last = $auth->fetchAll();
$last_article = implode('', $last[0]);

//echo "<pre>";
//var_dump($last);
//echo "</pre>";

//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Админ-панель</title>
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
<?php include ("include/admin_nav.php");?>
<!--контент-->
<div class="col-md-8">
    <div class="col-md-12">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr class="danger">
                        <th>фото-превью</th>
                        <th>название</th>
                        <th>дата</th>
                        <th>пользователь</th>
                    </tr>
                    </thead>
                    <?php foreach($article as $item): ?>
                        <tbody>
                        <tr>
                            <th><img src="images/<?php echo $item['intro_image'];?>" width="50px"></th>
                            <th><a href="../full.php?id=<?php echo $item['id'];?>"><?php echo $item['title'];?></a></th>
                            <th style="font-weight: normal"><?php echo $item['date'];?></th>
                            <th style="font-weight: bold"><a href="../profile.php?id=<?php echo $item['user_id'];?>"><?php echo $item['user_name'];?></a></th>
                        </tr>
                        </tbody>
                    <?php endforeach;?>
                </table>
            </div>
        </div>

    </div>
</div>
<!--/контент-->
<?php include ("include/sidebar.php");?>

<!--[if lt IE 9]>
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<![endif]-->
<script src="../js/main.js"></script><!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min1.js"></script>
</body>
</html>




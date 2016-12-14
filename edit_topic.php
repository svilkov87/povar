<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(!empty($_GET)) {
    $id = intval($_GET['id']);
    if ($id === 0) {
        die('Ошибка сжатия чёрной дыры');
    }

    //выборка для вставки в форму для редактирования
    $stmt = $pdo ->prepare('SELECT * FROM `forum_questions` WHERE id =:id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $title = $row['title'];
    $text = $row['text'];

    ##отправка топика
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_ava = $_SESSION['ava'];
    if(isset($_POST['edit_comment'])) {
        $title = strip_tags($_POST['title']);
        $text = strip_tags($_POST['text']);
        $id = $_GET['id'];
        $update = $pdo->prepare("
        UPDATE 
        `forum_questions` 
        SET 
        title=:title, 
        text=:text, 
        user_name=:user_name,
        user_ava=:user_ava 
        WHERE 
        id=:id");
        $update->bindParam(':title', $title);
        $update->bindParam(':text', $text);
        $update->bindParam(':user_name', $user_name);
        $update->bindParam(':user_ava', $user_ava);
        $update->bindParam(':id', $id);
        $update->execute();
        header("Location: forum.php?id=$id");
    }
}
//        echo "<pre>";
//        var_dump($user_ava);
//        echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Редактировать Тему</title>
    <meta name="description" content="IMPOVAR" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/favicon/favicon.ico" />
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css" />
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/media.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<?php
?>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="wrapp_add_art">
                <div class="add_topic_panel_heading">
                    <span class="add_topic_span">Редактировать топик</span>
                </div>
                <div class="add_topic_body">
                    <form method="post" action="">
                        <label for="m" class="label_add">Тема</label><br>
                        <input type="text" name="title" id="m" value="<?php echo $title;?>"/>
                        <br />
                        <label for="f" class="label_add">Текст сообщения</label><br>
                        <textarea name="text" id="f" cols="30" rows="10"">
                            <?php echo $text;?>
                        </textarea><br>
                        <button class="btn_default" type="submit" name="edit_comment">вперед</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("include/footer.php");?>
<!--[if lt IE 9]>
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<![endif]-->
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
</body>
</html>
<?php
include("functions/functions.php");
include("include/connection.php");

## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//поиск
if (isset($_GET['search_submit'])) {
    $poisk = $_GET['search'];
    $st = $pdo->query("SELECT * FROM `article` WHERE title LIKE '%$poisk%'");
    $st->execute(array($poisk));
    $data = $st->fetchAll();
}
/*echo "<pre>";
var_dump($data);
echo "</pre>";*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="IMPOVAR"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="img/favicon/favicon.ico"/>
    <link rel="stylesheet" href="libs/font-awesome-4.2.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="libs/fancybox/jquery.fancybox.css"/>
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" href="libs/countdown/jquery.countdown.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" href="css/media.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body>
<i class="fa fa-chevron-up" aria-hidden="true" id="top"></i>
<?php include "include/nav.php"; ?>
<!--лого-->
<div class="col-md-12 logo_block">
    <img src="img/category_images/logo.svg" alt="logo" class="img_logo">
    <h1 class="logo_header">GRANDPOVAR</h1>
</div>
<div class="container">
    <div class="row">
        <!--/лого-->
        <div class="col-md-6 col-md-offset-3">
            <div class="no_comment_body">
                <p class="no_comment_p">По запросу <span class="poisk_word"><?php echo $poisk; ?></span> найдено:</p>
            </div>
            <?php foreach ($data as $item): ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="link_panel">
                            <div class="panel_head_link">
                                <h1 style="font-size: 15px;">
                                    <a href="full.php?id=<?php echo $item['id']; ?>" class="full_link_search">
                                        <?php echo $item['title']; ?>
                                    </a>
                                </h1>
                            </div>
                            <div class="link_body">
                                <div class="img_block_link">
                                    <img src="admin/images/<?php echo $item['intro_image']; ?>" alt="..."
                                         class="img_link_search">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div><!--/row-->
</div><!--/container-->
<?php include("include/footer.php"); ?>
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
<script src="remodal/remodal.min.js"></script>
</body>
</html>
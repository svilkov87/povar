<?php
include ("../include/connection.php");
session_start();
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//проверка админа при авторизации
if(isset($_POST['enter'])){
    $e_email = $_POST['e_email'];
    $e_password = md5($_POST['e_password']);
    $str = $pdo->prepare('SELECT * FROM `users` WHERE email=:email AND admin = 1');
    $str->bindParam(":email", $e_email, PDO::PARAM_INT);
    $str->execute();
    $user_data = $str->fetch(PDO::FETCH_ASSOC);

    //    обращаемся к элементу массива id, которое получили при выборке из таблицы юзеров
    $user_id = $user_data["id"];
    $user_name = $user_data["username"];

        if($user_data['password'] == $e_password){
            $_SESSION['email'] = $e_email;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            header("Location: /admin/admin.php");
            exit;
        }
            else{echo '
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-md-3 col-xs-offset-3 col-md-offset-4">
                        <div class="alert alert-danger">Неверные данные!</div>
                    </div>
                 </div>
            </div>
            ';}
}

//echo "<pre>";
//var_dump($user_data);
//echo "</pre>";
//
//echo "<pre>";
//var_dump($_SESSION);
//echo "</pre>";

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Вход</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/main1.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <!--<div class="alert alert-danger">-->
            <form method="post" action="#">
                <div class="row">
                    <div class="col-xs-6 col-md-3 col-xs-offset-3 col-md-offset-4">
                        <h3 class="text-danger">Вход в админ-панель</h3>
                        <input type="text" name="e_email"  class="form-control input-sm" placeholder="Введите E-mail">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 col-xs-offset-3 col-md-offset-4">
                        <input type="password" name="e_password" class="form-control input-sm" placeholder="Введите Пароль">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-3 col-xs-offset-3 col-md-offset-4">
                        <button type="submit" name="enter" class="btn btn-danger" id="btn_nav">Войти</button>
                        Вернуться на <a href="../index.php">Главную</a>
                    </div>
                </div>
            </form>
        <!--</div>-->
    </div>
</div>
<script>
    var classHeight = document.getElementsByClassName('form-control');
    for (var i = 0; i < classHeight.length; i++) {
        /*classHeight[i].style.height = 'auto';*/
        classHeight[i].style.marginBottom = 6 + 'px';
    }
    var classH4 = document.getElementsByClassName('text-danger');
    for (var i = 0; i < classH4.length; i++) {
        classH4[i].style.textAlign = 'center';
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>




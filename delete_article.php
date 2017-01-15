<?
include("functions/functions.php");
include("include/connection.php");
## проверка ошибок
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


$user_id = $_SESSION['user_id'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $del = $pdo->prepare("DELETE FROM `article` WHERE id=:id");
    $del->bindParam(':id', $id);
    $del->execute();


    //    Считаем общее количество статей
    $st = $pdo->prepare('SELECT COUNT(user_id) FROM `article` WHERE user_id=:user_id');
    $st->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $st->execute();
    $art_column = $st->fetchColumn();

    //    обновляем статистику в таблице пользователей
    $update = $pdo->prepare("
        UPDATE 
        `users` 
        SET 
        count_of_articles =:count_of_articles
        WHERE 
        id=:id");
    $update->bindParam(':count_of_articles', $art_column);
    $update->bindParam(':id', $user_id);
    $update->execute();

    header("Location: http://".$_SERVER['HTTP_HOST']."/profile/".$user_id);
    exit;
}

?>
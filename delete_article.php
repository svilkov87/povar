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
    header("Location: profile.php?id=$user_id");
    exit;
}

?>
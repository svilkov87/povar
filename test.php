<?php
include("include/connection.php");

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

//$host = 'localhost';
//$db =   'svilkov87_gpovar'; //  ��� ��
//$charset = 'utf-8';
//$user = '046606267_gp'; //  ����
//$pass = 'vfvby1955'; //  ������ �����
//
//// ����������� � �� PDO
//$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//$opt = array(
//    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//);
//$pdo = new PDO($dsn, $user, $pass, $opt);

$st = $pdo->query('SELECT `text` FROM `article` LIMIT 0, 3');
$test = $st->fetchAll();

        echo "<pre>";
        var_dump($test);
        echo "</pre>";
?>
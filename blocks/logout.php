<?php
	session_start();
    unset($_SESSION["email"]);
    unset($_SESSION["password"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_name"]);
    unset($_SESSION["ava"]);
    header("Location: ".$_SERVER["HTTP_REFERER"]);
    exit;
?>
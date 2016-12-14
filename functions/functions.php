<?php

session_start();

function clear_string($cl_str){
    $cl_str = strip_tags($cl_str);
//    $cl_str = PDO::quote($cl_str);
    $cl_str = trim($cl_str);
}

?>
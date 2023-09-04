<?php
session_start();
require_once "db.php";
require_once "functions.php";

if(isset($_POST['title'])){
    $title    = $_POST['title'];
    $date     = date("Y-m-d");
    $sections = 0;

    if(empty($_POST['title'])){
        header("Location: ../new_document.php?error=emptyinput");
        exit();
    }
    if(!isset($_SESSION['username'])){
        header("Location: ../new_document.php?error=notloggedin");
        exit();
    }else{
        $admin = $_SESSION['username'];
    }

    create_document($connection, $title, $date, $admin, $sections);

    header("Location: ../index.php?error=none");
    exit();
}else{
    header("Location: ../index.php");
    exit();
}
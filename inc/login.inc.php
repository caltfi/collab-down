<?php
require_once "db.php";
require_once "functions.php";

if(isset($_POST['submit'])){
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    if(empty_login_input($username, $password) !== false){
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    login_user($connection, $username, $password);
    
}else{
    header("Location: ../login.php");
    exit();
}
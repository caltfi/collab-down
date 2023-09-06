<?php
require_once "db.php";
require_once "functions.php";

if(isset($_POST['submit'])){
    $name      = $_POST['name'];
    $user_name = $_POST['user_name'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $confirm_pwd  = $_POST['confirm_password'];

    //check name is valid (to avoid SQL injection)
    if(!preg_match("/^[a-zA-Z0-9\s]*$/", $name)){
        header("Location: ../signup.php?error=invalidusername");
        exit();
    }

    if(empty_signup_input($name, $user_name, $email, $password, $confirm_pwd) !== false){
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }
    if(invalid_user_name($user_name) !== false){
        header("Location: ../signup.php?error=invalidusername");
        exit();
    }
    if(invalid_email($email) !== false){
        header("Location: ../signup.php?error=invalidemail");
        exit();
    }
    if(password_non_match($password, $confirm_pwd) !== false){
        header("Location: ../signup.php?error=passwordnonmatch");
        exit();
    }
    if(user_name_exists($connection, $user_name, $email, "signup") !== false){
        header("Location: ../signup.php?error=usernametaken");
        exit();
    }

    create_user($connection, $name, $email, $user_name, $password, "profile.jpg");
    
}else{
    header("Location: ../signup.php");
    exit();
}
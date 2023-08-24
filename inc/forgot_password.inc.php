<?php
require_once "db.php";
require_once "functions.php";

if(isset($_POST['submit'])){
    $email = $_POST['email'];

    if(empty($email)){
        header("Location: ../forgot_password.php?error=emptyinput");
        exit();
    }

    if(invalid_email($email) !== false){
        header("Location: ../forgot_password.php?error=invalidemail");
        exit();
    }

    forgot_password($connection, $email);
    
}else{
    header("Location: ../forgot_password.php");
    exit();
}
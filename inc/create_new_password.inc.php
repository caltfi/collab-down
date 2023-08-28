<?php
require_once "db.php";
require_once "functions.php";

if(isset($_POST['reset-password-submit'])){
    $selector    = $_POST['selector'];
    $validator   = $_POST['validator'];
    $password    = $_POST['pwd'];
    $confirm_pwd = $_POST['confirm_pwd'];

    if(empty($password) || empty($confirm_pwd)){
        header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=emptyinput");
        exit();
    }elseif($password !== $confirm_pwd){
        header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=pwd_nomatch");
        exit();
    }

    //check expiry date of token
    $current_date = date("U");
    $query = "SELECT * FROM pwdreset WHERE pwdreset_selector = ? AND pwdreset_expires >= $current_date;";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "s", $selector);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    if(!$row = mysqli_fetch_assoc($result)){
        header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=expired");
        exit();
    }else{
        $token_bin = hex2bin($validator);
        $token_check = password_verify($token_bin, $row['pwdreset_token']);

        if($token_check === false){
            header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=expired");
            exit();
        }elseif($token_check === true){
            $token_email = $row['pwdreset_email'];
            $query = "SELECT * FROM users WHERE users_email = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "s", $token_email);
            mysqli_stmt_execute($prep_stat);
            $result = mysqli_stmt_get_result($prep_stat);
            if(!$row = mysqli_fetch_assoc($result)){
                header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=stmtfail");
                exit();
            }else{
                $query = "UPDATE users SET users_pwd = ? WHERE users_email = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($prep_stat, $query)){
                    header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=stmtfail");
                    exit();
                }
                $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($prep_stat, "ss", $hashed_pwd, $token_email);
                mysqli_stmt_execute($prep_stat);

                //delete tokens
                $query = "DELETE FROM pwdreset WHERE pwdreset_email = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($prep_stat, $query)){
                    header("Location: ../create_new_password.php?selector={$selector}&validator={$validator}&error=stmtfail");
                    exit();
                }
                mysqli_stmt_bind_param($prep_stat, "s", $token_email);
                mysqli_stmt_execute($prep_stat);

                header("Location: ../login.php?result=pwd_reset_success");
                exit();
            }
        }   
    }
}else{
    header("Location: ../index.php");
    exit();
}
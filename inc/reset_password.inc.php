<?php
require_once "db.php";
require_once "functions.php";

if(isset($_POST['reset-submit'])){
    $email = $_POST['email'];

    if(empty($email)){
        header("Location: ../reset_password.php?error=emptyinput");
        exit();
    }

    if(invalid_email($email) !== false){
        header("Location: ../reset_password.php?error=invalidemail");
        exit();
    }

    //tokens
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    //password reset link url
    $url = "localhost/collabdown/create_new_password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    //expires in 30 minutes
    $expires = date("U") + 1800;


    //delete existing tokens on db for user
    $query = "DELETE FROM pwdreset WHERE pwdreset_email = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../reset_password.php?error=stmtfail");
        exit();
    }  
    mysqli_stmt_bind_param($prep_stat, "s", $email); 
    mysqli_stmt_execute($prep_stat);

    //insert token into db
    $query = "INSERT INTO pwdreset (pwdreset_email, pwdreset_selector, pwdreset_token, pwdreset_expires) VALUES (?, ?, ?, ?);";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../reset_password.php?error=stmtfail");
        exit();
    }
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($prep_stat, "ssss", $email, $selector, $hashed_token, $expires);
    mysqli_stmt_execute($prep_stat);
    mysqli_stmt_close($prep_stat);
    mysqli_close($connection);

    //send email
    $to       = $email;
    $subject  = "Password Reset for {$email}";
    $message  = "<p>Hello,</p><p>We have received a password reset request for a user account connected to this e-mail address. The link to reset your password is below. If you did not make this request, you can ignore this e-mail.</p><p>You can reset your password by following this link:";
    $message .= "<a href='{$url}'><button>Reset Password</button<</a></p>";
    $message .= "<p>Kind regards, the CollabDown team</p>";
    $headers  = "From: CollabDown <admin@collabdown.com>\r\nReply-To: admin@collabdown.com\r\nContent-type: text/html\r\n";
    mail($to, $subject, $message, $headers);

    header("Location: ../reset_password.php?error=none");
    exit();
}else{
    header("Location: ../index.php");
    exit();
}
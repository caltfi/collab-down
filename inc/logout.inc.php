<?php
session_start();
session_unset();
session_destroy();
if(isset($_GET['source'])){
    if($_GET['source'] == "reset_password"){
        header("Location: ../reset_password.php");
        exit();
    }
}
header("Location: ../index.php");
exit();
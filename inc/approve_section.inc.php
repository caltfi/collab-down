<?php
include_once 'db.php';
include_once 'functions.php';
session_start();

if(isset($_SESSION['username'])){
    $logged_in_user = $_SESSION['username'];

    if(isset($_POST['approve-submit'])){
        $doc_id         = $_POST['doc_id'];
        $file_id        = $_POST['file_id'];
        $admin          = $_POST['admin'];

        if(!$logged_in_user == $admin){
            header("Location: ../index.php");
            exit();
        }
        
        $query = "SELECT files_status FROM files WHERE files_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $file_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        $row = mysqli_fetch_assoc($result);
        $files_status = $row['files_status'];
        mysqli_stmt_close($prep_stat);
        if($files_status == 'approved'){
            //if files_status is approved, change to pending
            $query = "UPDATE files SET files_status = 'pending' WHERE files_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "s", $file_id);
            mysqli_stmt_execute($prep_stat);
            mysqli_stmt_close($prep_stat);

            header("Location: ../edit_document.php?doc_id={$doc_id}");
            exit();
        }else{
            //query to change file status
            $query = "UPDATE files SET files_status = 'approved' WHERE files_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "s", $file_id);
            mysqli_stmt_execute($prep_stat);
            mysqli_stmt_close($prep_stat);
            
            header("Location: ../edit_document.php?doc_id={$doc_id}&section=approved");
            exit();
        }
    }
}else{
    header("Location: ../index.php");
    exit();
}
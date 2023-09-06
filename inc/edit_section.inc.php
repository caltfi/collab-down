<?php
include_once "db.php";
include_once "functions.php";
session_start();

if(isset($_SESSION['username'])){
    $username  = $_SESSION['username'];
    
    if(isset($_POST['section_user'])){
        $doc_id            = $_POST['doc_id'];
        $admin             = $_POST['admin']; 
        $new_assigned_user = $_POST['section_user'];
        $section_number    = $_POST['section_number'];
        $file_id           = $_POST['file_id'];

        //if logged in user is authorised to make section changes then proceed
        if($admin != $username){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
        //Change assigned user to new user
        $query     = "UPDATE files SET files_assign_uid = ? WHERE files_id = ? AND files_document_id = ? AND files_section_number = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "siii", $new_assigned_user, $file_id, $doc_id, $section_number);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ../edit_document.php?doc_id={$doc_id}&error=none");
        exit();

    }elseif(isset($_POST['section_title'])){
        $doc_id         = $_POST['doc_id'];
        $admin          = $_POST['admin']; 
        $new_title      = $_POST['section_title'];
        $section_number = $_POST['section_number'];
        $file_id        = $_POST['file_id'];

        //if logged in user is authorised to make section changes then proceed
        if($admin != $username){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }

        //check if new title is valid (to avoid SQL injection)
        if(!preg_match("/^[a-zA-Z0-9\s]*$/", $new_title)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }

        //Change title to new title
        $query = "UPDATE files SET files_title = ? WHERE files_id = ? AND files_document_id = ? AND files_section_number = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "siii", $new_title, $file_id, $doc_id, $section_number);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ../edit_document.php?doc_id={$doc_id}&error=none");
        exit();
    }else{
        header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
        exit();
    }
}else{
    header("Location: ../index.php?error=stmtfail");
    exit();
}
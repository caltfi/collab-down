<?php
include_once 'db.php';
include_once 'functions.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $doc_id   = $_GET['doc_id'];

    //get doc admin from doc_id
    $query = "SELECT documents_admin FROM documents WHERE documents_id = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($prep_stat, $query)){
        header("Location: ../index.php?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    $row = mysqli_fetch_assoc($result);
    $admin = $row['documents_admin'];
    mysqli_stmt_close($prep_stat);

    if($username != $admin){
        header("Location: ../index.php?error=stmtfail");
        exit();
    }

    if(isset($_POST['doc_title'])){
        $new_title = $_POST['doc_title'];

        //update the document title
        $query = "UPDATE documents SET documents_title = ? WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "si", $new_title, $doc_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ../edit_document.php?doc_id={$doc_id}&save=success");
        exit();
    }elseif(isset($_POST['new_admin'])){
        $new_admin = $_POST['new_admin'];

        //check if user is sure
        header("Location: ../change_admin.php?doc_id={$doc_id}&new_admin={$new_admin}");
        exit();
    }

}else{
    header("Location: ../index.php");
    exit();
}
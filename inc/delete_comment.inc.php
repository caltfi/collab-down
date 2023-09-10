<?php
include_once 'db.php';
include_once 'functions.php';
session_start();

if(isset($_SESSION['username'])){
    $logged_in_user = $_SESSION['username'];
    if(isset($_GET['doc_id']) && isset($_GET['comment'])){
        $doc_id     = $_GET['doc_id'];
        $comment_id = $_GET['comment'];

        //check if user is doc admin
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
        $doc_admin = $row['documents_admin'];
        mysqli_stmt_close($prep_stat);

        if($logged_in_user != $doc_admin){
            header("Location: ../index.php");
            exit();
        }

        //delete comment from comments table
        $query = "DELETE FROM comments WHERE comments_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $comment_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ../edit_document.php?doc_id={$doc_id}");
        exit();
    }
}else{
    header("Location: ../index.php");
    exit();
}
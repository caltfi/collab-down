<?php
session_start();
require_once "db.php";
require_once "functions.php";

if(isset($_POST['submit'])){
    $title    = $_POST['title'];
    $date     = date('d-m-y');
    $sections = $_POST['sections'];

    if(empty($_POST['title'])){
        header("Location: ../new_document.php?error=emptyinput");
        exit();
    }
    if(!isset($_SESSION['username'])){
        header("Location: ../new_document.php?error=notloggedin");
        exit();
    }else{
        $admin = $_SESSION['username'];
    }

    create_document($connection, $title, $sections, $date, $admin);

    //get document id
    $query     = "SELECT documents_id FROM documents WHERE documents_title = ? AND documents_date = ? AND documents_admin = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        header("Location: ../new_document.php?error=stmtfail");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "sss", $title, $date, $admin);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    $row    = mysqli_fetch_assoc($result);

    $document_id = $row['documents_id'];
    
    mysqli_stmt_close($prep_stat);
    
    header("Location: create_files.php?document_id=$document_id&assign_uid=$admin&sections=$sections&date=$date&title=$title");
    exit();
}else{
    header("Location: ../new_document.php");
    exit();
}
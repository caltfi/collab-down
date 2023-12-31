<?php
include_once 'db.php';
include_once 'functions.php';

if(isset($_POST['save-submit'])){
    $doc_id       = $_POST['doc_id'];
    $file_id      = $_POST['file_id'];
    $date_updated = date("Y-m-d");
    $content      = $_POST['md_content'];

    $file_path = "../mdfiles/{$file_id}.md";
    if(empty($content)){
        header("Location: ../edit_document.php?doc_id=$doc_id");
        exit();
    }

    if(!file_put_contents($file_path, $content)){
        header("Location: ../edit_document.php?doc_id=$doc_id&save=error");
        exit();
    }

    //update the date_updated in the database
    $query  = "UPDATE files SET files_date_updated = '$date_updated' WHERE files_id = '$file_id'";
    $result = mysqli_query($connection, $query);
    if(!$result){
        header("Location: ../edit_document.php?doc_id=$doc_id&save=error");
        exit();
    }
        
    header("Location: ../edit_document.php?doc_id=$doc_id&save=success");
    exit();
}
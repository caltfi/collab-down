<?php
session_start();
require_once "db.php";
require_once "functions.php";

//retrieve doc_id from url
$document_id = $_GET['document_id'];

//Retrieve data for section creation
$section_number = $_POST['section_number'];
$section_title  = $_POST['section_title'];
$sections       = $_POST['no_of_sections'];
$assign_uid     = $_POST['assign_uid'];
$date        = date('d-m-y', time());

//file creation and insertion into database
for($section_number = 1; $section_number <= $sections; $section_number++){
    $file_id = "{$assign_uid}_{$document_id}_{$section_number}_" . uniqid();
    $md_file = "../mdfiles/{$file_id}.md";

    if(create_file($md_file)){
        insert_file_data($connection, $file_id, $assign_uid, $date, $document_id, $section_number);
    }else{
        header("Location: ../new_document.php?error=stmtfail");
        exit();
    }
}

//redirect back with success message
header("Location: ../new_document.php?error=none");
exit();
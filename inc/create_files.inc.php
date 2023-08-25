<?php
session_start();
require_once "db.php";
require_once "functions.php";

//retrieve information from query parameters
$document_id = $_GET['document_id'];
$assign_uid  = $_GET['assign_uid'];
$sections    = $_GET['sections'];
$date        = $_GET['date'];
$title       = $_GET['title'];

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
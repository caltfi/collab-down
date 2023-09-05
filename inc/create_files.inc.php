<?php
session_start();
require_once "db.php";
require_once "functions.php";

if(isset($_POST['submit-files'])){
    $doc_id = $_POST['doc_id'];

    $section_number = $_POST['section_number'];
    $section_title  = $_POST['title1'];
    $sections       = $_POST['no_of_sections'];
    $assign_uid     = $_POST['user1'];
    $date           = date('d-m-y', time());

    //file creation and insertion into database
    for($section_number = 1; $section_number <= $sections; $section_number++){
        $file_id = "{$doc_id}_{$section_number}_" . uniqid();
        $md_file = "../mdfiles/{$file_id}.md";

        if(create_file($md_file)){
            insert_file_data($connection, $file_id, $assign_uid, $date, $document_id, $section_number);
        }else{
            header("Location: ../edit_document.php?error=stmtfail");
            exit();
        }
    }

    //redirect back with success message
    header("Location: ../edit_document.php?doc_id={$doc_id}&error=none");
    exit();
}else{
    header("Location: ../edit_document.php?doc_id={$doc_id}");
    exit();
}
<?php
session_start();
require_once "db.php";
require_once "functions.php";
$doc_id = $_GET['doc_id'];

if(isset($_POST['submit-files'])){
    $titles = $_POST['title'];
    $users  = $_POST['user'];
    $no_sections = count($titles);
    $date = date("Y-m-d");
    $status = "pending";

    for($i = 0; $i < $no_sections; $i++){
        $section_number = $i + 1;
        $section_title = $titles[$i];
        $assigned_user = $users[$i];

        //check if section title is valid (to avoid SQL injection)
        if(!preg_match("/^[a-zA-Z0-9\s]*$/", $section_title)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=invalidtitle");
            exit();
        }

        //check if user exists
        $uid_exists = user_name_exists($connection, $assigned_user, $assigned_user, "edit_document");
        if($uid_exists === false){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=invaliduser");
            exit();
        }

        $file_id = "DOC_{$doc_id}_" . uniqid('FILE_', true);
        $md_file = "../mdfiles/{$file_id}.md";
        
        //file creation and insertion into database
        if(create_file($md_file)){
            //create_file($md_file);
            insert_file_data($connection, $file_id, $section_title, $assigned_user, $date, $doc_id, $section_number, $status);
            add_section_to_doc($connection, $doc_id);
        }else{
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
    }

    //redirect back with success message
    header("Location: ../edit_document.php?doc_id={$doc_id}&error=none");
    exit();

}elseif(isset($_POST['submit-add-files'])){
    $titles = $_POST['title'];
    $users  = $_POST['user'];
    $no_existing_sections = $_POST['no_existing_sections'];
    $no_new_sections = count($titles);
    $date = date("Y-m-d");
    $status = "pending";
    
    $no_total_sections = $no_existing_sections + $no_new_sections;

    $section_number = $no_existing_sections + 1;

    for($i = 0; $i < $no_new_sections; $i++){
        $section_title = $titles[$i];
        $assigned_user = $users[$i];

        //check if section title is valid (to avoid SQL injection)
        if(!preg_match("/^[a-zA-Z0-9\s]*$/", $section_title)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=invalidtitle");
            exit();
        }

        //check if user exists
        $uid_exists = user_name_exists($connection, $assigned_user, $assigned_user, "edit_document");
        if($uid_exists === false){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=invaliduser");
            exit();
        }

        $file_id = "DOC_{$doc_id}_" . uniqid('FILE_', true);
        $md_file = "../mdfiles/{$file_id}.md";

        //file creation and insertion into database
        if(create_file($md_file)){
            //create_file($md_file);
            insert_file_data($connection, $file_id, $section_title, $assigned_user, $date, $doc_id, $section_number, $status);
            add_section_to_doc($connection, $doc_id);
        }else{
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }

        $section_number++;
    }

    //redirect back with success message
    header("Location: ../edit_document.php?doc_id={$doc_id}&error=none");
    exit();
    
}else{
    header("Location: ../edit_document.php?doc_id={$doc_id}");
    exit();
}
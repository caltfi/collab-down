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

    echo "<h1>Document ID: {$doc_id}</h1>";
    echo "<h1>Number of Sections: {$no_sections}</h1>";
    echo "<hr>";

    for($i = 0; $i < $no_sections; $i++){
        $section_number = $i + 1;
        $section_title = $titles[$i];
        $assigned_user = $users[$i];

        $file_id = "{$doc_id}_{$section_number}_" . uniqid();
        $md_file = "../mdfiles/{$file_id}.md";
        
        //file creation and insertion into database
        if(create_file($md_file)){
            //create_file($md_file);
            insert_file_data($connection, $file_id, $section_title, $assigned_user, $date, $doc_id, $section_number);
            add_section_to_doc($connection, $doc_id);
        }else{
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
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
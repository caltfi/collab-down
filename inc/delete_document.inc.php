<?php
include_once "db.php";
include_once "functions.php";
session_start();

if(isset($_SESSION['username'])){
    $logged_in_username = $_SESSION['username'];
    
    if(isset($_POST['submit-delete-document'])){
        $doc_id = $_POST['doc_id'];
        $admin = $_POST['admin'];

        //only doc admin can delete
        if(!$logged_in_username == $admin){
            header("Location: ../index.php");
            exit();
        }
    
        //delete row from documents table
        $query = "DELETE FROM documents WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        //store all files_id with documents_id = $doc_id in an array
        $query = "SELECT files_id FROM files WHERE files_document_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        $files_id = array();
        while($row = mysqli_fetch_assoc($result)){
            array_push($files_id, $row['files_id']);
        }
        mysqli_stmt_close($prep_stat);

        //delete all files from mdfiles folder
        foreach($files_id as $file_id){
            $md_file = "../mdfiles/{$file_id}.md";
            if(file_exists($md_file)){
                unlink($md_file);
            }else{
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
        }

        //delete rows from files table
        $query = "DELETE FROM files WHERE files_document_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ../index.php?doc=del");
        exit();
    }
}
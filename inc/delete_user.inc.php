<?php
include_once "db.php";
include_once "functions.php";
session_start();

if(isset($_SESSION['username'])){
    $logged_in_username = $_SESSION['username'];
    if(isset($_POST['submit-delete-user'])){
        $user_id = $_POST['user_id'];
        if($logged_in_username != $user_id){
            header("Location: ../index.php");
            exit();
        }       
        
        //find all files wher user is files_assign_uid
        $query = "SELECT * FROM files WHERE files_assign_uid = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $user_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        while($row = mysqli_fetch_assoc($result)){

            $file_id = $row['files_id'];
            $file_doc_id = $row['files_document_id'];
            $file_assign_uid = $row['files_assign_uid'];

            //using $file_doc_id get the doc admin
            $query = "SELECT documents_admin FROM documents WHERE documents_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "i", $file_doc_id);
            mysqli_stmt_execute($prep_stat);
            $result2 = mysqli_stmt_get_result($prep_stat);
            $row2 = mysqli_fetch_assoc($result2);

            $doc_admin = $row2['documents_admin'];

            if($file_assign_uid == $user_id){
                //change all files where user is files_assign_uid to the document admin
                $query     = "UPDATE files SET files_assign_uid = ? WHERE files_id = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($prep_stat, $query)){
                    header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
                    exit();
                }
                mysqli_stmt_bind_param($prep_stat, "ss", $doc_admin, $file_id);
                mysqli_stmt_execute($prep_stat);
                mysqli_stmt_close($prep_stat);
            }
        }
        
        //delete all documents where user is admin
        $query = "SELECT documents_id FROM documents WHERE documents_admin = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $user_id);
        mysqli_stmt_execute($prep_stat);
        //use documents_id to delete all files where doc_id = documents_id
        $result = mysqli_stmt_get_result($prep_stat);
        while($row = mysqli_fetch_assoc($result)){
            $doc_id = $row['documents_id'];

            //get all files_id from files table where files_document_id = $doc_id
            $query = "SELECT files_id FROM files WHERE files_document_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
            mysqli_stmt_execute($prep_stat);
            $result2 = mysqli_stmt_get_result($prep_stat);
            while($row = mysqli_fetch_assoc($result2)){
                $file_id = $row['files_id'];

                //unlink all files from dir mdfiles/ where file_id = files_id
                $file_path = "../mdfiles/{$file_id}.md";
                if(file_exists($file_path)){
                    unlink($file_path);
                }
            }
            mysqli_stmt_close($prep_stat);

            //delete all files where doc_id = documents_id
            $query = "DELETE FROM files WHERE files_document_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: ../index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
            mysqli_stmt_execute($prep_stat);
            mysqli_stmt_close($prep_stat);
        }
        
        $query = "DELETE FROM documents WHERE documents_admin = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $user_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        //delete all from assets/user_prof that match user_id
        $dir = "../assets/user_prof/{$user_id}";
        $files = glob($dir . "/*");
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
        rmdir($dir);

        //delete user from users table
        $query = "DELETE FROM users WHERE users_uid = ?";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $user_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        header("Location: ./logout.inc.php");
        exit();
    }
}else{
    header("Location: ../index.php");
    exit();
}
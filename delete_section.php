<?php include "inc/header.php" ?>
<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    if(isset($_GET['doc_id']) && isset($_GET['file_id'])){
        //to delete a file section
        $file_id = $_GET['file_id'];
        $doc_id  = $_GET['doc_id'];
        $section_number = $_GET['section_no'];

        //check if logged in user is doc admin
        $query = "SELECT documents_admin FROM documents WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: index.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        $row = mysqli_fetch_assoc($result);
        $admin = $row['documents_admin'];
        mysqli_stmt_close($prep_stat);
        if($username != $admin){
            header("Location: index.php");
            exit();
        }
        ?>
        <div class="container">
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
                <div class="col">
                    <div class="form-group">
                        <h2 class="pb-2 border-bottom mb-3 text-center">Are You Sure?</h2>
                        <p>Are you sure you want to delete this document section? You may lose your work or the work of another user.</p>
                        <p><strong>By proceeding you will premanently delete this file section and the content contained within.</strong></p>
                        <hr class="mb-3">
                        <form action="" method="post" class=" d-flex justify-content-between align-items-center">
                            <a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="btn btn-dark">Go Back</a>
                            <input type="hidden" name="file_id" value="<?php echo $file_id ?>">
                            <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                            <input type="hidden" name="admin" value="<?php echo $admin ?>">
                            <input type="hidden" name="section_no" value="<?php echo $section_number ?>">
                            <button type="submit" name="submit-delete-section" class="btn btn-outline-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill me-2" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
        <?php
    }else{
        header("Location: index.php?error=stmtfail");
        exit();
    }

    if(isset($_POST['submit-delete-section'])){
        $doc_id         = $_POST['doc_id'];
        $file_id        = $_POST['file_id'];
        $admin          = $_POST['admin'];
        $section_number = $_POST['section_no'];

        $file_path = "mdfiles/{$file_id}.md";

        //only document admin authorised to delete a section
        if($username != $admin){
            header("Location: index.php");
            exit();
        }

        //delete the file
        if(unlink($file_path)){
            //delete the file from the database
            $query  = "DELETE FROM files WHERE files_id = '$file_id'";
            $result = mysqli_query($connection, $query);
            if(!$result){
                header("Location: edit_document.php?doc_id=$doc_id&error=stmtfail");
                exit();
            }
        }else{
            header("Location: edit_document.php?doc_id=$doc_id&error=stmtfail");
            exit();
        }  

        //using the section number, update the section numbers of all files with section numbers > $section_number to be -1
        $query = "UPDATE files SET files_section_number = files_section_number - 1 WHERE files_document_id = ? AND files_section_number > ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: edit_document.php?doc_id=$doc_id&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "ii", $doc_id, $section_number);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);

        //using doc id update the number of sections in the document to be -1
        $query = "UPDATE documents SET documents_no_sections = documents_no_sections - 1 WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: edit_document.php?doc_id=$doc_id&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);
          
        header("Location: edit_document.php?doc_id=$doc_id&section=deleted");
        exit();
    }
}else{
    header("Location: index.php");
    exit();
}
?>
<?php include "inc/footer.php" ?>
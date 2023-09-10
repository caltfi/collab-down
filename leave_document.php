<?php include "inc/header.php" ?>
<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    if(isset($_GET['doc_id'])){
        $doc_id  = $_GET['doc_id'];
        //get document admin
        $query = "SELECT documents_admin FROM documents WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: edit_document.php?doc_id={$doc_id}");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        $row = mysqli_fetch_assoc($result);
        $admin = $row['documents_admin'];
        mysqli_stmt_close($prep_stat);
        if($username != $admin){            
            ?>
            <div class="container">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <h2 class="pb-2 border-bottom mb-3 text-center">Are You Sure?</h2>
                            <p>Are you sure you want to leave this document?</p>
                            <p><strong>By proceeding to leave this document, all of your document sections will be re-assigned to the document administrator.</strong></p>
                            <hr class="mb-3">
                            <form action="" method="post" class=" d-flex justify-content-between align-items-center">
                                <a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="btn btn-dark">Go Back</a>
                                <button type="submit" name="submit-leave" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill me-2" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                    Leave
                                </button>
                            </form>
                        </div>
                    </div>   
                </div>
            </div>
            <?php

            if(isset($_POST['submit-leave'])){
                //get all files where doc_id = $doc_id
                $query = "SELECT * FROM files WHERE files_document_id = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($prep_stat, $query)){
                    header("Location: edit_document.php?doc_id={$doc_id}");
                    exit();
                }
                mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
                mysqli_stmt_execute($prep_stat);
                $result = mysqli_stmt_get_result($prep_stat);
                while($row = mysqli_fetch_assoc($result)){
                    $file_id = $row['files_id'];
                    $file_status = $row['files_status'];

                    if($row['files_assign_uid'] == $username){
                        //set files_assign_uid to document admin and set files_status to 'pending'
                        $query = "UPDATE files SET files_assign_uid = ?, files_status = 'pending' WHERE files_id = ?;";
                        $prep_stat = mysqli_stmt_init($connection);
                        if(!mysqli_stmt_prepare($prep_stat, $query)){
                            header("Location: edit_document.php?doc_id={$doc_id}");
                            exit();
                        }
                        mysqli_stmt_bind_param($prep_stat, "ss", $admin, $file_id);
                        mysqli_stmt_execute($prep_stat);
                        mysqli_stmt_close($prep_stat);
                    }
                }

                header("Location: index.php?doc=left");
                exit();
            }

        }else{
            header("Location: index.php?error=stmtfail");
            exit();
        }
    }else{
        header("Location: index.php?error=stmtfail");
        exit();
    }
}else{
    header("Location: index.php");
    exit();
}
?>
<?php include "inc/footer.php" ?>
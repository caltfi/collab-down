<?php include "inc/header.php" ?>
<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    if(isset($_GET['doc_id']) && isset($_GET['new_admin'])){
        $new_admin = $_GET['new_admin'];
        $doc_id  = $_GET['doc_id'];

        //check if logged in user is current doc admin
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
                        <p>Are you sure you want to change this document's administrator?</p>
                        <p><strong>By proceeding you will no longer be the document's administrator, and it will be changed to the user you have selected.</strong></p>
                        <hr class="mb-3">
                        <form action="" method="post" class=" d-flex justify-content-between align-items-center">
                            <a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="btn btn-dark">Go Back</a>
                            <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                            <input type="hidden" name="new_admin" value="<?php echo $new_admin ?>">
                            <button type="submit" name="submit-change-admin" class="btn btn-outline-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill me-2" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                </svg>
                                Change
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

    if(isset($_POST['submit-change-admin'])){
        $doc_id    = $_POST['doc_id'];
        $new_admin = $_POST['new_admin'];

        //check that new_admin user exists
        $uid_exists = user_name_exists($connection, $new_admin, $new_admin, "edit_document");
        if($uid_exists === false){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=invaliduser");
            exit();
        }

        //update the document admin
        $query = "UPDATE documents SET documents_admin = ? WHERE documents_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "si", $new_admin, $doc_id);
        mysqli_stmt_execute($prep_stat);
        mysqli_stmt_close($prep_stat);
          
        header("Location: edit_document.php?doc_id=$doc_id&save=success");
        exit();
    }
}else{
    header("Location: index.php");
    exit();
}
?>
<?php include "inc/footer.php" ?>
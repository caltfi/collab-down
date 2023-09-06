<?php include "inc/header.php" ?>
<?php
if(isset($_SESSION['username'])){
    $session_username = $_SESSION['username'];

    if(isset($_GET['doc_id'])){
        //To delete a document
        $doc_id = $_GET['doc_id'];

        //authorise only admin to make delete request. Check if session username is doc admin
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
        if($session_username != $admin){
            header("Location: index.php");
            exit();
        }else{
            ?>
            <div class="container">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <h2 class="pb-2 border-bottom mb-3 text-center">Are You Sure?</h2>
                            <p>Are you sure you want to delete this document? You may lose your work and the work of other users.</p>
                            <p><strong>This will premanently delete the document and all corresponding files associated with the document.</strong></p>
                            <hr class="mb-3">
                            <form action="inc/delete_document.inc.php?doc_id=<?php echo $doc_id ?>&admin=true" method="post" class=" d-flex justify-content-between align-items-center">
                                <a href="index.php" class="btn btn-outline-secondary">Go Back</a>
                                <button type="submit" name="submit" class="btn btn-dark" >Delete</button>
                            </form>
                        </div>
                    </div>   
                </div>
            </div>
            <?php
        }
    }elseif(isset($_GET['user_id'])){
        //to delete a user profile
        $user_id = $_GET['user_id'];
    
        if($username != $user_id){
            header("Location: index.php");
            exit();
        }else{
            ?>
            <div class="container">
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-3 justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <h2 class="pb-2 border-bottom mb-3 text-center">Are You Sure?</h2>
                            <p>Are you sure you want to delete your user account? You may lose your work and the work of other users.</p>
                            <p><strong>By proceeding you will premanently delete your user account, as well as any documents of which you are an administrator and any corresponding files associated with the document.</strong></p>
                            <hr class="mb-3">
                            <form action="inc/delete_document.inc.php?doc_id=<?php echo $doc_id ?>&admin=true" method="post" class=" d-flex justify-content-between align-items-center">
                                <a href="edit_profile.php" class="btn btn-outline-secondary">Go Back</a>
                                <button type="submit" name="submit" class="btn btn-dark" >Delete</button>
                            </form>
                        </div>
                    </div>   
                </div>
            </div>
            <?php
        }
    }else{ 
        header("Location: index.php");
        exit();
    }
}
?>
<?php include "inc/footer.php" ?>
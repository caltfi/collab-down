<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3">
<?php    
    if(isset($_SESSION['user_full_name'])){
        ?>
        <div class="row">
            <h2 class="text-center mt-3 mb-3" style='font-family:"Courier New",Courier,monospace; font-weight:bold;'>Your Documents</h2>
            <hr>
        <?php
        $username = $_SESSION['username'];
        $query = "SELECT * FROM documents WHERE documents_admin = '$username'";
        $prep_stat = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($prep_stat, $query)) {
            echo "Error: " . mysqli_error($connection);
        }
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);
        while($row = mysqli_fetch_assoc($result)){
            $title        = $row['documents_title'];
            $doc_id       = $row['documents_id'];
            $admin        = $row['documents_admin'];
            $date_created = $row['documents_date'];

            //query to get * from file where files_document_id = $doc_id
            $query     = "SELECT * FROM files WHERE files_document_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($prep_stat, $query)) {
                echo "Error: " . mysqli_error($connection);
            }
            mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
            mysqli_stmt_execute($prep_stat);
            $result2 = mysqli_stmt_get_result($prep_stat);

            $total_word_count = get_total_word_count($result2);

            mysqli_stmt_close($prep_stat);

            //get user count
            $query     = "SELECT DISTINCT files_assign_uid FROM files WHERE files_document_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($prep_stat, $query)) {
                echo "Error: " . mysqli_error($connection);
            }
            mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
            mysqli_stmt_execute($prep_stat);
            $result3    = mysqli_stmt_get_result($prep_stat);

            $user_count = mysqli_num_rows($result3);

            mysqli_stmt_close($prep_stat);
            ?>
                <div class="col ms-2 me-1 mt-3">
                    <div class="card border-top-0 border-dark-subtle shadow-lg mb-5" style="width:25rem; height:32rem;">
                        <img src="assets/spiral.jpg" class="card-img-top" alt="Document" style="border-bottom:medium dashed #8e8e8e;">
                        <div class="card-body mt-3">
                            <h4 class="card-title ms-3" style=" font-family:'Courier New',Courier,monospace; font-weight:bold;"><strong><?php echo $title ?></strong></h4>
                            <h6 class="card-subtitle ms-3">Created by <span class="fst-italic">@<?php echo $admin ?></span> on <span class="fst-italic"><?php echo date('d/m/Y', strtotime($date_created)) ?></span></h6>
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item">This is a short document synopsis, maybe an abstract. TBD.</li>
                                <li class="list-group-item">Word Count: <?php echo $total_word_count ?></li>
                                <li class="list-group-item">No. of Users: <?php echo $user_count ?></li>
                                <li class="list-group-item">Last Updated: 3 days ago</li>
                                <li class="list-group-item"><a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="link-dark link-opacity-25-hover">Edit Document</a><br></li>
                                <li class="list-group-item"><a href="view_document.php?doc_id=<?php echo $doc_id ?>" class="link-dark link-opacity-25-hover">View Document</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
        }
    }else{
        ?>
        <div class="col">
            <h1 class='text-center mt-5 mb-5'>Welcome to #Collabdown!</h1>
            <h2 class='text-center mb-5'><strong>Log-In</strong> to get started.</h2>
            <div class="text-center" style="margin-top: 35px; margin-right: 580px;">
                <img src='assets/arrow.jpg' height="200" style="transform: rotate(-45deg); opacity: 0.6;" alt='Arrow'>
            </div>
            </div>
        <?php
    }
?>
</div>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>
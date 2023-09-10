<!-- DB Connection + Header + Libraries -->
<?php include "inc/db.php"; ?>
<?php include "inc/header.php"; ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3 overflow-y-scroll" style="max-height: 100vh;">
<?php    
    if(isset($_GET['error'])){
        if($_GET['error'] == "none"){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> You have created a new document.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }elseif($_GET['error'] == "stmtfail"){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Something went wrong!</strong> Please try again.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
    }
    if(isset($_GET['doc'])){
        if($_GET['doc'] == "del"){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> You have deleted a document.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }elseif($_GET['doc'] == "left"){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> You have left a document.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
    }
    if(isset($_SESSION['user_full_name'])){
        ?>
        <div class="row">
            <h2 class="text-center mt-3 mb-5">Your Documents</h2>
        <?php
        $username = $_SESSION['username'];

        foreach($documents as $document){

            if($document['documents_no_sections'] > 0){
                //get max files_date_updated and number of flags for the document
                $query = "SELECT files_date_updated FROM files WHERE files_document_id = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($prep_stat, $query)){
                    header("Location: index.php?error=stmtfail");
                    exit();
                }
                mysqli_stmt_bind_param($prep_stat, "i", $document['documents_id']);
                mysqli_stmt_execute($prep_stat);
                $result = mysqli_stmt_get_result($prep_stat);

                //get latest date
                $updated_dates = array();

                while($row = mysqli_fetch_assoc($result)){
                    array_push($updated_dates, $row['files_date_updated']);
                }
                
                if(!empty($updated_dates)){
                    $most_recent_date = max($updated_dates);
                }else{
                $most_recent_date = $document['documents_date'];
                }

                mysqli_stmt_close($prep_stat);
                
                }
            ?>
                <div class="col ms-2 me-1 mt-3 mb-4">
                    <div class="card border-top-0 border-dark-subtle shadow-lg mb-5 ms-5" style="width:25rem; height:35rem;">
                        <img src="assets/images/spiral.jpg" class="card-img-top" alt="Document" style="border-bottom:medium dashed #8e8e8e;">
                        <div class="card-body mt-3">
                            <h4 class="card-title ms-3"><strong><?php 
                            if(strlen($document['documents_title']) > 25){
                                echo substr($document['documents_title'], 0, 25) . '...';
                            }else{
                                echo $document['documents_title'];
                            }
                            ?></strong></h4>
                            <h6 class="card-subtitle ms-3">Created by <span class="fst-italic">@<?php echo $document['documents_admin'] ?></span> on <span class="fst-italic"><?php echo date("D j M, Y", strtotime($document['documents_date'])) ?></span></h6>
                            <ul class="list-group list-group-flush">
                                <?php 
                                if($document['documents_no_sections'] > 0){
                                    ?>
                                    <li class="list-group-item">Last Updated: <?php echo date("D j M, Y", strtotime($most_recent_date)) ?></li>
                                    <li class="list-group-item"><h6><strong><?php echo $document['documents_no_sections'] ?></strong> sections</h6></li>
                                    <li class="list-group-item"><h6><strong><?php echo $document['total_word_count'] ?></strong> words</h6></li>
                                    <li class="list-group-item"><h6><strong>Something</strong> else</h6></li>
                                    <li class="list-group-item mb-2"><h6><strong>Etce</strong>tera</h6></li>
                                    <?php 
                                }else{
                                    ?>
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <li class="list-group-item mb-2">
                                    <?php
                                }
                                ?>
                                <li class="list-group-item mb-2">
                                <a href="edit_document.php?doc_id=<?php echo $document['documents_id'] ?>" class="btn btn-outline-dark d-flex justify-content-center align-items-center"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                    Edit
                                </a>
                                </li>
                                
                                <?php
                                    if($document['documents_no_sections'] > 0){ 
                                        ?>
                                        <li class="list-group-item mb-2">
                                        <a href='view_document.php?doc_id=<?php echo $document['documents_id'] ?>' class="btn btn-outline-dark d-flex justify-content-center align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill me-2" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                            </svg>
                                            View
                                        </a> 
                                        </li> 
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
        }
        ?>
            <div class="col ms-2 me-1 mt-3 mb-4">
                <div class="card border-top-0 border-dark-subtle shadow-lg mb-5 ms-5" style="width:25rem; height:35rem;">
                    <img src="assets/images/spiral.jpg" class="card-img-top" alt="Document" style="border-bottom:medium dashed #8e8e8e;">
                    <a href="" class="text-body link-underline link-underline-opacity-0" id="new_doc_main_button"><div class="card-body mt-3">
                        <p class="card-text text-center mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg mt-5" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                            </svg>
                            <h3 class="text-center">Create New Document</h3>
                        </p>
                    </div></a>

                    <form action="inc/new_document.inc.php" id="new_doc_form_2" method="post" class="text-white mb-2 text-center" style="display: none;">
                        <input type="text" name="title" id="title_text_input_2" placeholder="Title..." style="width: 300px;"  autocomplete="off">
                    </form>
                </div>
            </div>
        <?php
    }else{
        ?>
        <div class="row">
        <div class="col">
            <h1 class='text-center mt-5 mb-5'>Welcome to</h1>
            <div class="d-flex justify-content-center">
                <img src="./assets/images/logo_black.png" alt="Collabdown Logo" height="150">
            </div>
            <h2 class='text-center mb-5'><strong>Log-In</strong> to get started.</h2>
            <div class="text-center" style="margin-top: 35px; margin-right: 580px;">
                <img src='assets/images/arrow.jpg' height="200" style="transform: rotate(-45deg); opacity: 0.6;" alt='Arrow'>
            </div>
        </div>
        <?php
    }
?>
</div>
</main>
<!-- Footer -->
<?php include "inc/footer.php"; ?>
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
        }
    }
    if(isset($_SESSION['user_full_name'])){
        ?>
        <div class="row">
            <h2 class="text-center mt-3 mb-3">Your Documents</h2>
            <hr>
        <?php
        $username = $_SESSION['username'];

        foreach($documents as $document){
            ?>
                <div class="col ms-2 me-1 mt-3 mb-4">
                    <div class="card border-top-0 border-dark-subtle shadow-lg mb-5 ms-5" style="width:25rem; height:35rem;">
                        <img src="assets/spiral.jpg" class="card-img-top" alt="Document" style="border-bottom:medium dashed #8e8e8e;">
                        <div class="card-body mt-3">
                            <h4 class="card-title ms-3"><strong><?php echo $document['documents_title'] ?></strong></h4>
                            <h6 class="card-subtitle ms-3">Created by <span class="fst-italic">@<?php echo $document['documents_admin'] ?></span> on <span class="fst-italic"><?php echo date('d/m/Y', strtotime($document['documents_date'])) ?></span></h6>
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item">This is a short document synopsis, maybe an abstract. TBD.</li>
                                <li class="list-group-item">Word Count: <?php echo $document['total_word_count'] ?></li>
                                <li class="list-group-item">No. of Users: <?php echo $document['user_count'] ?></li>
                                <li class="list-group-item">Last Updated: 3 days ago</li>
                                <li class="list-group-item"><a href="edit_document.php?doc_id=<?php echo $document['documents_id'] ?>" class="link-dark link-opacity-25-hover">Edit Document</a><br></li>
                                <?php
                                    if($document['documents_no_sections'] > 0){ 
                                        ?>
                                        <li class="list-group-item"><a href="view_document.php?doc_id=<?php echo $document['documents_id'] ?>" class="link-dark link-opacity-25-hover">View Document</a></li>
                                        <?php
                                    }
                                    if($document['documents_admin'] == $username){
                                        echo "<li class='list-group-item'><a href='delete.php?doc_id={$document['documents_id']}' class='link-dark link-opacity-25-hover'>Delete Document</a></li>";
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
                    <img src="assets/spiral.jpg" class="card-img-top" alt="Document" style="border-bottom:medium dashed #8e8e8e;">
                    <a href="" class="text-body link-underline link-underline-opacity-0" id="new_doc_main_button"><div class="card-body mt-3">
                        <p class="card-text text-center mt-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg mt-5" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                            </svg>
                            <h3 class="text-center">Create New Document</h3>
                        </p>
                    </div></a>

                    <form action="inc/new_document.inc.php" id="new_doc_form_2" method="post" class="text-white mb-2 text-center" style="display: none;">
                        <input type="text" name="title" id="title_text_input_2" placeholder="Title..." style="width: 300px;">
                    </form>
                </div>
            </div>
        <?php
    }else{
        ?>
        <div class="row">
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
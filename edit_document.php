<?php include "inc/header.php" ?>
<main class="flex-grow-1 p-3 overflow-y-scroll" style="max-height:100vh;">
<?php
if(isset($_GET['error'])){
    if($_GET['error'] == "none"){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You have added sections to your document.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }elseif($_GET['error'] == "stmtfail"){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Something went wrong!</strong> Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
}
if(isset($_GET['save'])){
    if($_GET['save'] == "success"){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your changes have been saved.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }elseif($_GET['save'] == "error"){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Something went wrong!</strong> Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
}
//document id from url
$doc_id = $_GET['doc_id'];

if(isset($_SESSION['username'])){
    $session_username = $_SESSION['username'];
    
    foreach($documents as $document){
        if($document['documents_id'] == $doc_id){
            //using the doc_id to get the document info
            $title = $document['documents_title'];
            $date_created = $document['documents_date'];
            $total_word_count = $document['total_word_count'];
            $total_user_count = $document['user_count'];
            $sections = $document['documents_no_sections'];
            $admin = $document['documents_admin'];

            $admin_info = get_admin_info($admin, $connection);

            if($sections > 0){    
                ?>
                <div class="row d-flex justify-content-center mb-2 align-items-start">
                    <div class="col-2">
                    </div>
                    <div class="col-8 mt-3">
                        <div class="row">
                            <div class="col">
                                <h1 class="pb-2 ms-2"><?php echo $title; ?></h1>
                                <h5 class="border-bottom pb-2 ms-2 text-muted">Created by <?php echo $admin_info[0] ?> <em>@<?php echo $admin ?></em> on <?php echo date("d/m/Y", strtotime($date_created)) ?></h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-muted d-flex align-items-center">
                                        <img src="assets/<?php echo $admin_info[1] ?>" alt="Profile Picture for <?php echo $admin_info[0] ?>" class="rounded-circle me-2 border border-2" width="40" height="40">
                                       <span><h5>Document Admin:<br><strong><?php echo $admin_info[0] ?></strong></h5></span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <span class="badge text-bg-light p-2 me-4"><h5><strong><?php echo $sections ?></strong> sections</h5></span>
                                        <span class="badge text-bg-light p-2 me-4"><h5><strong><?php echo $total_word_count ?></strong> words</h5></span>
                                        <span class="badge text-bg-light p-2"><h5><strong><?php echo $total_user_count ?></strong> users</h5></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <a href='view_document.php?doc_id=<?php echo $doc_id ?>' class="text-body link-underline link-underline-opacity-0">
                            <h3>View
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                            </svg>
                            </h3>
                        </a>
                    </div>
                </div>
                <?php
                //Below is everything relating to each section
                // Get the files based on the document id
                $query     = "SELECT * FROM files WHERE files_document_id = ?;";
                $prep_stat = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($prep_stat, $query)) {
                    header("Location: edit_document.php?doc_id={$doc_id}&error=stmtfail");
                    exit();
                }
                mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
                mysqli_stmt_execute($prep_stat);
                $result = mysqli_stmt_get_result($prep_stat);
                while($row = mysqli_fetch_assoc($result)){
                    $file_id        = $row['files_id'];
                    $title          = $row['files_title'];
                    $username       = $row['files_assign_uid'];
                    $date_created   = $row['files_date_created'];
                    $date_updated   = $row['files_date_updated'];
                    $section_number = $row['files_section_number'];

                    //query to get user profile pic and full name from users table where users_uid = $username
                    $query = "SELECT users_profile_pic, users_name FROM users WHERE users_uid = ?;";
                    $prep_stat = mysqli_stmt_init($connection);
                    if(!mysqli_stmt_prepare($prep_stat, $query)){
                        header("Location: edit_document.php?doc_id={$doc_id}&error=stmtfail");
                        exit();
                    }
                    mysqli_stmt_bind_param($prep_stat, "s", $username);
                    mysqli_stmt_execute($prep_stat);
                    $result2 = mysqli_stmt_get_result($prep_stat);
                    $row2 = mysqli_fetch_assoc($result2);

                    $user_prof_pic  = $row2['users_profile_pic'];
                    $user_full_name = $row2['users_name'];

                    //get file content
                    $file_path      = "./mdfiles/{$file_id}.md";
                    $file_content   = file_get_contents($file_path);

                    //get word count just for section
                    $word_count = str_word_count($file_content, 0);
                    ?>
                    <div class="row d-flex justify-content-center mb-3 align-items-start">
                        <div class="col-2">
                            <div class="card p-4 mt-4">
                                <img src="assets/<?php echo $user_prof_pic ?>" alt="Profile Picture for <?php echo $user_full_name ?>" class="rounded-circle me-2 border border-4" width="70" height="70">
                                <strong><?php echo $user_full_name ?></strong>
                                <p class="fs-6">@<?php echo $username ?></p>
                                <hr>
                                <p><h4><?php echo $title ?></h4> Section <?php echo $section_number ?></p>
                                <p><h4><?php echo date("d/m/Y", strtotime($date_updated)) ?></h4> Last Updated</p>
                                <p><h4><?php echo $word_count ?> words</h4> Word Count</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <form action="inc/edit_document.inc.php" method="post">
                            <label for="md_content" aria-label="Markdown Text Goes Here"></label>
                            <textarea 
                            name="md_content" 
                            class="form-control border-2 rounded-2" 
                            id="md_content" 
                            cols="30" rows="25" 
                            placeholder="Markdown Text Here" 
                            <?php if($session_username != $username){echo "value='Disabled readonly input' disabled readonly";}?>
                            ><?php echo $file_content ?></textarea>
                        </div>
                        <div class="col-2">
                            <div class="card p-4 mt-4">
                            <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                            <input type="hidden" name="file_id" value="<?php echo $file_id ?>">
                            <?php 
                                if($session_username == $username){
                                ?>
                                <button type="submit" name="save-submit" class="btn btn-outline-secondary align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                    </svg>
                                    Save
                                </button>
                                <hr>
                                <button type="submit" name="delete-submit" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                    Delete
                                </button>
                                <?php 
                                }elseif($session_username == $admin){
                                ?>
                                <button type="submit" name="delete-submit" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                    Delete
                                </button>
                                <?php
                                }
                            ?>                
                            </form>
                            </div>
                        </div>
                    </div>
                <?php
                }

                //Section creation form at end if admin
                if($session_username == $admin){
                    $section_count = $sections + 1;
                    ?> 
                    <!-- Section creation form -->
                    <form action="create_files.inc.php" method="post">
                    <div class="sectionContainer">
                        <div class="row d-flex justify-content-center mb-3 align-items-start section">
                            <div class="col-2">
                                <div class="card p-4 mt-4">
                                    <h3 class="text-center">Section <?php echo $section_count ?></h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card p-4 mt-4">
                                <label for="title<?php echo $section_count ?>" class="mb-3" aria-label="Title"></label>
                                <input type="text" name="title<?php echo $section_count ?>" id="title<?php echo $section_count ?>" class="form-control mb-3" placeholder="Title...">
                                <label for="user<?php echo $section_count ?>" class="mb-3" aria-label="User"></label>
                                <input type="text" name="user<?php echo $section_count ?>" id="user<?php echo $section_count ?>" class="form-control mb-3" placeholder="User...">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card p-4 mt-4">
                                <button type="button" class="btn btn-outline-danger delete-section-button" style="display: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                    </svg>
                                    Delete
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-3 align-items-start">
                        <div class="col-10">
                            <div class="card p-4 mt-4">
                            <a href="" class="text-body link-underline link-underline-opacity-0"><p class="card-text text-center" id="create_section_button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                </svg>
                                <h3 class="text-center">Create New Section</h3>
                            </p></a>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-5 align-items-start">
                        <div class="col-10">
                            <div class="card p-4 mt-4 mb-5">
                            <input type="submit" name="submit" class="btn btn-lg btn-outline-secondary" value="Add Sections to Document">
                            </div>
                        </div>
                    </div>
                    </form>
                    <?php
                }
            }elseif($sections == 0){
                //include "inc/assign_sections.inc.php";
                ?>
                <div class="row d-flex align-items-center">
                    <div class="col-10 d-flex justify-content-center">
                        <h1><?php echo $title; ?></h1>
                    </div>
                    <hr>
                </div>
                <!-- Section creation form -->
                <form action="inc/create_files.inc.php" method="post">
                                <!-- SECTION CONTAINER-->
                                <div class="sectionContainer">
                                <div class="row d-flex justify-content-center mb-3 align-items-start section">
                                    <div class="col-2">
                                        <div class="card p-4 mt-4">
                                            <h3 class="text-center">Section 1</h3>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card p-4 mt-4">
                                            <label for="title1" class="mb-3" aria-label="Title"></label>
                                            <input type="text" name="title1" id="title1" class="form-control mb-3" placeholder="Title...">
                                            <label for="user1" class="mb-3" aria-label="User"></label>
                                            <input type="text" name="user1" id="user1" class="form-control mb-3" placeholder="User...">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="card p-4 mt-4">
                                            <button type="button" class="btn btn-outline-danger delete-section-button" style="display: none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END SECTION CONTAINER-->

                            <div class="row d-flex justify-content-center mb-3 align-items-start">
                                <div class="col-6">
                                    <div class="card p-4 mt-4">
                                        <a href="" class="text-body link-underline link-underline-opacity-0"><p class="card-text text-center" id="create_section_button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                            </svg>
                                            <h3 class="text-center">Create New Section</h3>
                                        </p></a>
                                    </div>
                                </div>
                            </div>
                    <div class="row d-flex justify-content-center mb-3 align-items-start">
                        <div class="col-6">
                            <div class="card p-4 mt-4">
                                <p class="card-text text-center">
                                <input type="submit" name="submit" class="btn btn-lg btn-outline-secondary w-50" value="Add Sections to Document">
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
            }
        }
    }
}

if(isset($_GET['error'])){
    if($_GET['error'] == "stmtfail"){
        echo "<p class='text-center'>Something went wrong, please try again!</p>";
    }elseif($_GET['error'] == "none"){
        echo "<p class='text-center'>Your changes have been saved!</p>";
    }
}
?>
</main>
<?php include "inc/footer.php" ?>
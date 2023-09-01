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
    //document id from url
    $doc_id = $_GET['doc_id'];

    if(isset($_SESSION['username'])){
        $session_username = $_SESSION['username'];

    //using the doc_id get the document title and no of sections
    $query = "SELECT * FROM documents WHERE documents_id = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        header("Location: index.php");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    
    $row      = mysqli_fetch_assoc($result);
    $title    = $row['documents_title'];
    $sections = $row['documents_no_sections'];
    $admin    = $row['documents_admin'];

    // Get the files based on the document id
    $query     = "SELECT * FROM files WHERE files_document_id = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        header("Location: index.php");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);

    $document_word_count = 0;
    $users               = array();

    if($sections == 0){
        include "inc/assign_sections.inc.php";
    }else{
?>
<!-- Title -->
<div class="row d-flex align-items-center">
    <div class="col-10 d-flex justify-content-center">
        <h1><?php echo $title; ?></h1>
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
    <hr>
</div>
<?php
    //Below is everything relating to each section
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
        if (!mysqli_stmt_prepare($prep_stat, $query)) {
            header("Location: edit_document.php?error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $username);
        mysqli_stmt_execute($prep_stat);
        $result2 = mysqli_stmt_get_result($prep_stat);
        $row2 = mysqli_fetch_assoc($result2);

        $user_prof_pic  = $row2['users_profile_pic'];
        $user_full_name = $row2['users_name'];

        //add username to array users if not already in array
        if(!in_array($username, $users)){
            array_push($users, $username);
        }

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
                    <?php
                    if($session_username != $username){
                        echo "value='Disabled readonly input' disabled readonly";
                    }
                    ?>
                    ><?php echo $file_content ?></textarea>
            </div>
            <div class="col-2">
                <div class="card p-4 mt-4">
                <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                <input type="hidden" name="md_file" value="<?php echo $file_path ?>">
                <?php 
                    if($session_username == $username || $session_username == $admin){
                    ?>
                    <input type="submit" name="save-submit" class="btn btn-outline-secondary" value="Save"><hr>
                    <input type="submit" name="delete-submit" class="btn btn-outline-danger" value="Delete">
                    <?php 
                    }
                ?>                
                </form>
                </div>
            </div>
        </div>
        <?php
        $document_word_count += $word_count;
    }
        //count no of usernames in users array
        $no_of_users = count($users);

        if($session_username == $admin){
            ?>    
            <!-- Section creation form -->
            <form action="create_files.inc.php" method="post">
            <div class="sectionContainer">
                <div class="row d-flex justify-content-center mb-3 align-items-start">
                    <div class="col-2">
                        <div class="card p-4 mt-4">
                            <h3 class="text-center">Section <?php echo $section_number + 1 ?></h3>
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
                        <input type="submit" name="delete-submit" class="btn btn-outline-danger" value="Delete">
                        </form>
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
            <div class="row d-flex justify-content-center mb-3 align-items-start">
                <div class="col-10">
                    <div class="card p-4 mt-4">
                    <input type="submit" name="submit" class="btn btn-lg btn-outline-secondary" value="Add Sections to Document">
                    </div>
                </div>
            </div>
            </form>
            <?php
        }
?>
<hr>
<p class="fw-light text-center">No. of sections: <?php echo $sections ?></p>
<p class="fw-light text-center">No. of contributors: <?php echo $no_of_users ?></p>
<p class="fw-light text-center mb-5">Word count: <?php echo $document_word_count ?></p><br>
<button href="view_document.php?doc_id=<?php echo $doc_id ?>" class="btn btn-outline-secondary w-100" style="font-family:'Courier New',Courier,monospace;">View</button>
<?php
    }}
    mysqli_stmt_close($prep_stat);

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
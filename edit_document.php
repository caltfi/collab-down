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
                //Title, doc info and stats  
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
                                        <img 
                                        <?php 
                                            if(file_exists("assets/user_prof/{$admin}/{$admin_info[1]}")){
                                                echo "src='assets/user_prof/{$admin}/{$admin_info[1]}'";
                                            }else{
                                                echo "src='assets/user_prof/profile.jpg'";
                                            }
                                        ?> 
                                        alt="Profile Picture for <?php echo $admin_info[0] ?>" class="rounded-circle me-2 border border-2" width="40" height="40">
                                       <span><h5>Document Admin:<br><strong><?php echo $admin_info[0] ?></strong></h5></span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <span class="badge text-bg-light p-2 me-4"><h5><strong><?php echo $sections ?></strong> sections</h5></span>
                                        <span class="badge text-bg-light p-2 me-4"><h5><strong><?php echo $total_word_count ?></strong> words</h5></span>
                                        <span class="badge text-bg-light p-2 me-4"><h5><strong><?php echo $total_user_count ?></strong> users</h5></span>
                                        <span class="badge text-bg-light p-2"><h5><strong><?php echo 0 ?></strong> flags</h5></span>
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
                //get the files based on the document id
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
                                <img
                                <?php 
                                    if(file_exists("assets/user_prof/{$username}/{$user_prof_pic}")){
                                        echo "src='assets/user_prof/{$username}/{$user_prof_pic}'";
                                    }else{
                                        echo "src='assets/user_prof/profile.jpg'";
                                    }
                                ?> 
                                alt="Profile Picture for <?php echo $user_full_name ?>" class="rounded-circle me-2 border border-4" width="70" height="70">
                                <strong><?php echo $user_full_name ?></strong>
                                <p class="fs-6">@<?php echo $username ?></p>

                                <!-- EDIT ASSIGNED USER FORM -->
                                <form action="inc/edit_section.inc.php" id="change_user_form" method="post" class="text-white mb-2 text-center" style="display: none;">
                                    <label for="section_user" class="mb-3" aria-label="Change Assigned User"></label>    
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                                        <input type="hidden" name="admin" value="<?php echo $admin ?>">
                                        <input type="hidden" name="file_id" value="<?php echo $file_id ?>">
                                        <input type="hidden" name="section_number" value="<?php echo $section_number ?>">
                                        <input type="text" name="section_user" id="section_user_input" class="form-control" list="datalistOptions" placeholder="Change Users...">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <datalist id="datalistOptions">
                                        <?php 
                                        //query to return all users from users table
                                        $query = "SELECT * FROM users";
                                        $result3 = mysqli_query($connection, $query);
                                        if(!$result3){
                                            header("Location: edit_document.php?doc_id={$doc_id}&error=stmtfail");
                                        }
                                        $count = mysqli_num_rows($result3);
                    
                                        if($count == 0){
                                            echo "<li>No Results</li>";
                                        }else{
                                            while($row3 = mysqli_fetch_assoc($result3)){
                                                $all_users = $row3['users_uid'];

                                                echo "<option value='{$all_users}'>";
                                            } 
                                        }  
                                        ?>
                                    </datalist>
                                </form>
                                <hr>
                                <!-- EDIT SECTION TITLE FORM -->
                                <form action="inc/edit_section.inc.php" id="change_section_title_form" method="post" class="text-white mb-2 text-center" style="display: none;">
                                    <label for="section_title" class="mb-3" aria-label="Change Section Title"></label>
                                    <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                                    <input type="hidden" name="admin" value="<?php echo $admin ?>">
                                    <input type="hidden" name="file_id" value="<?php echo $file_id ?>">
                                    <input type="hidden" name="section_number" value="<?php echo $section_number ?>">   
                                    <input type="text" name="section_title" id="section_title_input" placeholder="Change Title..." class="form-control">
                                </form>
                                
                                <p><h4><?php echo $title ?></h4> Section <?php echo $section_number ?></p>
                                <p><h4><?php echo date("D j M, Y", strtotime($date_updated)) ?></h4> Last Updated</p>
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
                                include "inc/edit_buttons.inc.php";
                            ?>                
                            </form>
                            </div>
                        </div>
                    </div>
                <?php
                }

                if($session_username == $admin){
                    //Section addition form at end if the user is the document admin
                    $section_count_plusone = $sections + 1;
                    include "inc/add_sections.inc.php";
                }
            }elseif($sections == 0){
                //empty document, show section creation form
                include "inc/assign_sections.inc.php";
            }
        }
    }
}
?>
</main>
<?php include "inc/footer.php" ?>
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
    }elseif($_GET['error'] == 'invalidtitle'){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Invalid Title!</strong> Titles must contain valid characters only. Please try again.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }elseif($_GET['error'] == 'invaliduser'){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Invalid User!</strong> Please assign a valid user to the section.
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
if(isset($_GET['section'])){
    if($_GET['section'] == "flagged"){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You have flagged a document section.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }elseif($_GET['section'] == "approved"){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You have approved a document section.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }elseif($_GET['section'] == "changed"){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You have changed a document section.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }elseif($_GET['section'] == "deleted"){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You have deleted a document section.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
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

            //get max files_date_updated and number of flags for the document
            $query = "SELECT files_date_updated, files_status FROM files WHERE files_document_id = ?;";
            $prep_stat = mysqli_stmt_init($connection);
            if(!mysqli_stmt_prepare($prep_stat, $query)){
                header("Location: index.php?error=stmtfail");
                exit();
            }
            mysqli_stmt_bind_param($prep_stat, "i", $document['documents_id']);
            mysqli_stmt_execute($prep_stat);
            $result = mysqli_stmt_get_result($prep_stat);

            //get number of flags
            $flags = 0;
            $updated_dates = array();

            while($row = mysqli_fetch_assoc($result)){
                if($row['files_status'] == "flagged"){
                    $flags++;
                }
            
                array_push($updated_dates, $row['files_date_updated']);
            }
            
            if(!empty($updated_dates)){
                $most_recent_date = max($updated_dates);
            }else{
                $most_recent_date = $date_created;
            }

            mysqli_stmt_close($prep_stat);

            $admin_info = get_admin_info($admin, $connection);

            if($sections > 0){  
                //Title, doc info and stats  
                ?>
                <div class="row d-flex justify-content-center mb-3 align-items-start">
                    <div class="col-8">
                    <div class="card p-4 mt-4">
                        <div class="row">
                            <div class="col">
                                <h1 class="pb-2 ms-2"><?php echo $title; ?></h1>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><h5>Created: <?php echo date("D j M, Y", strtotime($date_created)) ?></h5></li>
                                    <?php 
                                    if($sections> 0){
                                        ?>
                                        <li class="list-group-item"><h5>Last Updated: <?php echo date("D j M, Y", strtotime($most_recent_date)) ?></h5></li>
                                        <?php
                                    }
                                    ?>
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
                                        <span class="badge text-bg-light p-2"><h5><strong><?php echo $flags ?></strong> flags</h5></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-2"> 
                        <div class="card p-4 mt-4"> 
                        <a href='view_document.php?doc_id=<?php echo $doc_id ?>' class="btn btn-dark d-flex justify-content-center align-items-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill me-2" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                            View
                        </a>                       
                        <?php
                        if($session_username == $admin){
                            ?>
                            <button type="button" id="change_document_button" class="btn btn-outline-secondary d-flex justify-content-center align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill me-2" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                </svg>
                                Change
                            </button>
                            <hr>

                            <a href="delete.php?doc_id=<?php echo $doc_id ?>" id="delete-submit" class="btn btn-outline-danger d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill me-2" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                                Delete
                            </a>
                            
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                //Below is everything relating to each section
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
                    $date_created   = $row['files_date_created'];
                    $date_updated   = $row['files_date_updated'];
                    $section_number = $row['files_section_number'];
                    $status         = $row['files_status'];
                    
                    $username       = $row['files_assign_uid'];

                    $user = user_name_exists($connection, $username, $username, 'edit_document');
                    if($user === false){
                        header("Location: index.php?error=stmtfail");
                        exit();
                    }

                    $user_prof_pic  = $user['users_profile_pic'];
                    $user_full_name = $user['users_name'];

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
                                                $all_users_name = $row3['users_name'];
                                                $all_users_uid  = $row3['users_uid'];

                                                echo "<option value='{$all_users_uid}'>{$all_users_name} {$all_users_uid}</option>";
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
                                <p><h4><?php 
                                    if($status == "approved"){
                                        ?>
                                        <span class="badge bg-success-subtle text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill me-2" viewBox="0 0 16 16">
                                                <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                            </svg>
                                            Approved
                                        </span>
                                        <?php
                                    }elseif($status == "pending"){
                                        ?>
                                        <span class="badge bg-secondary-subtle text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill me-2" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                            </svg>
                                            Pending
                                        </span>
                                        <?php
                                    }elseif($status == "flagged"){
                                        ?>
                                        <span class="badge bg-warning-subtle text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill me-2" viewBox="0 0 16 16">
                                                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
                                            </svg>
                                            Flagged
                                        </span>
                                        <?php
                                    }
                                ?></h4> Status</p>
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
                            <?php 
                                include "inc/edit_buttons.inc.php";
                            ?>                
                            </div>
                        </div>
                    </div>
                <?php
                }

                if($session_username == $admin){
                    //Section addition form at end if the user is the document admin
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
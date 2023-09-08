<?php include "inc/header.php" ?>
<!-- Main Content -->
<main class="flex-grow-1 p-3 overflow-y-scroll" style="max-height:100vh;">
<?php
require_once "libs/Parsedown.php";
$doc_id = $_GET['doc_id'];

foreach($documents as $document){
    if($document['documents_id'] == $doc_id){
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
        
        $most_recent_date = max($updated_dates);

        mysqli_stmt_close($prep_stat);

        $admin_info = get_admin_info($admin, $connection);

        $users_info = get_all_user_info_document($doc_id, $connection);
        ?>
        <!-- Card with Title, information, print, go back to edit and email buttons -->
        <div class="row d-flex justify-content-center mb-3 align-items-start">
            <div class="col-8">
                <div class="card p-2 mt-4">
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
                            <span class="badge text-bg-light p-2"><h5><strong><?php echo $total_user_count ?></strong> users</h5></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-2">
                <div class="card p-4 mt-4">
                    <a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="btn btn-dark d-flex justify-content-center align-items-center mb-3"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="email_document.php" class="d-flex justify-content-center align-items-center mb-3">
                        <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                        <button class="btn btn-outline-dark d-flex justify-content-center align-items-center w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill me-2" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg>
                            E-mail
                        </button>
                    </form>
                    <button class="btn btn-outline-dark d-flex justify-content-center align-items-center mb-3" onclick="window.print()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill me-2" viewBox="0 0 16 16">
                            <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                            <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        Print
                    </button>
                    <button class="btn btn-outline-dark d-flex justify-content-center align-items-center mb-3" onclick="window.save()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Save
                    </button>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-10 border p-5 shadow">
        <?php
        //Parsed Document
        //get files from DB where files_document_id = $doc_id
        $query     = "SELECT * FROM files WHERE files_document_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query)){
            echo "Error: " . mysqli_error($connection);
        }
        mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
        mysqli_stmt_execute($prep_stat);
        $result = mysqli_stmt_get_result($prep_stat);

        //display each parsed markdown file in the order of their section number
        while($row = mysqli_fetch_assoc($result)){
            $file_id = $row['files_id'];
            $status = $row['files_status'];
            $section_number = $row['files_section_number'];
            $title = $row['files_title'];

            $md_file = "mdfiles/{$file_id}.md";

            //display parsed markdown document
            if(is_readable($md_file)){
                if($status == 'approved'){

                    if(empty(file_get_contents($md_file))){
                        ?>
                        <div class="container-fluid rounded p-3 mt-4 mb-4" style="background: var( --bs-secondary-bg); border: 5px var(--bs-border-color) solid;">
                            <h3 class="text-center mb-3"><?php echo $title?></h3>
                            <p class='text-center'><strong>File is empty.</strong> There is no content to display in this section.</p>
                        </div>
                        <?php
                    }
                    //Parse and display file
                    $Parsedown = new Parsedown();
                    $Parsedown -> setSafeMode(true);
                    echo $Parsedown->text(file_get_contents($md_file));
                }elseif($status == 'flagged'){
                    ?>
                    <div class="container-fluid bg-warning-subtle rounded p-3 mt-4 mb-4" style="border: 5px var(--bs-warning-border-subtle) solid">
                        <h3 class="text-center mb-3"><?php echo $title?></h3>
                        <p class='text-center'><strong>Section has been flagged.</strong> This section has not been approved yet by the document admin.</p>
                    </div>
                    <?php
                }elseif($status == 'pending'){
                    ?>
                    <div class="container-fluid rounded p-3 mt-4 mb-4" style="background: var( --bs-secondary-bg); border: 5px var(--bs-border-color) solid;">
                        <h3 class="text-center mb-3"><?php echo $title?></h3>
                        <p class='text-center'><strong>Status is pending.</strong> This section is awaiting action from the document admin.</p>
                    </div>
                    <?php
                }
            }else{
                echo "<p class='text-center'>Error, File is not readable!</p>";
            }
        }
    }
}
?>
</div>
</div>
</main>
<?php include "inc/footer.php" ?>
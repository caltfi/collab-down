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
        ?>
        <!-- Card with Title, information, print, go back to edit and email buttons -->
        <div class="row d-flex justify-content-center mb-3 align-items-start">
            <div class="col-2 p-4">
                <a href="edit_document.php?doc_id=<?php echo $doc_id ?>" class="text-body link-underline link-underline-opacity-0">
                    <h3>  
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                        <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                    </svg>
                    Edit
                    </h3>  
                </a>
            </div>
            <div class="col-8 border p-5 shadow-sm mb-3 mt-3">
                <div class="row">
                    <div class="col-10">
                        <h1 class="border-bottom pb-2 ms-2"><?php echo $title; ?></h1>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-muted">Created On: <?php echo date("d/m/Y", strtotime($date_created)) ?></li>
                            <li class="list-group-item text-muted">Current Version: <?php echo date("d/m/Y", time()) ?></li>
                            <li class="list-group-item text-muted">Word Count: <?php echo $total_word_count ?> words</li>
                            <li class="list-group-item text-muted">No. of Users: <?php echo $total_user_count ?></li>
                            <li class="list-group-item text-muted">No. of Sections: <?php echo $sections ?></li>
                        </ul>
                    </div>
                    <div class="col-2">
                        <div class="d-grid gap-2 mx-auto">
                            <h6 class="text-center text-muted pb-2 border-bottom">Actions</h6>
                        <form action="email_document.php">
                            <input type="hidden" name="doc_id" value="<?php echo $doc_id ?>">
                            <button class="btn btn-outline-secondary w-100 m-2" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill me-2" viewBox="0 0 16 16">
                                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                </svg>
                                Email
                            </button>
                        </form>
                        <button class="btn btn-outline-secondary w-100 m-2" onclick="window.print()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill me-2" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                            Print
                        </button>
                        <button class="btn btn-outline-secondary w-100 m-2" onclick="window.save()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download me-2" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                            </svg>
                            Save
                        </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
            </div>
        </div>
        <div class="row d-flex justify-content-center mb-3 align-items-start">
        <div class="col-8 border p-5 shadow">
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
            $md_file = "mdfiles/{$file_id}.md";
            //display parsed markdown document
            if(is_readable($md_file)){
                //Parse and display file
                $Parsedown = new Parsedown();
                $Parsedown -> setSafeMode(true);
                echo $Parsedown->text(file_get_contents($md_file));
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
<?php include "inc/header.php" ?>
<main class="flex-grow-1 p-3 overflow-y-scroll" style="max-height:100vh;">
<?php
    //document id from url
    $doc_id         = $_GET['doc_id'];

    //using the doc_id get the document title and no of sections
    $query = "SELECT documents_title, documents_no_sections FROM documents WHERE documents_id = ?;";
    $prep_stat = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($prep_stat, $query)) {
        header("Location: index.php");
        exit();
    }
    mysqli_stmt_bind_param($prep_stat, "i", $doc_id);
    mysqli_stmt_execute($prep_stat);
    $result = mysqli_stmt_get_result($prep_stat);
    
    $row = mysqli_fetch_assoc($result);
    $title = $row['documents_title'];
    $sections = $row['documents_no_sections'];

    if($sections == 0){
        include "inc/assign_sections.inc.php";
    }else{
?>
<!-- Title -->
<div class="row d-flex align-items-center">
    <div class="col-10 d-flex justify-content-center">
        <h1 style="font-family:'Courier New',Courier,monospace;"><?php echo $title; ?></h1>
    </div>
    <div class="col-2 d-flex justify-content-center">
        <a href='view_document.php?doc_id=<?php echo $doc_id ?>' class="text-body link-underline link-underline-opacity-0" style='font-family:"Courier New",Courier,monospace;'>
            <h1>View
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
            </svg>
            </h1>
        </a>
    </div>
    <hr>
</div>
<?php
    // Get the file id
    $query = "SELECT * FROM files WHERE files_document_id = ?;";
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

    //Below is everything relating to each section
    while($row = mysqli_fetch_assoc($result)){
        $section_number = $row['files_section_number'];
        $date_created   = $row['files_date_created'];
        $date_updated   = $row['files_date_updated'];
        $file_id        = $row['files_id'];
        $username       = $row['files_assign_uid'];

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
                    <p><h4>Title</h4> Section <?php echo $section_number ?></p>
                    <p><h4><?php echo date("d/m/Y", strtotime($date_updated)) ?></h4> Last Updated</p>
                    <p><h4><?php echo $word_count ?> words</h4> Word Count</p>
                </div>
            </div>
            <div class="col-6">
                <form action="inc/edit_document.inc.php" method="post">
                    <div class="row">
                        <div class="col-12">
                            <label for="mdContent" aria-label="Markdown Text Goes Here"></label>
                            <textarea name="mdContent" class="form-control border-2 rounded-2" id="mdContent" cols="30" rows="25" placeholder="Markdown Text Here" style="font-family:'Courier New',Courier,monospace;"><?php echo $file_content ?></textarea>
                        </div>
                        <div class="col-3 m-2">
                            <input class="btn btn-outline-secondary w-100" style="font-family:'Courier New',Courier,monospace;" type="submit" name="submit" value="Save">
                        </div>
                        <div class="col-3 m-2">
                            <a href='view_document.php?doc_id=<?php echo $doc_id ?>' class='btn btn-outline-secondary w-100' style='font-family:"Courier New",Courier,monospace;'>View</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $document_word_count += $word_count;
    }
    //count no of usernames in users array
    $no_of_users = count($users);
    echo"<hr>";
    echo "<p class='fw-light text-center'>No. of sections: {$sections} sections</p>";
    echo "<p class='fw-light text-center'>No. of contributors: {$no_of_users} users</p>";
    echo "<p class='fw-light text-center mb-5'>Word count: {$document_word_count} words</p><br>";
    echo "<button href='view_document.php?doc_id={$doc_id}' class='btn btn-outline-secondary w-100' style='font-family:\"Courier New\",Courier,monospace;'>View</button>";
    mysqli_stmt_close($prep_stat);
}
?>
</main>
<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "stmtfail"){
            echo "<p class='text-center'>Something went wrong, please try again!</p>";
        }
    }
?>
<?php include "inc/footer.php" ?>
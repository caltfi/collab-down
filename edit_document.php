<?php include "inc/header.php" ?>
<main class="flex-grow-1 p-3  overflow-y-scroll">
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

        //session variables
        $username       = $_SESSION['username'];
        $user_prof_pic  = $_SESSION['user_prof_pic'];
        $user_full_name = $_SESSION['user_full_name'];
    ?>
<!-- Markdown Form -->
<h1 class="text-center"><?php echo $title; ?></h1>
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
        while($row = mysqli_fetch_assoc($result)){
            $section_number = $row['files_section_number'];
            $date_created = $row['files_date_created'];
            $date_updated = $row['files_date_updated'];
            $file_id = $row['files_id'];

            $file_path = "./mdfiles/{$file_id}.md";

            // Get the content of the file
            $file_content = file_get_contents($file_path);

            //get word count from file
            $word_count = str_word_count($file_content, 0);
            ?>
            <div class="row d-flex justify-content-center mb-3">
                <div class="col-2">
                    <div class="card p-4">
                        <img src="assets/<?php echo $user_prof_pic ?>" alt="Profile Picture for <?php echo $user_full_name ?>" class="rounded-circle me-2 border border-4" width="60" height="60">
                        <strong><?php echo $user_full_name ?></strong>
                        <p class="fs-6">@<?php echo $username ?></p>
                        <hr>
                        <p class="fs-6">Section <?php echo $section_number ?></p>
                        <p>Last Updated: <?php echo $date_updated ?></p>
                        <p>Word Count: <?php print_r($word_count) ?> words</p>
                    </div>
                </div>
                <div class="col-6">
                    <form action="inc/edit_document.inc.php" method="post">
                        <div class="row">
                            <div class="col-12">
                            <label for="mdContent" aria-label="Markdown Text Goes Here"></label>
                            <textarea name="mdContent" class="form-control" id="mdContent" cols="30" rows="15" placeholder="Markdown Text Here"><?php echo $file_content ?></textarea>
                            </div>
                            <div class="col-3 m-2">
                            <input class="btn btn-dark w-100" type="submit" name="submit" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
?>
</main>
<?php include "inc/footer.php" ?>
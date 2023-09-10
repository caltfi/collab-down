<?php
if($status == "flagged"){
    ?>
    <hr>
    <h5 class="card-title text-center mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="var(--bs-warning)" class="bi bi-flag-fill me-2" viewBox="0 0 16 16">
                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
            </svg>
            Comments
        </h5>
    <div style="overflow: auto; max-height:350px; min-height:350px;">
        
        <?php
        //make query from comments table
        $query_comments = "SELECT * FROM comments WHERE comments_file_id = ?;";
        $prep_stat = mysqli_stmt_init($connection);
        if(!mysqli_stmt_prepare($prep_stat, $query_comments)){
            header("Location: ../edit_document.php?doc_id={$doc_id}&error=stmtfail");
            exit();
        }
        mysqli_stmt_bind_param($prep_stat, "s", $file_id);
        mysqli_stmt_execute($prep_stat);
        $result_comments = mysqli_stmt_get_result($prep_stat);
        //if there are no comments then display nothing
        if(mysqli_num_rows($result_comments) == 0){
            echo "<h5 class='text-center'>No comments yet.</h5>";
        }
        while($row_comments = mysqli_fetch_assoc($result_comments)){
            $comment_author = $row_comments['comments_author_uid'];
            $comment_date   = $row_comments['comments_date'];
            $comment_content= $row_comments['comments_content'];
            ?>
            <div class="card p-2 mb-3 border rounded border-warning me-2">
            <div class="card-body">
                <p class="card-text"><?php echo $comment_content ?></p>
                <hr>
                <h6 class="card-subtitle mb-2 text-body">@<?php echo $comment_author ?></h6>
                <h6 class="card-subtitle text-body-secondary"><?php echo date("D j M, Y", strtotime($comment_date)) ?></h6>
            </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
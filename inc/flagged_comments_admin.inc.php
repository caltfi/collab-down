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
            $comment_id     = $row_comments['comments_id'];
            ?>
            <div class="card p-2 mb-3 border rounded border-warning me-2">
            <div class="card-body">
                <p class="card-text"><?php echo $comment_content ?></p>
                <hr>
                <h6 class="card-subtitle mb-2 text-body">@<?php echo $comment_author ?></h6>
                <h6 class="card-subtitle text-body-secondary mb-2"><?php echo date("D j M, Y", strtotime($comment_date)) ?></h6>
                <a href="" class="btn btn-outline-secondary d-flex align-items-center justify-content-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill me-2" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                    </svg>
                    Edit
                </a>
                <a href="inc/delete_comment.inc.php?doc_id=<?php echo $doc_id ?>&comment=<?php echo $comment_id ?>" class="btn btn-outline-danger d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill me-2" viewBox="0 0 16 16">
                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg>
                    Delete
                </a>
            </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}